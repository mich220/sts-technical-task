<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\Enum\WalletTransactionType;
use App\Wallet\Domain\Exception\CannotWithdrawFundsFromWalletException;
use App\Wallet\Domain\Specification\WithdrawFundsFromWalletSpecification;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity, Index(columns: ['id', 'bank_account_id'], name: 'wallet_search_idx')]
class Wallet
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private $id;

    #[ManyToOne(targetEntity: BankAccount::class, inversedBy: 'wallets')]
    #[JoinColumn(name: 'bank_account_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private BankAccount $bankAccount;

    #[Column(type: 'integer')]
    private $balance;

    #[OneToMany(mappedBy: 'wallet', targetEntity: WalletTransaction::class, cascade: ['persist', 'remove'])]
    private Collection $walletTransactions;

    #[Column(type: 'datetime_immutable')]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->walletTransactions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWalletTransactions(): Collection
    {
        return $this->walletTransactions;
    }

    public function setBankAccount(?BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function addFunds(int $amount): void
    {
        $this->balance += $amount;
        $walletTransaction = (new WalletTransaction())
            ->setWallet($this)
            ->setType(WalletTransactionType::DEPOSIT)
            ->setAmount($amount);
        $this->walletTransactions->add($walletTransaction);
    }

    public function withdrawFunds(int $amount): void
    {
        $walletBalanceSpecification = new WithdrawFundsFromWalletSpecification($amount);
        if (!$walletBalanceSpecification->isSatisfiedBy($this)) {
            throw new CannotWithdrawFundsFromWalletException();
        }

        $this->balance -= $amount;
        $walletTransaction = (new WalletTransaction())
            ->setWallet($this)
            ->setType(WalletTransactionType::WITHDRAW)
            ->setAmount($amount);
        $this->walletTransactions->add($walletTransaction);
    }
}

<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\Collection\WalletTransactionHistoryCollection;
use App\Wallet\Domain\Exception\WalletNotFoundException;
use App\Wallet\Infrastructure\Repository\BankAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

// Aggregate
#[Entity(repositoryClass: BankAccountRepository::class)]
class BankAccount
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private int $id;

    #[OneToMany(mappedBy: 'bankAccount', targetEntity: Wallet::class, cascade: ['persist', 'remove'])]
    private Collection $wallets;

    public function __construct()
    {
        $this->wallets = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWallets(): Collection
    {
        return $this->wallets;
    }

    public function createWallet(): Wallet
    {
        $wallet = new Wallet();
        $wallet->setBankAccount($this);
        $wallet->setBalance(0);
        $this->wallets->add($wallet);

        return $wallet;
    }

    public function addFundsToWallet($walletId, $amount)
    {
        $wallet = $this->findWalletById($walletId);

        $wallet->addFunds($amount);
    }

    public function withdrawFundsFromWallet(int $walletId, int $amount): void
    {
        $wallet = $this->findWalletById($walletId);

        $wallet->withdrawFunds($amount);
    }

    public function generateTransactionHistory(int $walletId): WalletTransactionHistoryCollection
    {
        $wallet = $this->findWalletById($walletId);
        $transactionHistory = new WalletTransactionHistoryCollection();

        foreach ($wallet->getWalletTransactions() as $walletTransaction) {
            $transactionHistory->add($walletTransaction);
        }

        return $transactionHistory;
    }

    private function findWalletById($walletId): Wallet
    {
        foreach ($this->wallets as $wallet) {
            if ($wallet->getId() === $walletId) {
                return $wallet;
            }
        }

        throw new WalletNotFoundException();
    }
}

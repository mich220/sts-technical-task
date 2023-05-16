<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\Enum\WalletTransactionType;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity, Index(fields: ['type', 'wallet_id'], name: 'wallet_transaction_search_idx')]
class WalletTransaction
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private $id;

    #[ManyToOne(targetEntity: Wallet::class, inversedBy: 'transactions')]
    #[JoinColumn(name: 'wallet_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Wallet $wallet;

    #[Column(type: 'integer')]
    private $amount;

    #[Column(type: 'integer', enumType: WalletTransactionType::class)]
    private $type;

    #[Column(type: 'datetime_immutable')]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): WalletTransactionType
    {
        return $this->type;
    }

    public function setType(WalletTransactionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

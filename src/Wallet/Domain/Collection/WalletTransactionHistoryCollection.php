<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Collection;

use App\Wallet\Domain\Collection\Iterator\WalletTransactionHistoryIterator;
use App\Wallet\Domain\Entity\WalletTransaction;

class WalletTransactionHistoryCollection implements \Countable, \IteratorAggregate
{
    /** @var WalletTransaction[] */
    private array $walletTransactions = [];

    public function add(WalletTransaction $walletTransaction): void
    {
        $this->walletTransactions[] = $walletTransaction;
    }

    /**
     * @return WalletTransaction[]
     */
    public function getWalletTransactions(): array
    {
        return $this->walletTransactions;
    }

    public function getIterator(): \Traversable
    {
        return new WalletTransactionHistoryIterator($this);
    }

    public function count(): int
    {
        return count($this->walletTransactions);
    }
}

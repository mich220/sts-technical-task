<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Collection\Iterator;

use App\Wallet\Domain\Collection\WalletTransactionHistoryCollection;

class WalletTransactionHistoryIterator implements \Iterator
{
    private array $walletTransactionHistoryCollection = [];

    private int $position;

    public function __construct(WalletTransactionHistoryCollection $walletTransactionHistoryCollection)
    {
        $this->walletTransactionHistoryCollection = $walletTransactionHistoryCollection->getWalletTransactions();
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->position < count($this->walletTransactionHistoryCollection);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function current(): mixed
    {
        return $this->walletTransactionHistoryCollection[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }
}

<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Repository;

use App\Wallet\Domain\Collection\WalletTransactionHistoryCollection;

interface TransactionHistoryRepositoryInterface
{
    public function save(WalletTransactionHistoryCollection $transactionHistory): void;
}

<?php

declare(strict_types=1);

namespace App\Wallet\Infrastructure\Repository\Csv;

use App\Wallet\Domain\Collection\WalletTransactionHistoryCollection;
use App\Wallet\Domain\Entity\WalletTransaction;
use App\Wallet\Domain\Repository\TransactionHistoryRepositoryInterface;

readonly class CsvTransactionHistoryRepository implements TransactionHistoryRepositoryInterface
{
    public function __construct(private string $csvFilePath)
    {
    }

    public function save(WalletTransactionHistoryCollection $transactionHistory): void
    {
        if (0 === count($transactionHistory)) {
            return;
        }

        if (!is_dir($this->csvFilePath)) {
            $this->createCsvDirectory();
        }

        $fp = fopen($this->createFileName($transactionHistory), 'w');
        fputcsv($fp, ['amount', 'type', 'created_at']);
        /** @var WalletTransaction $walletTransaction */
        foreach ($transactionHistory as $walletTransaction) {
            fputcsv($fp, [
                'amount' => $walletTransaction->getAmount(),
                'type' => $walletTransaction->getType()->value,
                'created_at' => $walletTransaction->getCreatedAt()->format('Y-m-d H:i:s'),
            ]);
        }
        fclose($fp);
    }

    private function createCsvDirectory()
    {
        if (!mkdir($this->csvFilePath, 0777, true)) {
            throw new \RuntimeException(\sprintf('Directory "%s" was not created', $this->csvFilePath));
        }
    }

    private function createFileName(WalletTransactionHistoryCollection $transactionHistory): string
    {
        return \sprintf(
            '%s/wallet_%s_history.csv',
            $this->csvFilePath,
            $transactionHistory->getWalletTransactions()[0]?->getWallet()?->getId() ?? uniqid()
        );
    }
}

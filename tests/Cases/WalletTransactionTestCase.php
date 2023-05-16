<?php

declare(strict_types=1);

namespace App\Tests\Cases;

use App\Wallet\Domain\Entity\BankAccount;
use App\Wallet\Domain\Enum\WalletTransactionType;
use App\Wallet\Infrastructure\Repository\BankAccountRepository;

class WalletTransactionTestCase extends BaseWebTestCase
{
    public function createWallet(int $balance): array
    {
        $bankAccountRepository = $this->getService(BankAccountRepository::class);

        $bankAccount = new BankAccount();
        $wallet = $bankAccount->createWallet();
        $wallet->setBalance($balance);
        $bankAccountRepository->save($bankAccount);

        return [$bankAccount, $wallet];
    }

    public function assertWalletTransactionSuccessful(int $bankAccountId, int $walletBalance, int $transactionAmount, WalletTransactionType $transactionType): void
    {
        $bankAccountRepository = $this->getService(BankAccountRepository::class);

        $bankAccount = $bankAccountRepository->find($bankAccountId);
        $wallets = $bankAccount->getWallets();
        $this->assertCount(1, $wallets);

        $wallet = $wallets->first();
        $this->assertEquals($walletBalance, $wallet->getBalance());

        $transactions = $wallet->getWalletTransactions();
        $this->assertCount(1, $transactions);

        $walletTransaction = $transactions->first();
        $this->assertEquals($transactionAmount, $walletTransaction->getAmount());
        $this->assertEquals($transactionType, $walletTransaction->getType());
    }
}

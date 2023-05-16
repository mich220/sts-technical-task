<?php

declare(strict_types=1);

namespace App\Wallet\Application\Service;

use App\Wallet\Domain\Collection\WalletTransactionHistoryCollection;
use App\Wallet\Domain\Entity\BankAccount;
use App\Wallet\Domain\Exception\BankAccountNotFoundException;
use App\Wallet\Domain\Repository\BankAccountRepositoryInterface;

readonly class BankAccountService
{
    public function __construct(private BankAccountRepositoryInterface $bankAccountRepository)
    {
    }

    public function createWallet(int $bankAccountId): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($bankAccountId);

        if (null === $bankAccount) {
            throw new BankAccountNotFoundException();
        }

        $bankAccount->createWallet();

        $this->bankAccountRepository->save($bankAccount);
    }

    public function depositFundsToWallet(int $bankAccountId, int $walletId, int $amount): void
    {
        $this->bankAccountRepository->begin();

        try {
            /** @var BankAccount $bankAccount */
            $bankAccount = $this->bankAccountRepository->find($bankAccountId);

            if (null === $bankAccount) {
                throw new BankAccountNotFoundException();
            }

            $bankAccount->addFundsToWallet($walletId, $amount);

            $this->bankAccountRepository->save($bankAccount);

            $this->bankAccountRepository->commit();
        } catch (\Exception $e) {
            $this->bankAccountRepository->rollBack();
            throw $e;
        }
    }

    public function withdrawFundsFromWallet(int $bankAccountId, int $walletId, int $amount): void
    {
        $this->bankAccountRepository->begin();

        try {
            /** @var BankAccount $bankAccount */
            $bankAccount = $this->bankAccountRepository->find($bankAccountId);

            if (null === $bankAccount) {
                throw new \Exception('Bank account not found.');
            }

            $bankAccount->withdrawFundsFromWallet($walletId, $amount);

            $this->bankAccountRepository->save($bankAccount);

            $this->bankAccountRepository->commit();
        } catch (\Exception $e) {
            $this->bankAccountRepository->rollBack();
            throw $e;
        }
    }

    public function generateTransactionHistory(int $bankAccountId, $walletId): WalletTransactionHistoryCollection
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($bankAccountId);
        if (null === $bankAccount) {
            throw new \Exception('Bank account not found.');
        }

        return $bankAccount->generateTransactionHistory($walletId);
    }
}

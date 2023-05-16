<?php

declare(strict_types=1);

namespace App\Wallet\Application\MessageHandler;

use App\Wallet\Application\Message\GenerateTransactionHistoryCommand;
use App\Wallet\Application\Service\BankAccountService;
use App\Wallet\Domain\Repository\TransactionHistoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GenerateTransactionHistoryCommandHandler
{
    public function __construct(
        private BankAccountService $bankAccountService,
        private TransactionHistoryRepositoryInterface $transactionHistoryRepository
    ) {
    }

    public function __invoke(GenerateTransactionHistoryCommand $command): void
    {
        $transactionHistory = $this->bankAccountService->generateTransactionHistory($command->accountId, $command->walletId);

        $this->transactionHistoryRepository->save($transactionHistory);
    }
}

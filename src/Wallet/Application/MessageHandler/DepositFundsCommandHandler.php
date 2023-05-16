<?php

declare(strict_types=1);

namespace App\Wallet\Application\MessageHandler;

use App\Wallet\Application\Message\DepositFundsCommand;
use App\Wallet\Application\Service\BankAccountService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DepositFundsCommandHandler
{
    public function __construct(private BankAccountService $bankAccountService)
    {
    }

    public function __invoke(DepositFundsCommand $command): void
    {
        $this->bankAccountService->depositFundsToWallet(
            $command->accountId,
            $command->walletId,
            $command->amount
        );
    }
}

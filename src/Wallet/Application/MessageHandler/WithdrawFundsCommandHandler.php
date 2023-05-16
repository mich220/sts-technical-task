<?php

declare(strict_types=1);

namespace App\Wallet\Application\MessageHandler;

use App\Wallet\Application\Message\WithdrawFundsCommand;
use App\Wallet\Application\Service\BankAccountService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class WithdrawFundsCommandHandler
{
    public function __construct(private BankAccountService $bankAccountService)
    {
    }

    public function __invoke(WithdrawFundsCommand $command): void
    {
        $this->bankAccountService->withdrawFundsFromWallet(
            $command->accountId,
            $command->walletId,
            $command->amount
        );
    }
}

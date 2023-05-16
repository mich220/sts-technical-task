<?php

declare(strict_types=1);

namespace App\Wallet\Application\MessageHandler;

use App\Wallet\Application\Message\CreateWalletCommand;
use App\Wallet\Application\Service\BankAccountService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateWalletCommandHandler
{
    public function __construct(private BankAccountService $bankAccountService)
    {
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $this->bankAccountService->createWallet($command->accountId);
    }
}

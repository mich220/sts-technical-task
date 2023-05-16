<?php

declare(strict_types=1);

namespace App\Wallet\UI\Controller;

use App\Shared\Controller\AbstractController;
use App\Shared\Messenger\CommandBus;
use App\Shared\Response\StsJsonResponse;
use App\Wallet\Application\Message\WithdrawFundsCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WithdrawFundsController extends AbstractController
{
    #[Route('/account/{accountId}/wallet/{walletId}/withdraw', name: 'wallet.withdraw', methods: ['PUT'])]
    public function update(int $accountId, int $walletId, CommandBus $commandBus, Request $request): StsJsonResponse
    {
        $updateWalletCommand = new WithdrawFundsCommand(
            $accountId,
            $walletId,
            $request->toArray()['amount']
        );

        $commandBus->dispatch($updateWalletCommand);

        return $this->jsonResponse()->createSuccessMessage('', StsJsonResponse::HTTP_OK);
    }
}

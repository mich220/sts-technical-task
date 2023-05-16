<?php

declare(strict_types=1);

namespace App\Wallet\UI\Controller;

use App\Shared\Controller\AbstractController;
use App\Shared\Messenger\CommandBus;
use App\Shared\Messenger\QueryBus;
use App\Shared\Response\StsJsonResponse;
use App\Wallet\Application\Message\CreateWalletCommand;
use App\Wallet\Application\Message\FindWalletQuery;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account/{accountId}/wallet')]
class WalletController extends AbstractController
{
    #[Route(name: 'wallet.create', methods: ['POST'])]
    public function create(int $accountId, CommandBus $commandBus): StsJsonResponse
    {
        $createWalletCommand = new CreateWalletCommand($accountId);

        $commandBus->dispatch($createWalletCommand);

        return $this->jsonResponse()->createSuccessMessage('', StsJsonResponse::HTTP_CREATED);
    }

    #[Route('/{walletId}', name: 'wallet.find', methods: ['GET'])]
    public function find(int $accountId, int $walletId, QueryBus $queryBus): StsJsonResponse
    {
        $data = $queryBus->dispatch(new FindWalletQuery($accountId, $walletId));

        return $this->jsonResponse()->createSuccessMessage($data);
    }
}

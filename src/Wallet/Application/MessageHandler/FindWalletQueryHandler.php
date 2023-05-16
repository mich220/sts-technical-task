<?php

declare(strict_types=1);

namespace App\Wallet\Application\MessageHandler;

use App\Wallet\Application\Message\FindWalletQuery;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class FindWalletQueryHandler
{
    public function __construct(private WalletRepositoryInterface $walletRepository)
    {
    }

    public function __invoke(FindWalletQuery $query): array
    {
        $wallet = $this->walletRepository->findOneByParameters([
            'id' => $query->walletId,
            'bankAccount' => $query->accountId,
        ]);

        return [
            'balance' => $wallet->getBalance(),
        ];
    }
}

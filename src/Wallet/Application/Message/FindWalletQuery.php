<?php

declare(strict_types=1);

namespace App\Wallet\Application\Message;

use App\Shared\Messenger\SyncMessageInterface;

readonly class FindWalletQuery implements SyncMessageInterface
{
    public function __construct(public int $accountId, public int $walletId)
    {
    }
}

<?php

declare(strict_types=1);

namespace App\Wallet\Application\Message;

readonly class CreateWalletCommand
{
    public function __construct(public int $accountId)
    {
    }
}

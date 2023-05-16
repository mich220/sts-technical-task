<?php

declare(strict_types=1);

namespace App\Wallet\Application\Message;

readonly class WithdrawFundsCommand
{
    public function __construct(
        public int $accountId,
        public int $walletId,
        public int $amount
    ) {
    }
}

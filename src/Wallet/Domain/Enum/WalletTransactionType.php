<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Enum;

enum WalletTransactionType: int
{
    case DEPOSIT = 1;
    case WITHDRAW = 2;
}

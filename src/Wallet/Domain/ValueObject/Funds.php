<?php

declare(strict_types=1);

namespace App\Wallet\Domain\ValueObject;

readonly class Funds
{
    public function __construct(
        public int $amount,
        public Currency $currency
    ) {
    }
}

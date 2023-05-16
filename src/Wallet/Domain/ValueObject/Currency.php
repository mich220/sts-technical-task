<?php

declare(strict_types=1);

namespace App\Wallet\Domain\ValueObject;

readonly class Currency
{
    public function __construct(public string $code)
    {
    }
}

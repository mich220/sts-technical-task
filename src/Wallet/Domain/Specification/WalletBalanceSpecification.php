<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Specification;

readonly class WalletBalanceSpecification implements SpecificationInterface
{
    public function __construct(private int $amount)
    {
    }

    public function isSatisfiedBy($candidate): bool
    {
        return $candidate->getBalance() - $this->amount >= 0;
    }
}

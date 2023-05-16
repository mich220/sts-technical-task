<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Specification;

class WithdrawFundsFromWalletSpecification implements SpecificationInterface
{
    private SpecificationInterface $walletBalanceSpecification;

    public function __construct(int $amount)
    {
        $this->walletBalanceSpecification = new WalletBalanceSpecification($amount);
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if ($this->walletBalanceSpecification->isSatisfiedBy($candidate)) {
            return true;
        }

        return false;
    }
}

<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(mixed $candidate): bool;
}

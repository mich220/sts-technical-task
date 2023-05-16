<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Repository;

use App\Wallet\Domain\Entity\Wallet;

interface WalletRepositoryInterface
{
    public function save(Wallet $wallet): void;

    public function findOneByParameters(array $parameters): ?Wallet;
}

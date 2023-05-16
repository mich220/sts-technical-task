<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Repository;

use App\Wallet\Domain\Entity\BankAccount;

interface BankAccountRepositoryInterface
{
    public function save(BankAccount $bankAccount): void;
}

<?php

declare(strict_types=1);

namespace App\Wallet\Infrastructure\Repository\Doctrine;

use App\Shared\Repository\AbstractRepository;
use App\Wallet\Domain\Entity\BankAccount;
use App\Wallet\Domain\Repository\BankAccountRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class BankAccountRepository extends AbstractRepository implements BankAccountRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankAccount::class);
    }

    public function save(BankAccount $bankAccount): void
    {
        $this->_em->persist($bankAccount);
        $this->_em->flush();
    }
}

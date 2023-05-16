<?php

declare(strict_types=1);

namespace App\Wallet\Infrastructure\Repository;

use App\Shared\Repository\AbstractRepository;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Repository\WalletRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class WalletRepository extends AbstractRepository implements WalletRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function save(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();
    }

    public function findOneByParameters(array $parameters): ?Wallet
    {
        return $this->findOneBy($parameters);
    }
}

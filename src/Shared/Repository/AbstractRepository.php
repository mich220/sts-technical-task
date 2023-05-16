<?php

declare(strict_types=1);

namespace App\Shared\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AbstractRepository extends ServiceEntityRepository
{
    public function begin(?string $connectionName = null): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function rollback(?string $connectionName = null): void
    {
        $this->getEntityManager()->rollback();
    }

    public function commit(?string $connectionName = null): void
    {
        $this->getEntityManager()->commit();
    }
}

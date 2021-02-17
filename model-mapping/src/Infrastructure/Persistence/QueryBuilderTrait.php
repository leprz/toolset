<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

trait QueryBuilderTrait
{
    private EntityManagerInterface $entityManager;

    abstract protected static function entityClass(): string;

    private function createQueryBuilder(string $alias): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()
            ->from(static::entityClass(), $alias)
            ->select(
                $alias
            );
    }
}

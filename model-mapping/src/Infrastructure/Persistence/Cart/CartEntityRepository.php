<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cart;

use App\Application\Persistence\Cart\CartPersistenceInterface;
use App\Application\Persistence\Cart\CartRepositoryInterface;
use App\Domain\Cart;
use App\Domain\ValueObject\CartId;
use App\Infrastructure\Entity\CartEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CartEntityRepository implements CartRepositoryInterface, CartPersistenceInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    private function createQueryBuilder(string $alias): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()
            ->from(CartEntity::class, $alias)
            ->select(
                $alias
            );
    }

    public function getById(CartId $id): Cart
    {
        $qb = $this->createQueryBuilder('cart');
        $qb->where('cart.id = :id');
        $qb->setParameters(
            [
                'id' => (string)$id
            ]
        );

        return new CartProxy($qb->getQuery()->getSingleResult(), $this->entityManager);
    }

    public function removeById(CartId $id): void
    {
        $qb = $this->createQueryBuilder('cart');
        $qb->delete();
        $qb->where('cart.id = :id');
        $qb->getQuery()->execute(
            [
                'id' => $id
            ]
        );
    }
}

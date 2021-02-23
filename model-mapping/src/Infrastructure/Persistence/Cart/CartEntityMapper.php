<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cart;

use App\Domain\Cart;
use App\Infrastructure\Entity\CartEntity;
use App\Infrastructure\Persistence\EntityMapperTrait;
use Doctrine\ORM\EntityManagerInterface;

class CartEntityMapper
{
    use EntityMapperTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function mapToExistingEntity(
        CartEntity $entity,
        Cart $model,
    ): CartEntity {
        return $this->mapProperties($model, $entity, $this->entityManager);
    }

    public function mapToNewEntity(Cart $cart): CartEntity
    {
        return $this->mapToExistingEntity($this->createNewInstanceWithoutConstructor(CartEntity::class), $cart);
    }
}

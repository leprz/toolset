<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CartLineItem;

use App\Domain\CartLineItem;
use App\Infrastructure\Entity\CartLineItemEntity;
use App\Infrastructure\Persistence\EntityMapperTrait;
use Doctrine\ORM\EntityManagerInterface;

class CartLineItemEntityMapper
{
    use EntityMapperTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function mapToNewEntity(CartLineItem $lineItem): CartLineItemEntity
    {
        return $this->mapToExistingEntity(
            $this->createNewInstanceWithoutConstructor(CartLineItemEntity::class),
            $lineItem
        );
    }

    public function mapToExistingEntity(
        CartLineItemEntity $entity,
        CartLineItem $lineItem,
    ): CartLineItemEntity {
        return $this->mapProperties($lineItem, $entity, $this->entityManager);
    }
}

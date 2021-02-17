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

    public function mapToNewEntity(CartLineItem $lineItem, EntityManagerInterface $entityManager): CartLineItemEntity
    {
        return $this->mapToExistingEntity(new CartLineItemEntity(), $lineItem, $entityManager);
    }

    public function mapToExistingEntity(
        CartLineItemEntity $entity,
        CartLineItem $lineItem,
        EntityManagerInterface $entityManager,
    ): CartLineItemEntity {
        return $this->mapProperties($lineItem, $entity, $entityManager);
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CartLineItem;

use App\Domain\CartLineItem;
use App\Infrastructure\Entity\CartLineItemEntity;
use Doctrine\ORM\EntityManagerInterface;

class CartLineItemProxy extends CartLineItem
{
    public function __construct(private CartLineItemEntity $entity)
    {
        parent::__construct(
            $this->entity
        );
    }

    public function getEntity(
        CartLineItemEntityMapper $mapper,
        EntityManagerInterface $entityManager
    ): CartLineItemEntity {
        return $mapper->mapToExistingEntity($this->entity, $this, $entityManager);
    }
}

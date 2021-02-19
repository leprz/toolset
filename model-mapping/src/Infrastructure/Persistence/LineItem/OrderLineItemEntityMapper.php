<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\LineItem;

use App\Domain\OrderLineItem;
use App\Infrastructure\Entity\OrderLineItemEntity;
use App\Infrastructure\Persistence\EntityMapperTrait;
use Doctrine\ORM\EntityManagerInterface;

class OrderLineItemEntityMapper
{
    use EntityMapperTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function mapToNewEntity(OrderLineItem $model): OrderLineItemEntity
    {
        return $this->mapToExistingEntity(
            $this->createNewInstanceWithoutConstructor(OrderLineItemEntity::class),
            $model
        );
    }

    public function mapToExistingEntity(OrderLineItemEntity $entity, OrderLineItem $model): OrderLineItemEntity
    {
        return $this->mapProperties($model, $entity, $this->entityManager);
    }
}

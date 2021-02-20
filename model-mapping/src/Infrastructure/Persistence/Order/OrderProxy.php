<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Order;

use App\Domain\Order;
use App\Infrastructure\Entity\OrderEntity;

class OrderProxy extends Order
{
    public function __construct(private OrderEntity $entity)
    {
        parent::__construct($this->entity);
    }

    public function getEntity(OrderEntityMapper $mapper): OrderEntity
    {
        return $mapper->mapToExistingEntity($this->entity, $this);
    }
}

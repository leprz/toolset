<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Order;

use App\Domain\Order;
use App\Infrastructure\Entity\OrderEntity;
use App\Infrastructure\Persistence\EntityMapperTrait;
use Doctrine\ORM\EntityManagerInterface;

class OrderEntityMapper
{
    use EntityMapperTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function mapToNewEntity(Order $order): OrderEntity
    {
        return $this->mapToExistingEntity(new OrderEntity(), $order);
    }

    public function mapToExistingEntity(OrderEntity $entity, Order $order): OrderEntity
    {
        return $this->mapProperties($order, $entity, $this->entityManager);
    }
}

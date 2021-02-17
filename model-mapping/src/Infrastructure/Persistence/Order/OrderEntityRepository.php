<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Order;

use App\Application\Persistence\Order\OrderPersistenceInterface;
use App\Application\Persistence\Order\OrderRepositoryInterface;
use App\Domain\Order;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\Entity\OrderEntity;
use App\Infrastructure\Persistence\QueryBuilderTrait;
use Doctrine\ORM\EntityManagerInterface;

class OrderEntityRepository implements OrderPersistenceInterface, OrderRepositoryInterface
{
    use QueryBuilderTrait;

    public function __construct(EntityManagerInterface $entityManager, private OrderEntityMapper $mapper)
    {
        $this->entityManager = $entityManager;
    }

    protected static function entityClass(): string
    {
        return OrderEntity::class;
    }

    public function add(Order $order): void
    {
        $this->entityManager->persist(
            $this->mapper->mapToNewEntity($order)
        );
    }

    public function removeById(OrderId $id): void
    {
        $qb = $this->createQueryBuilder('anOrder');
        $qb->delete();
        $qb->where('anOrder.id = :id');
        $qb->getQuery()->execute(
            [
                'id' => (string)$id
            ]
        );
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function getForId(OrderId $id): Order
    {
        $qb = $this->createQueryBuilder('anOrder');
        $qb->where('anOrder.id = :id');
        $qb->setParameters(
            [
                'id' => $id
            ]
        );
        return new OrderProxy($qb->getQuery()->getSingleResult());
    }
}

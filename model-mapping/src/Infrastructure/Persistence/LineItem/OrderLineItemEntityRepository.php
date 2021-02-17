<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\LineItem;

use App\Application\Persistence\OrderLineItem\OrderLineItemPersistenceInterface;
use App\Domain\OrderLineItem;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\Entity\OrderLineItemEntity;
use App\Infrastructure\Persistence\QueryBuilderTrait;
use Doctrine\ORM\EntityManagerInterface;

class OrderLineItemEntityRepository implements OrderLineItemPersistenceInterface
{
    use QueryBuilderTrait;

    public function __construct(EntityManagerInterface $entityManager, private OrderLineItemEntityMapper $mapper)
    {
        $this->entityManager = $entityManager;
    }

    protected static function entityClass(): string
    {
        return OrderLineItemEntity::class;
    }

    public function removeForOrderId(OrderId $id): void
    {
        $qb = $this->createQueryBuilder('lineItem');
        $qb->delete();
        $qb->where('lineItem.order = :orderId');
        $qb->getQuery()->execute(
            [
                'orderId' => (string)$id
            ]
        );
    }

    /**
     * @param \App\Domain\OrderLineItem[] $lineItems
     */
    public function addMany(array $lineItems): void
    {
        foreach ($lineItems as $lineItem) {
            $this->add($lineItem);
        }
    }

    public function add(OrderLineItem $lineItem): void
    {
            $entity = $this->mapper->mapToNewEntity($lineItem);
        $this->entityManager->persist(
            $entity
        );
    }
}

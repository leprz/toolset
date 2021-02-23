<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CartLineItem;

use App\Application\Exception\NotFoundException;
use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemRepositoryInterface;
use App\Domain\CartLineItem;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Infrastructure\Entity\CartLineItemEntity;
use App\Infrastructure\Persistence\Exception\CanNotSaveNotExistingEntityException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\Uuid;

class CartLineItemEntityRepository implements CartLineItemRepositoryInterface, CartLineItemPersistenceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CartLineItemEntityMapper $mapper
    ) {
    }

    private function createQueryBuilder(string $alias): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()->from(CartLineItemEntity::class, $alias)->select(
            $alias
        );
    }

    public function generateNextId(): LineItemId
    {
        return LineItemId::fromString(Uuid::uuid4()->toString());
    }

    public function removeForCartId(CartId $id): void
    {
        $qb = $this->createQueryBuilder('lineItem');
        $qb->delete();
        $qb->where('lineItem.cart = :cartId');
        $qb->getQuery()->execute(
            [
                'cartId' => $id
            ]
        );
    }

    /**
     * @param \App\Domain\ValueObject\CartId $id
     * @return \App\Domain\CartLineItem[]
     */
    public function getForCartId(CartId $id): array
    {
        $qb = $this->createQueryBuilder('lineItem');
        $qb->where('lineItem.cart = :cartId');
        $qb->setParameters(
            [
                'cartId' => (string)$id
            ]
        );

        return array_map(static function(CartLineItemEntity $entity): CartLineItem {
            return new CartLineItemProxy($entity);
        }, $qb->getQuery()->getResult());
    }

    public function remove(LineItemId $id): void
    {
        $qb = $this->createQueryBuilder('lineItem');
        $qb->delete();
        $qb->where('lineItem.id = :id');
        $qb->getQuery()->execute(
            [
                'id' => (string)$id,
            ]
        );
    }

    /**
     * @param \App\Domain\ValueObject\LineItemId $id
     * @return \App\Domain\CartLineItem
     * @throws \App\Application\Exception\NotFoundException
     */
    public function getById(LineItemId $id): CartLineItem
    {
        $qb = $this->createQueryBuilder('lineItem');

        $qb->select('lineItem');
        $qb->where('lineItem.id = :id');

        $qb->setParameters(
            [
                'id' => (string)$id,
            ]
        );

        try {
            return new CartLineItemProxy($qb->getQuery()->getSingleResult());
        } catch (NoResultException | NonUniqueResultException $e) {
            throw new NotFoundException($e->getMessage());
        }
    }

    public function add(CartLineItem $lineItem): void
    {
        $this->entityManager->persist(
            $this->mapper->mapToNewEntity($lineItem)
        );
    }

    public function save(CartLineItem $lineItem): void
    {
        if (!($lineItem instanceof CartLineItemProxy)) {
            throw CanNotSaveNotExistingEntityException::fromEntityName(self::class);
        }

        $this->entityManager->persist(
            $lineItem->getEntity($this->mapper)
        );
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cart;

use App\Domain\Cart;
use App\Infrastructure\Entity\CartEntity;
use Doctrine\ORM\EntityManagerInterface;

class CartProxy extends Cart
{
    public function __construct(private CartEntity $entity, private EntityManagerInterface $entityManager)
    {
        parent::__construct($this->entity);
    }

    public function getEntity(CartEntityMapper $mapper): CartEntity
    {
        return $mapper->mapToExistingEntity($this->entity, $this);
    }
}

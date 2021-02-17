<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cart;

use App\Domain\Cart;
use App\Infrastructure\Entity\CartEntity;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;

class CartProxy extends Cart
{
    /**
     * @noinspection PhpMissingParentConstructorInspection
     * @param \App\Infrastructure\Entity\CartEntity $entity
     */
    public function __construct(private CartEntity $entity, private EntityManagerInterface $entityManager)
    {
        $reflection = new ReflectionClass($this);

        $props = $reflection->getParentClass()->getProperties();
        foreach ($props as $prop) {
            unset($this->{$prop->name});
        }
    }

    public function __isset(string $name): bool
    {
        return property_exists($this, $name);
    }

    public function __set(string $name, mixed $value): void
    {
        $setter = 'set' . ucfirst($name);

        if ($setter === 'setCustomerId') {
            $this->entity->$setter($value, $this->entityManager);
        } else {
            $this->entity->$setter($value);
        }

        $this->$name = $value;
    }

    public function __get(string $name): mixed
    {
        $getter = 'get' . ucfirst($name);
        $this->$name = $this->entity->$getter();
        return $this->$name;
    }

    public function getEntity(): CartEntity
    {
        return $this->entity;
    }
}

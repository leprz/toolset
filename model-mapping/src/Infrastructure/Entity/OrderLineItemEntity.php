<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\Entity\Trait\EntityUuidTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Infrastructure\Entity
 * @ORM\Entity()
 * @ORM\Table(name="customer__order__line_item")
 */
class OrderLineItemEntity
{
    use EntityUuidTrait;

    /**
     * @var \App\Infrastructure\Entity\OrderEntity
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Entity\OrderEntity")
     */
    protected OrderEntity $order;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2)
     */
    protected float $price;

    public function __construct(LineItemId $id, OrderEntity $order, string $name, Money $price)
    {
        $this->setId($id);
        $this->order = $order;
        $this->setName($name);
        $this->setPrice($price);
    }

    public function setId(LineItemId $id): void
    {
        $this->id = (string)$id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price->toFloat();
    }

    public function setOrderId(OrderId $orderId, EntityManagerInterface $entityManager): void
    {
        $this->order = $entityManager->getReference(OrderEntity::class, (string)$orderId);
    }
}

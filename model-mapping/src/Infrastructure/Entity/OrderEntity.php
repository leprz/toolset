<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\Entity\Trait\EntityUuidTrait;
use App\Infrastructure\Entity\Trait\OwnedByCustomerTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Infrastructure\Entity
 * @ORM\Entity()
 * @ORM\Table(name="customer__order")
 */
class OrderEntity
{
    use EntityUuidTrait;

    use OwnedByCustomerTrait;

    /**
     * @ORM\OneToMany(targetEntity="App\Infrastructure\Entity\OrderLineItemEntity", mappedBy="order")
     */
    protected Collection $lineItems;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2)
     */
    protected float $totalPrice = 0;

    public function setId(OrderId $id): void
    {
        $this->id = (string)$id;
    }

    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    public function setBuyerId(CustomerId $id, EntityManagerInterface $entityManager): void
    {
        $this->customer = $entityManager->getReference(CustomerEntity::class, (string)$id);
    }

    public function setTotalPrice(Money $total): void
    {
        $this->totalPrice = $total->toFloat();
    }

    public function getId(): OrderId
    {
        return OrderId::fromString($this->id);
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customer->getId();
    }

    public function getTotalPrice(): Money
    {
        return new Money($this->totalPrice);
    }
}

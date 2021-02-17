<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\CustomerId;
use App\Infrastructure\Entity\Trait\EntityUuidTrait;
use App\Infrastructure\Entity\Trait\OwnedByCustomerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Infrastructure\Entity
 * @ORM\Entity()
 * @ORM\Table(name="customer__cart")
 */
class CartEntity
{
    use EntityUuidTrait;

    use OwnedByCustomerTrait;

    /**
     * @ORM\OneToMany(targetEntity="App\Infrastructure\Entity\CartLineItemEntity", mappedBy="cart")
     */
    protected Collection $lineItems;

    public function __construct(CartId $id, CustomerEntity $customer)
    {
        $this->setId($id);
        $this->setCustomer($customer);
        $this->lineItems =  new ArrayCollection();
    }

    public function setId(CartId $id): void
    {
        $this->id = (string)$id;
    }

    public function setCustomerId(CustomerId $customerId, EntityManagerInterface $entityManager): void
    {
        $this->setCustomer(
            $entityManager->getReference(CustomerEntity::class, (string)$customerId)
        );
    }

    private function setCustomer(CustomerEntity $customer): void
    {
        $this->customer = $customer;
    }

    public function getId(): CartId
    {
        return CartId::fromString($this->id);
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customer->getId();
    }
}

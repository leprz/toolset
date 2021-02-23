<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\Data\CreateCartLineItemDataInterface;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Infrastructure\Entity\Trait\EntityUuidTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Infrastructure\Entity
 * @ORM\Entity()
 * @ORM\Table(name="customer__cart__line_item")
 */
class CartLineItemEntity implements CreateCartLineItemDataInterface
{
    use EntityUuidTrait;

    /**
     * @var \App\Infrastructure\Entity\CartEntity
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Entity\CartEntity")
     */
    protected CartEntity $cart;

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

    public function __construct(LineItemId $id, CartEntity $cart, string $name, Money $price)
    {
        $this->setId($id);
        $this->setCart($cart);
        $this->setName($name);
        $this->setPrice($price);
    }

    /**
     * @param \App\Domain\ValueObject\LineItemId $id
     */
    public function setId(LineItemId $id): void
    {
        $this->id = (string)$id;
    }

    public function getId(): LineItemId
    {
        return LineItemId::fromString($this->id);
    }

    public function setCart(CartEntity $cart): void
    {
        $this->cart = $cart;
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     * @param \App\Domain\ValueObject\CartId $cartId
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function setCartId(CartId $cartId, EntityManagerInterface $entityManager): void
    {
        $this->cart = $entityManager->getReference(CartEntity::class, (string)$cartId);
    }

    public function getCartId(): CartId
    {
        return $this->cart->getId();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param \App\Domain\ValueObject\Money $price
     */
    public function setPrice(Money $price): void
    {
        $this->price = $price->toFloat();
    }

    public function getPrice(): Money
    {
        return new Money($this->price);
    }
}

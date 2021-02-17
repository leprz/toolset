<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;

class CreateCartLineItemData implements CreateCartLineItemDataInterface
{
    protected LineItemId $id;

    protected CartId $cartId;

    protected Money $price;

    private string $name;

    public function __construct(LineItemId $id, CartId $cartId, Money $price, string $name)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->price = $price;
        $this->name = $name;
    }

    public function getId(): LineItemId
    {
        return $this->id;
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }
}

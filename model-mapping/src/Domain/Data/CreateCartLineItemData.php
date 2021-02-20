<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;

class CreateCartLineItemData implements CreateCartLineItemDataInterface
{
    public function __construct(
        private LineItemId $id,
        private CartId $cartId,
        private Money $price,
        private string $name
    ) {
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

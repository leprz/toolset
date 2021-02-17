<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Sku;
use App\UseCase\ProductPlaceInCart\Domain\ProductPlaceInCartDataInterface;

class Product
{
    protected Sku $sku;

    protected string $name;

    protected Money $price;

    private function __construct(Sku $sku, Money $price, string $name)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public static function fromExisting(Sku $sku, Money $price, string $name): self
    {
        return new self($sku, $price, $name);
    }

    public function placeInCart(ProductPlaceInCartDataInterface $data): CartLineItem
    {
        return CartLineItem::placeInCart(
            $data->getLineItemId(),
            $data->getCartId(),
            $this->price,
            $this->name,
        );
    }
}

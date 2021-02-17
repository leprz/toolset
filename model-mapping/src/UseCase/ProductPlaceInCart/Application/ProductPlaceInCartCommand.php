<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Application;

use App\Domain\Product;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\UseCase\ProductPlaceInCart\Domain\ProductPlaceInCartDataInterface;

class ProductPlaceInCartCommand implements ProductPlaceInCartDataInterface
{
    public function __construct(
        private LineItemId $lineItemId,
        private CartId $cartId,
        private Product $product,
    ) {
    }

    public function getLineItemId(): LineItemId
    {
        return $this->lineItemId;
    }


    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}

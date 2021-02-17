<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Domain;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;

interface ProductPlaceInCartDataInterface
{
    public function getLineItemId(): LineItemId;

    public function getCartId(): CartId;
}

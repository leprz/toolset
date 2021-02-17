<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Domain;

use App\Domain\ValueObject\LineItemId;

interface ProductPlaceInCartActionInterface
{
    public function generateNextLineItemId(): LineItemId;
}

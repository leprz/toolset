<?php

declare(strict_types=1);

namespace App\Application\Persistence\Cart;

use App\Domain\Cart;
use App\Domain\ValueObject\CartId;

interface CartRepositoryInterface
{
    public function getById(CartId $id): Cart;
}

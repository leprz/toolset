<?php

declare(strict_types=1);

namespace App\Application\Persistence\Cart;

use App\Domain\ValueObject\CartId;

interface CartPersistenceInterface
{
    public function removeById(CartId $id): void;
}

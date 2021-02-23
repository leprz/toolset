<?php

declare(strict_types=1);

namespace App\Application\Persistence\Cart;

use App\Domain\Cart;
use App\Domain\ValueObject\CartId;

interface CartPersistenceInterface
{
    public function removeById(CartId $id): void;

    public function add(Cart $cart): void;

    public function flush(): void;
}

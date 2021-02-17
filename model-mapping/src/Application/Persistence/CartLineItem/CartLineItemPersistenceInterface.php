<?php

declare(strict_types=1);

namespace App\Application\Persistence\CartLineItem;

use App\Domain\CartLineItem;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;

interface CartLineItemPersistenceInterface
{
    public function generateNextId(): LineItemId;

    public function removeForCartId(CartId $id): void;

    public function remove(LineItemId $id): void;

    public function add(CartLineItem $lineItem): void;

    public function flush(): void;
}

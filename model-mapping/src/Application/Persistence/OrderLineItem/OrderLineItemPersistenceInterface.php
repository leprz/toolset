<?php

declare(strict_types=1);

namespace App\Application\Persistence\OrderLineItem;

use App\Domain\ValueObject\OrderId;

interface OrderLineItemPersistenceInterface
{
    public function addMany(array $lineItems): void;

    public function removeForOrderId(OrderId $id): void;
}

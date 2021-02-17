<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;

class OrderLineItem extends LineItem
{
    public function __construct(LineItemId $id, protected OrderId $orderId, Money $price, string $name)
    {
        parent::__construct($id, $price, $name);
    }
}

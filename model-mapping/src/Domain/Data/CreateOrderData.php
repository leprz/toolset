<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;

class CreateOrderData implements CreateOrderDataInterface
{
    public function __construct(
        private OrderId $id,
        private CustomerId $customerId,
        private Money $totalPrice
    ) {
    }

    public function getId(): OrderId
    {
        return $this->id;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }
}

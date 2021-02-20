<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;

interface CreateOrderDataInterface
{
    public function getId(): OrderId;

    public function getCustomerId(): CustomerId;

    public function getTotalPrice(): Money;
}

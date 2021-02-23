<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\CustomerId;

interface CreateCartDataInterface
{
    public function getId(): CartId;

    public function getCustomerId(): CustomerId;
}

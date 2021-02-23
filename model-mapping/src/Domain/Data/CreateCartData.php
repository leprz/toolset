<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\CustomerId;

class CreateCartData implements CreateCartDataInterface
{
    public function __construct(private CartId $id, private CustomerId $customerId)
    {
    }

    public function getId(): CartId
    {
        return $this->id;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }
}

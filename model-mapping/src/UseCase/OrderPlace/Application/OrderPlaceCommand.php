<?php

declare(strict_types=1);

namespace App\UseCase\OrderPlace\Application;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\OrderId;

class OrderPlaceCommand
{
    public function __construct(private CartId $cartId, private OrderId $orderId)
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }
}

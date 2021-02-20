<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\OrderId;
use App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface;

class Cart
{
    private function __construct(protected CartId $id, protected CustomerId $customerId)
    {
    }

    /**
     * @param \App\Domain\ValueObject\OrderId $orderId
     * @param \App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface $action
     * @return \App\Domain\Order
     * @throws \App\Domain\Exception\EmptyOrderException
     */
    public function placeOrder(OrderId $orderId, OrderPlaceActionInterface $action): Order
    {
        $order = Order::place(
            id: $orderId,
            customerId: $this->customerId,
            lineItems: CartLineItem::orderAll($action->getLineItemsForCart($this->id), $orderId),
            action: $action,
        );

        // It's better to raise OrderHasBeenPlacedEvent and clear cart on the listener
        $action->clearCart($this->id);

        return $order;
    }
}

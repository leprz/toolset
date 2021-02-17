<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\EmptyOrderException;
use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;
use App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface;

class Order
{
    /**
     * @param \App\Domain\ValueObject\OrderId $id
     * @param \App\Domain\ValueObject\CustomerId $buyerId
     * @param \App\Domain\ValueObject\Money $totalPrice
     */
    protected function __construct(
        private OrderId $id,
        private CustomerId $buyerId,
        private Money $totalPrice,
    ) {
    }

    /**
     * @param \App\Domain\ValueObject\OrderId $id
     * @param \App\Domain\ValueObject\CustomerId $buyerId
     * @param array $lineItems
     * @param \App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface $action
     * @return static
     * @throws \App\Domain\Exception\EmptyOrderException
     */
    public static function place(
        OrderId $id,
        CustomerId $buyerId,
        array $lineItems,
        OrderPlaceActionInterface $action
    ): self {
        self::assertOrderIsNotEmpty($lineItems, $id, $buyerId);

        $totalPrice = new Money(OrderLineItem::getTotalPrice($lineItems));

        $action->addLineItemsToOrder($id, $lineItems);

        return new self(id: $id, buyerId: $buyerId, totalPrice: $totalPrice);
    }

    /**
     * @param \App\Domain\OrderLineItem[] $lineItems
     * @param \App\Domain\ValueObject\OrderId $orderId
     * @param \App\Domain\ValueObject\CustomerId $customerId
     * @throws \App\Domain\Exception\EmptyOrderException
     */
    private static function assertOrderIsNotEmpty(array $lineItems, OrderId $orderId, CustomerId $customerId): void
    {
        if (empty($lineItems)) {
            throw EmptyOrderException::forCustomerOrder($orderId, $customerId);
        }
    }
}

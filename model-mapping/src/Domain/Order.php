<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Data\CreateOrderData as Data;
use App\Domain\Data\CreateOrderDataInterface;
use App\Domain\Exception\EmptyOrderException;
use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;
use App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface;

class Order
{
    private OrderId $id;
    private CustomerId $customerId;
    private Money $totalPrice;

    protected function __construct(CreateOrderDataInterface $data)
    {
        $this->id = $data->getId();
        $this->customerId = $data->getCustomerId();
        $this->totalPrice = $data->getTotalPrice();
    }

    /**
     * @param \App\Domain\ValueObject\OrderId $id
     * @param \App\Domain\ValueObject\CustomerId $customerId
     * @param array $lineItems
     * @param \App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface $action
     * @return static
     * @throws \App\Domain\Exception\EmptyOrderException
     */
    public static function place(
        OrderId $id,
        CustomerId $customerId,
        array $lineItems,
        OrderPlaceActionInterface $action
    ): self {
        self::assertOrderIsNotEmpty($lineItems, $id, $customerId);

        $action->addLineItemsToOrder($id, $lineItems);

        return new Order(
            new Data(id: $id, customerId: $customerId, totalPrice: OrderLineItem::getTotalPrice($lineItems))
        );
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

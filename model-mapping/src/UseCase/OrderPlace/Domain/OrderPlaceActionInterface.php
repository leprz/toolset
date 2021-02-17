<?php

declare(strict_types=1);

namespace App\UseCase\OrderPlace\Domain;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\OrderId;

interface OrderPlaceActionInterface
{
    /**
     * @param \App\Domain\ValueObject\CartId $id
     * @return \App\Domain\CartLineItem[]
     */
    public function getLineItemsForCart(CartId $id): array;

    public function clearCart(CartId $id): void;

    /**
     * @param \App\Domain\ValueObject\OrderId $id
     * @param \App\Domain\OrderLineItem[] $lineItems
     * @return mixed
     */
    public function addLineItemsToOrder(OrderId $id, array $lineItems): void;
}

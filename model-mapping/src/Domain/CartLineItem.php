<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Data\CreateCartLineItemData as this;
use App\Domain\Data\CreateCartLineItemDataInterface;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;

/**
 * @package App\Domain
 */
class CartLineItem extends LineItem
{
    protected CartId $cartId;

    protected function __construct(CreateCartLineItemDataInterface $data)
    {
        $this->cartId = $data->getCartId();

        parent::__construct($data->getId(), $data->getPrice(), $data->getName());
    }

    public static function placeInCart(LineItemId $id, CartId $cartId, Money $price, string $name): self
    {
        return new self(new this($id, $cartId, $price, $name));
    }

    /**
     * @param \App\Domain\CartLineItem[] $lineItems
     * @param \App\Domain\ValueObject\OrderId $orderId
     * @return \App\Domain\OrderLineItem[]
     */
    public static function orderAll(array $lineItems, OrderId $orderId): array
    {
        return array_map(static function(CartLineItem $lineItem) use($orderId): OrderLineItem {
            return new OrderLineItem(
                $lineItem->id,
                $orderId,
                $lineItem->price,
                $lineItem->name
            );
        }, $lineItems);
    }
}

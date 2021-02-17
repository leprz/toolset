<?php

declare(strict_types=1);

namespace App\UseCase\OrderPlace\Application;

use App\Application\Persistence\Cart\CartPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemRepositoryInterface;
use App\Application\Persistence\OrderLineItem\OrderLineItemPersistenceInterface;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\OrderId;
use App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface;

class OrderPlaceAction implements OrderPlaceActionInterface
{
    public function __construct(
        private CartLineItemRepositoryInterface $cartLineItemRepository,
        private CartLineItemPersistenceInterface $cartLineItemPersistence,
        private OrderLineItemPersistenceInterface $orderLineItemPersistence,
        private CartPersistenceInterface $cartPersistence
    ) {
    }

    public function getLineItemsForCart(CartId $id): array
    {
        return $this->cartLineItemRepository->getForCartId($id);
    }

    public function clearCart(CartId $id): void
    {
        $this->cartLineItemPersistence->removeForCartId($id);
        $this->cartPersistence->removeById($id);
    }

    public function addLineItemsToOrder(OrderId $id, array $lineItems): void
    {
        $this->orderLineItemPersistence->addMany($lineItems);
    }
}

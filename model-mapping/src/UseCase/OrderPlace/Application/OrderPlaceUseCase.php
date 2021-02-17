<?php

declare(strict_types=1);

namespace App\UseCase\OrderPlace\Application;

use App\Application\Persistence\Cart\CartRepositoryInterface;
use App\Application\Persistence\Order\OrderPersistenceInterface;
use App\UseCase\OrderPlace\Domain\OrderPlaceActionInterface;

class OrderPlaceUseCase
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private OrderPlaceActionInterface $orderPlaceAction,
        private OrderPersistenceInterface $orderPersistence
    ) {
    }

    public function __invoke(OrderPlaceCommand $command)
    {
        $order = $this->cartRepository
            ->getById($command->getCartId())
            ->placeOrder(
                $command->getOrderId(),
                $this->orderPlaceAction
            );

        $this->orderPersistence->add($order);

        $this->orderPersistence->flush();
    }
}

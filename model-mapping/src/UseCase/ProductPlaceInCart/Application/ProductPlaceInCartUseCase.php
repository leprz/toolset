<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Application;

use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;

class ProductPlaceInCartUseCase
{
    public function __construct(
        private CartLineItemPersistenceInterface $cartLineItemPersistence
    ) {
    }

    public function __invoke(ProductPlaceInCartCommand $command): void
    {
        $this->cartLineItemPersistence->add(
            $command->getProduct()->placeInCart($command)
        );

        $this->cartLineItemPersistence->flush();
    }
}

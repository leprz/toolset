<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Application;

use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use App\Domain\ValueObject\LineItemId;
use App\UseCase\ProductPlaceInCart\Domain\ProductPlaceInCartActionInterface;

class ProductPlaceInCartAction implements ProductPlaceInCartActionInterface
{
    /**
     * @var \App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface
     */
    private CartLineItemPersistenceInterface $cartLineItemRepository;

    public function __construct(CartLineItemPersistenceInterface $lineItemRepository)
    {
        $this->cartLineItemRepository = $lineItemRepository;
    }

    public function generateNextLineItemId(): LineItemId
    {
        return $this->cartLineItemRepository->generateNextId();
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Persistence\CartLineItem;

use App\Domain\CartLineItem;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;

interface CartLineItemRepositoryInterface
{
    /**
     * @param \App\Domain\ValueObject\CartId $id
     * @return \App\Domain\CartLineItem[]
     */
    public function getForCartId(CartId $id): array;

    /**
     * @param \App\Domain\ValueObject\LineItemId $id
     * @return \App\Domain\CartLineItem
     * @throws \App\Application\Exception\NotFoundException
     */
    public function getById(LineItemId $id): CartLineItem;
}

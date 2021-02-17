<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;

abstract class LineItem
{
    public function __construct(
        protected LineItemId $id,
        protected Money $price,
        protected string $name
    ) {
    }

    /**
     * @param \App\Domain\LineItem[] $lineItems
     * @return float
     */
    public static function getTotalPrice(array $lineItems): float
    {
        return array_reduce(
            $lineItems,
            static function (float $total, LineItem $lineItem): float {
                return $total + $lineItem->price->toFloat();
            },
            0
        );
    }
}

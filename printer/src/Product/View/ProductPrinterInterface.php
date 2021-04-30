<?php

declare(strict_types=1);

namespace Printer\Product\View;

use Printer\Price\View\PriceView;
use Printer\Rating\View\RatingView;

interface ProductPrinterInterface
{
    public function print(
        ?string $image,
        string $name,
        string $description,
        PriceView $price,
        RatingView $aggregateRating,
        bool $isHighlighted
    ): string;
}

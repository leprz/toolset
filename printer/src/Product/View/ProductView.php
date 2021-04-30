<?php

declare(strict_types=1);

namespace Printer\Product\View;

use Printer\Price\View\PriceView;
use Printer\Rating\View\RatingView;

class ProductView
{
    private bool $isHighlighted = false;
    private ?string $image = null;

    public function __construct(
        private string $name,
        private string $description,
        private PriceView $price,
        private RatingView $aggregateRating
    ) {
    }

    public function print(ProductPrinterInterface $printer): string
    {
        return $printer->print(
            $this->image,
            $this->name,
            $this->description,
            $this->price,
            $this->aggregateRating,
            $this->isHighlighted
        );
    }

    public function withImage(string $url): self
    {
        $this->image = $url;

        return $this;
    }
}

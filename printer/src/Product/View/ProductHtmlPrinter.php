<?php

declare(strict_types=1);

namespace Printer\Product\View;

use Printer\Price\View\PriceHtmlPrinter;
use Printer\Price\View\PriceView;
use Printer\Rating\View\RatingHtmlPrinter;
use Printer\Rating\View\RatingView;
use Twig\Environment;

class ProductHtmlPrinter implements ProductPrinterInterface
{
    public function __construct(
        private Environment $twig,
        private PriceHtmlPrinter $pricePrinter,
        private RatingHtmlPrinter $ratingPrinter
    ) {
    }

    public function print(
        ?string $image,
        string $name,
        string $description,
        PriceView $price,
        RatingView $aggregateRating,
        bool $isHighlighted
    ): string {
        return $this->twig->render(
            'product/product.html.twig',
            [
                'image' => $image,
                'name' => $name,
                'description' => $description,
                'price' => $price->print($this->pricePrinter),
                'rating' => $aggregateRating->print($this->ratingPrinter),
                'isHighlighted' => $isHighlighted
            ]
        );
    }
}

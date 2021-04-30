<?php

declare(strict_types=1);

namespace Printer\Product\View;

use JsonException;
use LogicException;
use Printer\Price\View\PriceJsonPrinter;
use Printer\Price\View\PriceView;
use Printer\Rating\View\RatingJsonPrinter;
use Printer\Rating\View\RatingView;

use function json_encode;

class ProductJsonPrinter implements ProductPrinterInterface
{
    public function __construct(
        private RatingJsonPrinter $ratingJsonPrinter,
        private PriceJsonPrinter $priceJsonPrinter
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
        try {
            return json_encode(
                array_merge(
                    [
                        "aggregateRating" => json_decode(
                            $aggregateRating->print($this->ratingJsonPrinter),
                            true,
                            512,
                            JSON_THROW_ON_ERROR
                        ),
                        "description" => $description,
                        "name" => $name,
                        "image" => $image,
                        "isHighlighted" => $isHighlighted,
                    ],
                    json_decode(
                        $price->print($this->priceJsonPrinter),
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    )
                ),
                JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
            );
        } catch (JsonException $e) {
            throw new LogicException($e->getMessage());
        }
    }
}

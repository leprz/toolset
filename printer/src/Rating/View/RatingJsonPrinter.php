<?php
declare(strict_types=1);

namespace Printer\Rating\View;

use JsonException;
use Symfony\Component\Cache\Exception\LogicException;

class RatingJsonPrinter implements RatingPrinterInterface
{
    public function print(int $value, int $reviewCount): string
    {
        try {
            return json_encode([
                'ratingValue' => $value,
                'reviewCount' => $reviewCount
            ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        } catch (JsonException $e) {
            throw new LogicException($e->getMessage());
        }
    }
}

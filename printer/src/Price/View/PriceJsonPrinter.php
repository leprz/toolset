<?php
declare(strict_types=1);

namespace Printer\Price\View;

use JsonException;
use LogicException;

class PriceJsonPrinter implements PricePrinterInterface
{
    /** This method may not be needed */
    public function print(int $value, string $currency): string
    {
        try {
            return json_encode(
                [
                    'price' => $value / 10,
                    'priceCurrency' => $currency,
                ],
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new LogicException($e->getMessage());
        }
    }
}

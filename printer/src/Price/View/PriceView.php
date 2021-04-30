<?php
declare(strict_types=1);

namespace Printer\Price\View;

class PriceView
{
    public function __construct(private int $value, private string $currency)
    {
    }

    public function print(PricePrinterInterface $printer): string
    {
        return $printer->print($this->value, $this->currency);
    }
}

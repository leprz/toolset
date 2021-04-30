<?php
declare(strict_types=1);

namespace Printer\Price\View;

interface PricePrinterInterface
{
    public function print(int $value, string $currency): string;
}

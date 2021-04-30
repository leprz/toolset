<?php
declare(strict_types=1);

namespace Printer\Rating\View;

interface RatingPrinterInterface
{
    public function print(int $value, int $reviewCount): string;
}

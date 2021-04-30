<?php
declare(strict_types=1);

namespace Printer\Rating\View;

class RatingView
{
    public function __construct(private int $value, private int $reviewCount)
    {
    }

    public function print(RatingPrinterInterface $printer): string
    {
        return $printer->print($this->value, $this->reviewCount);
    }
}

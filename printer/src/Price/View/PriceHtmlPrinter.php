<?php

declare(strict_types=1);

namespace Printer\Price\View;

use Twig\Environment;

class PriceHtmlPrinter implements PricePrinterInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function print(int $value, string $currency): string
    {
        return $this->twig->render(
            'price/price.html.twig',
            [
                'value' => ($value / 10),
                'currency' => $currency
            ]
        );
    }
}

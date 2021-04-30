<?php

declare(strict_types=1);

namespace Printer\Rating\View;

use Twig\Environment;

class RatingHtmlPrinter implements RatingPrinterInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function print(int $value, int $reviewCount): string
    {
        return $this->twig->render('rating/rating.html.twig', [
            'value' => $value,
            'maxStars' => 5,
            'reviewCount' => $reviewCount
        ]);
    }
}

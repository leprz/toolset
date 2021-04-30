<?php
declare(strict_types=1);

use Printer\Price\View\PriceJsonPrinter;
use Printer\Price\View\PriceView;
use Printer\Product\View\ProductJsonPrinter;
use Printer\Product\View\ProductView;
use Printer\Rating\View\RatingJsonPrinter;
use Printer\Rating\View\RatingView;

require dirname(__DIR__) . '/vendor/autoload.php';

$view = (new ProductView(
    'Kenmore White 17" Microwave',
    '0.7 cubic feet countertop microwave. Has six preset cooking categories and convenience features like' .
    ' Add-A-Minute and Child Lock.',
    new PriceView(550, 'USD'),
    new RatingView(4, 12)
))->withImage(
    'https://images.unsplash.com/photo-1475855581690-80accde3ae2b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=750&amp;q=80'
);

echo $view->print(
    new ProductJsonPrinter(
        new RatingJsonPrinter(),
        new PriceJsonPrinter()
    )
);

<?php

declare(strict_types=1);

use Printer\Price\View\PriceHtmlPrinter;
use Printer\Price\View\PriceView;
use Printer\Product\View\ProductHtmlPrinter;
use Printer\Product\View\ProductView;
use Printer\Rating\View\RatingHtmlPrinter;
use Printer\Rating\View\RatingView;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require dirname(__DIR__) . '/../vendor/autoload.php';

$loader = new FilesystemLoader(dirname(__DIR__) . '/resources');
$twig = new Environment(
    $loader, [
    'debug' => true,
    'auto_reload' => true,
    'cache' => dirname(__DIR__) . '/tmp/cache',
]
);

$printer = new ProductHtmlPrinter($twig, new PriceHtmlPrinter($twig), new RatingHtmlPrinter($twig));

$view = (new ProductView(
    'Kenmore White 17" Microwave',
    '0.7 cubic feet countertop microwave. Has six preset cooking categories and convenience features like' .
    ' Add-A-Minute and Child Lock.',
    new PriceView(555, 'USD'),
    new RatingView(4, 12)
))->withImage(
    'https://images.unsplash.com/photo-1475855581690-80accde3ae2b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=750&amp;q=80'
);

$view2 = (new ProductView(
    'Test',
    'Test',
    new PriceView(15, 'USD'),
    new RatingView(0, 0)
));

echo $twig->render('product/product-list.html.twig', [
    'products' => [
        $view->print($printer),
        $view2->print($printer),
        $view->print($printer),
        $view->print($printer),
        $view->print($printer),
        $view->print($printer),
        $view->print($printer),
    ]
]);

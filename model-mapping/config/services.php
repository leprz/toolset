<?php

declare(strict_types=1);

use App\Application\Persistence\Cart\CartPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemRepositoryInterface;
use App\Application\Persistence\Order\OrderPersistenceInterface;
use App\Application\Persistence\Order\OrderRepositoryInterface;
use App\Infrastructure\Persistence\Cart\CartEntityRepository;
use App\Infrastructure\Persistence\CartLineItem\CartLineItemEntityRepository;
use App\Infrastructure\Persistence\Order\OrderEntityRepository;
use App\UseCase\OrderPlace\Application\OrderPlaceUseCase;
use App\UseCase\ProductPlaceInCart\Application\ProductPlaceInCartUseCase;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude(
            [
                __DIR__ . '/../src/DependencyInjection/',
                __DIR__ . '/../src/Kernel.php',
                __DIR__ . '/../src/Tests/',
            ]
        );

    $services->load('App\Infrastructure\Controller\\', __DIR__ . '/../src/Infrastructure/Controller/')
        ->tag('controller.service_arguments');

    $services
        ->set(CartPersistenceInterface::class, CartEntityRepository::class)
        ->public();

    $services
        ->set(CartLineItemPersistenceInterface::class, CartLineItemEntityRepository::class)
        ->public();

    $services
        ->set(CartLineItemRepositoryInterface::class, CartLineItemEntityRepository::class)
        ->public();

    $services
        ->set(OrderPersistenceInterface::class, OrderEntityRepository::class)
        ->public();

    $services
        ->set(OrderRepositoryInterface::class, OrderEntityRepository::class)
        ->public();

    $services
        ->set(ProductPlaceInCartUseCase::class)
        ->public();

    $services
        ->set(OrderPlaceUseCase::class)
        ->public();
};

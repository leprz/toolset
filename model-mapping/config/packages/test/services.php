<?php

declare(strict_types=1);

use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(CartLineItemPersistenceInterface::class)
        ->public();

    $services->set('App\UseCase\CartPlaceProduct\Application\CartPlaceProductUseCase')
        ->public();
};

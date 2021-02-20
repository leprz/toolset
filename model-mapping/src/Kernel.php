<?php /** @noinspection PhpIncludeInspection */

/** @noinspection PhpIncludeInspection */

/** @noinspection PhpFullyQualifiedNameUsageInspection */

/** @noinspection PhpFullyQualifiedNameUsageInspection */

/** @noinspection PhpFullyQualifiedNameUsageInspection */

/** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.php');
        $container->import('../config/{packages}/'.$this->environment.'/*.php');

        if (is_file(\dirname(__DIR__).'/config/services.php')) {
            $container->import('../config/services.php');
            $container->import('../config/{services}_'.$this->environment.'.php');
        } elseif (is_file($path = \dirname(__DIR__).'/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/'.$this->environment.'/*.php');
        $routes->import('../config/{routes}/*.php');

        if (is_file(\dirname(__DIR__).'/config/routes.php')) {
            $routes->import('../config/routes.php');
        } elseif (is_file($path = \dirname(__DIR__).'/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }
}

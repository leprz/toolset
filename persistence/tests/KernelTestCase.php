<?php

declare(strict_types=1);

namespace Persistence\Tests;

use PHPUnit\Framework\TestCase;
use Pimple\Container;

class KernelTestCase extends TestCase
{
    protected static Container $container;

    public static function bootKernel(): void
    {
        /** @var \Persistence\Kernel $kernel */
        $kernel = include dirname(__DIR__) . '/bootstrap.php';

        self::$container = $kernel->getContainer();
    }
}

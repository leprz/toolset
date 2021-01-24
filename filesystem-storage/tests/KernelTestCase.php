<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests;

use FilesystemStorage\Kernel;
use PHPUnit\Framework\TestCase;

class KernelTestCase extends TestCase
{
    protected static ?Kernel $kernel = null;

    public static function bootKernel(): void
    {
        if (!self::$kernel) {
            /** @var \FilesystemStorage\Kernel $kernel */
            $kernel = include dirname(__DIR__) . '/bootstrap.php';

            self::$kernel = new KernelTestDecorator($kernel);
        }
    }
}

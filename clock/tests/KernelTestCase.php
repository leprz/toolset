<?php
declare(strict_types=1);

namespace Clock\Tests;

use PHPUnit\Framework\TestCase;

class KernelTestCase extends TestCase
{
    public static function bootKernel(): void
    {
        include dirname(__DIR__) . '/bootstrap.php';
    }
}

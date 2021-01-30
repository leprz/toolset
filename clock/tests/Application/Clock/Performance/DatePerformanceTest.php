<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Clock\Performance;

use PHPUnit\Framework\TestCase;

abstract class DatePerformanceTest extends TestCase
{
    private static int $max = 100000;

    abstract public function testLessThanForHugeAmountOfDates(): void;

    protected function loop(callable $callable): void
    {
        for ($i = 0, $max = self::$max; $i < $max; $i++) {
            $callable();
        }
    }
}

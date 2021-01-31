<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date;

use Clock\Application\Date\DateTime;
use Clock\Tests\KernelTestCase;

class DateTimeTest extends KernelTestCase
{
    public function testFromString(): void
    {
        self::assertEquals('2020-11-10 10:10:10', (string) DateTime::fromString('2020-11-10 10:10:10'));
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }
}

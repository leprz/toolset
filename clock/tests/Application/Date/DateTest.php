<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date;

use Clock\Application\Date\Date;
use Clock\Tests\KernelTestCase;

class DateTest extends KernelTestCase
{
    public function testFromString(): void
    {
        self::assertEquals('2020-11-10', (string) Date::fromString('2020-11-10'));
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }
}

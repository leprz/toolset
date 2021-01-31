<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date;

use Clock\Application\Date\ClockInterface;
use Clock\Infrastructure\ValueObject\Date;
use Clock\Tests\Application\Fake\FakeClock;
use Clock\Tests\KernelTestCase;

class ClockTest extends KernelTestCase
{
    /**
     * @var \Clock\Application\Date\ClockInterface
     */
    private ClockInterface $clock;

    public function testClock(): void
    {
        $now = $this->clock->now();

        self::assertEquals('2020-05-05 12:00:00', (string) $now);
    }

    public function testTodayWasBefore(): void
    {
        self::assertTrue(
            $this->clock->today()->lessThanOrEqual(
                Date::fromString('2020-05-05')
            )
        );
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->clock = new FakeClock('2020-05-05 12:00:00');
    }
}

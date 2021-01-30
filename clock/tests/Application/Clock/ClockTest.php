<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Clock;

use Clock\Application\Clock\ClockInterface;
use Clock\Application\Clock\Date;
use Clock\Application\ValueObject\ActualDeliveryDate;
use Clock\Application\ValueObject\EstimatedDeliveryDate;
use Clock\Tests\Application\Fake\FakeClock;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ClockTest extends TestCase
{
    /**
     * @var \Clock\Application\Clock\ClockInterface
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

    public function testEstimatedDeliveryTime(): void
    {
        $estimatedDeliveryDate = EstimatedDeliveryDate::at(
            $this->clock->today()->addDays(5)
        );

        $actualDeliveryDate = ActualDeliveryDate::at(
            $this->clock->today()->addDays(4)
        );

        $actualDeliveryDateAtTheSameDayAsEstimatedDelivery = ActualDeliveryDate::at(
            $this->clock->today()->addDays(5)
        );

        $this->assertActualDeliveryWasWithinEstimatedDelivery($actualDeliveryDate, $estimatedDeliveryDate);
        $this->assertActualDeliveryWasWithinEstimatedDelivery(
            $actualDeliveryDateAtTheSameDayAsEstimatedDelivery,
            $estimatedDeliveryDate
        );
    }

    private function assertActualDeliveryWasWithinEstimatedDelivery(
        ActualDeliveryDate $actualDeliveryDate,
        EstimatedDeliveryDate $estimatedDeliveryDate
    ): void {
        self::assertTrue(
            $actualDeliveryDate->wasWithin($estimatedDeliveryDate)
        );
    }

    protected function setUp(): void
    {
        $this->clock = new FakeClock(new DateTimeImmutable('2020-05-05 12:00:00'));
    }
}

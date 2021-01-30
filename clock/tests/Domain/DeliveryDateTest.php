<?php
declare(strict_types=1);

namespace Clock\Tests\Domain;

use Clock\Domain\ValueObject\ActualDeliveryDate;
use Clock\Domain\ValueObject\Date;
use Clock\Domain\ValueObject\EstimatedDeliveryDate;
use PHPUnit\Framework\TestCase;

class DeliveryDateTest extends TestCase
{
    public function testEstimatedDeliveryTime(): void
    {
        $orderDate = Date::fromString('01-01-2020');

        $estimatedDelivery = EstimatedDeliveryDate::at(
            $orderDate->addDays(5)
        );

        $actualDeliveryDayBeforeEstimatedDelivery = ActualDeliveryDate::at(
            $orderDate->addDays(4)
        );

        $actualDeliveryAtTheSameDayAsEstimatedDelivery = ActualDeliveryDate::at(
            $orderDate->addDays(5)
        );

        $actualDeliveryOneDayAfterEstimatedDelivery = ActualDeliveryDate::at(
            $orderDate->addDays(6)
        );

        $this->assertActualDeliveryWasWithinEstimatedDelivery(
            $actualDeliveryDayBeforeEstimatedDelivery,
            $estimatedDelivery
        );
        $this->assertActualDeliveryWasWithinEstimatedDelivery(
            $actualDeliveryAtTheSameDayAsEstimatedDelivery,
            $estimatedDelivery
        );

        $this->assertActualDeliveryHasBeenLate($actualDeliveryOneDayAfterEstimatedDelivery, $estimatedDelivery);
    }

    private function assertActualDeliveryWasWithinEstimatedDelivery(
        ActualDeliveryDate $actualDeliveryDate,
        EstimatedDeliveryDate $estimatedDeliveryDate
    ): void {
        self::assertTrue(
            $actualDeliveryDate->wasWithin($estimatedDeliveryDate)
        );
    }

    private function assertActualDeliveryHasBeenLate(
        ActualDeliveryDate $actualDeliveryDate,
        EstimatedDeliveryDate $estimatedDeliveryDate
    ): void {
        self::assertFalse(
            $actualDeliveryDate->wasWithin($estimatedDeliveryDate)
        );
    }
}

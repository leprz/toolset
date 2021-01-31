<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date\Performance;

use Carbon\CarbonImmutable;
use Clock\Tests\Application\Date\Performance\Implementation\CarbonDate;

class CarbonDatePerformanceTest extends DatePerformanceTest
{
    /**
     * @group performance
     */
    public function testLessThanForHugeAmountOfDates(): void
    {
        $this->loop(
            static function (): void {
                $date = new CarbonImmutable('01-02-2020');
                (new CarbonDate($date))->lessThanOrEqual(
                    new CarbonDate($date)
                );
            }
        );
    }
}

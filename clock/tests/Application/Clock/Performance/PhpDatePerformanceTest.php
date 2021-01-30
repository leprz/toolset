<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Clock\Performance;

use Clock\Tests\Application\Clock\Performance\Implementation\PhpDate;
use DateTimeImmutable;

class PhpDatePerformanceTest extends DatePerformanceTest
{
    /**
     * @group performance
     */
    public function testLessThanForHugeAmountOfDates(): void
    {
        $this->loop(
            static function (): void {
                $date = new DateTimeImmutable('01-02-2020');
                (new PhpDate($date))->lessThanOrEqual(
                    new PhpDate($date)
                );
            }
        );
    }
}

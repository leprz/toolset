<?php

declare(strict_types=1);

namespace Clock;

use Clock\Application\Date\Date;
use Clock\Application\Date\Builder\DateBuilderInterface;
use Clock\Application\Date\DateTime;
use Clock\Application\Date\Builder\DateTimeBuilderInterface;
use Clock\Infrastructure\Date\DateBuilder;
use Clock\Infrastructure\Date\DateTimeBuilder;

class Kernel
{
    public function boot(): void
    {
        $date = new class() extends Date {
            public static function setAdapter(DateBuilderInterface $adapter): void
            {
                parent::setAdapter($adapter);
            }
        };

        $date::setAdapter(new DateBuilder());
        unset($date);

        $dateTime = new class() extends DateTime {
            public static function setAdapter(DateTimeBuilderInterface $adapter): void
            {
                parent::setAdapter($adapter);
            }
        };

        $dateTime::setAdapter(new DateTimeBuilder());
        unset($dateTime);
    }
}

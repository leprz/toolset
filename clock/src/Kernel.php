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
            public function adapter(DateBuilderInterface $adapter): void
            {
                self::setAdapter($adapter);
            }
        };

        $date->adapter(new DateBuilder());
        unset($date);

        $dateTime = new class() extends DateTime {
            public function adapter(DateTimeBuilderInterface $adapter): void
            {
                self::setAdapter($adapter);
            }
        };

        $dateTime->adapter(new DateTimeBuilder());
        unset($dateTime);
    }
}

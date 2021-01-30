<?php
declare(strict_types=1);

namespace Clock\Infrastructure\Clock;

use Clock\Application\Clock\ClockInterface;
use Clock\Domain\ValueObject\Date;
use Clock\Domain\ValueObject\DateTime;
use DateTimeImmutable;

class SystemClock implements ClockInterface
{
    public function now(): DateTime
    {
        return new DateTime(new DateTimeImmutable('now'));
    }

    public function today(): Date
    {
        return new Date(new DateTimeImmutable('now'));
    }
}

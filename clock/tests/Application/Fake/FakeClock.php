<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Fake;

use Clock\Application\Date\ClockInterface;
use Clock\Application\Date\Date;
use Clock\Application\Date\DateTime;

class FakeClock implements ClockInterface
{
    private string $fakeNow;

    /**
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->fakeNow = $date;
    }

    public function now(): \Clock\Domain\ValueObject\DateTime
    {
        return DateTime::fromString($this->fakeNow);
    }

    public function today(): \Clock\Domain\ValueObject\Date
    {
        return Date::fromString($this->fakeNow);
    }
}

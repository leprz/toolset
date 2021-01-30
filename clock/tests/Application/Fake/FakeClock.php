<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Fake;

use Clock\Application\Clock\ClockInterface;
use Clock\Domain\ValueObject\Date;
use Clock\Domain\ValueObject\DateTime;
use DateTimeImmutable;

class FakeClock implements ClockInterface
{
    private DateTimeImmutable $fakeNow;

    /**
     * @param \DateTimeImmutable $fakeNow
     */
    public function __construct(DateTimeImmutable $fakeNow)
    {
        $this->fakeNow = $fakeNow;
    }

    public function now(): DateTime
    {
        return new DateTime($this->fakeNow);
    }

    public function today(): Date
    {
        return new Date($this->fakeNow);
    }
}

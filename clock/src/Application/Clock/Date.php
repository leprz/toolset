<?php
declare(strict_types=1);

namespace Clock\Application\Clock;

use DateInterval;
use DateTimeImmutable;

class Date
{
    /**
     * @var \DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * @param \DateTimeImmutable $date
     */
    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date->setTime(0, 0, 0);
    }

    public static function fromString(string $date): self
    {
        return new self(new DateTimeImmutable($date));
    }

    public function lessThanOrEqual(Date $date): bool
    {
        return $this->date < $date->addDays(1)->getDateTime();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTime(): DateTimeImmutable
    {
        return $this->date;
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function addDays(int $days): self
    {
        return new self(
            $this->date->add(
                new DateInterval(
                    sprintf('P%sD', $days)
                )
            )
        );
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}

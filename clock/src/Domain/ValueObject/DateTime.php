<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

use DateTimeImmutable;

class DateTime
{
    /**
     * @var \DateTimeImmutable
     */
    private DateTimeImmutable $dateTime;

    /**
     * @param \DateTimeImmutable $dateTime
     */
    public function __construct(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function __toString(): string
    {
        return $this->dateTime->format('Y-m-d H:i:s');
    }
}

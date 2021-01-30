<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Clock\Performance\Implementation;

use DateTimeImmutable;

class PhpDate
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

    public function lessThanOrEqual(self $date): bool
    {
        return $this->date <= $date->date;
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}

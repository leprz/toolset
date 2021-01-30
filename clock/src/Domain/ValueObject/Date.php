<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

use Clock\Domain\Exception\InvalidArgumentException;
use DateInterval;
use DateTimeImmutable;
use Exception;

class Date
{
    /**
     * @var \DateTimeImmutable
     */
    protected DateTimeImmutable $date;

    /**
     * @param \DateTimeImmutable $date
     */
    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date->setTime(0, 0, 0);
    }

    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\Date
     * @throws \Clock\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): Date
    {
        try {
            return new self(new DateTimeImmutable($date));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function lessThanOrEqual(Date $date): bool
    {
        return $this->date <= $date->date;
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

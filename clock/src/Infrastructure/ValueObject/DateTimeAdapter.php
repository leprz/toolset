<?php
declare(strict_types=1);

namespace Clock\Infrastructure\ValueObject;

use Clock\Domain\Exception\InvalidArgumentException;
use Clock\Domain\ValueObject\DateTime as DateTimeDomain;
use DateTimeImmutable;
use Exception;

class DateTimeAdapter extends DateTimeDomain
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
     * @param string $date
     * @return \Clock\Infrastructure\ValueObject\DateTimeAdapter
     * @throws \Clock\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): self
    {
        try {
            return new self(new DateTimeImmutable($date));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @return \DateTimeImmutable
     */
    protected function getDate(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function __toString(): string
    {
        return $this->dateTime->format('Y-m-d H:i:s');
    }
}

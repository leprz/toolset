<?php
declare(strict_types=1);

namespace Clock\Infrastructure\Date;

use Clock\Application\Date\Builder\DateTimeBuilderInterface;
use Clock\Domain\ValueObject\DateTime;
use Clock\Infrastructure\ValueObject\DateTimeAdapter;

class DateTimeBuilder implements DateTimeBuilderInterface
{
    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\DateTime
     * @throws \Clock\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): DateTime
    {
        return DateTimeAdapter::fromString($date);
    }
}

<?php
declare(strict_types=1);

namespace Clock\Infrastructure\Date;

use Clock\Application\Date\Builder\DateBuilderInterface;
use Clock\Domain\ValueObject\Date;
use Clock\Infrastructure\ValueObject\DateAdapter;

class DateBuilder implements DateBuilderInterface
{
    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\Date
     * @throws \Clock\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): Date
    {
        return DateAdapter::fromString($date);
    }
}

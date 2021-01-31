<?php
declare(strict_types=1);

namespace Clock\Infrastructure\Date;

use Clock\Application\Date\ClockInterface;
use Clock\Domain\ValueObject\Date;
use Clock\Domain\ValueObject\DateTime;

class SystemClock implements ClockInterface
{
    /**
     * @return \Clock\Domain\ValueObject\DateTime
     * @throws \Clock\Application\Date\Builder\AdapterNotInitializedException
     */
    public function now(): DateTime
    {
        return \Clock\Application\Date\DateTime::fromString('now');
    }

    /**
     * @return \Clock\Domain\ValueObject\Date
     * @throws \Clock\Application\Date\Builder\AdapterNotInitializedException
     */
    public function today(): Date
    {
        return \Clock\Application\Date\Date::fromString('now');
    }
}

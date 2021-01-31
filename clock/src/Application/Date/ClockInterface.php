<?php
declare(strict_types=1);

namespace Clock\Application\Date;

use Clock\Domain\ValueObject\Date;
use Clock\Domain\ValueObject\DateTime;

interface ClockInterface
{
    /**
     * @return \Clock\Domain\ValueObject\DateTime
     */
    public function now(): DateTime;

    /**
     * @return \Clock\Domain\ValueObject\Date
     */
    public function today(): Date;
}

<?php
declare(strict_types=1);

namespace Clock\Application\Clock;

use Clock\Domain\ValueObject\Date;
use Clock\Domain\ValueObject\DateTime;

interface ClockInterface
{
    public function now(): DateTime;

    public function today(): Date;
}

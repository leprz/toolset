<?php
declare(strict_types=1);

namespace Clock\Application\Clock;

interface ClockInterface
{
    public function now(): DateTime;

    public function today(): Date;
}

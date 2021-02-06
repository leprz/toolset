<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date\Performance\Implementation;

use Clock\Domain\ValueObject\Date;
use Clock\Infrastructure\ValueObject\Implementation\CarbonDateTrait;

class CarbonDate extends Date
{
    use CarbonDateTrait {
        CarbonDateTrait::lessThanOrEqual as _lessThanOrEqual;
        CarbonDateTrait::addDays as _addDays;
    }

    public function lessThanOrEqual(Date $date): bool
    {
        return $this->_lessThanOrEqual($date);
    }

    public function addDays(int $days): Date
    {
        return $this->_addDays($days);
    }
}

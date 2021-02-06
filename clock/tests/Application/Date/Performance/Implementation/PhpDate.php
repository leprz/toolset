<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date\Performance\Implementation;

use Clock\Domain\ValueObject\Date;
use Clock\Infrastructure\ValueObject\Implementation\NativeImmutableDateTrait;

class PhpDate extends Date
{
    use NativeImmutableDateTrait {
        NativeImmutableDateTrait::lessThanOrEqual as _lessThanOrEqual;
        NativeImmutableDateTrait::addDays as _addDays;
    }

    /**
     * @param int $days
     * @return \Clock\Domain\ValueObject\Date
     */
    public function addDays(int $days): Date
    {
        return $this->_addDays($days);
    }

    /**
     * @param \Clock\Domain\ValueObject\Date $date
     * @return bool
     */
    public function lessThanOrEqual(Date $date): bool
    {
        return $this->_lessThanOrEqual($date);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}

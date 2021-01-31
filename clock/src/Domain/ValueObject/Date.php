<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

abstract class Date
{
    /**
     * @param \Clock\Domain\ValueObject\Date $date
     * @return bool
     */
    abstract public function lessThanOrEqual(self $date): bool;

    /**
     * @param int $days
     * @return self
     */
    abstract public function addDays(int $days): self;

    /**
     * @return mixed
     */
    abstract protected function getDate();

    /**
     * @return string
     */
    abstract public function __toString(): string;
}

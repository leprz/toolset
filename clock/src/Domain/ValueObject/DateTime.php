<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

abstract class DateTime
{
    /**
     * @return mixed
     */
    abstract protected function getDate();

    /**
     * @return string
     */
    abstract public function __toString(): string;
}

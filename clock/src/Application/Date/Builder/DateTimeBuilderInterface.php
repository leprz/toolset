<?php
declare(strict_types=1);

namespace Clock\Application\Date\Builder;

use Clock\Domain\ValueObject\DateTime;

interface DateTimeBuilderInterface
{
    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\DateTime
     */
    public static function fromString(string $date): DateTime;
}

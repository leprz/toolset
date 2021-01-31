<?php
declare(strict_types=1);

namespace Clock\Application\Date\Builder;

use Clock\Domain\ValueObject\Date;

interface DateBuilderInterface
{
    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\Date
     */
    public static function fromString(string $date): Date;
}

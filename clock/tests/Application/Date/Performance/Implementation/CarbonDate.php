<?php
declare(strict_types=1);

namespace Clock\Tests\Application\Date\Performance\Implementation;

use Carbon\CarbonImmutable;

class CarbonDate
{
    /**
     * @var \Carbon\CarbonImmutable
     */
    private CarbonImmutable $date;

    /**
     * @param \Carbon\CarbonImmutable $date
     */
    public function __construct(CarbonImmutable $date)
    {
        $this->date = $date->setTime(0, 0, 0);
    }

    public function lessThanOrEqual(self $date): bool
    {
        return $this->date->lessThanOrEqualTo($date->date);
    }
}

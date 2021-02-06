<?php
declare(strict_types=1);

namespace Clock\Infrastructure\ValueObject\Implementation;

use Carbon\CarbonImmutable;

trait CarbonDateTrait
{
    /**
     * @var \Carbon\CarbonImmutable
     */
    protected CarbonImmutable $date;

    /**
     * @param \Carbon\CarbonImmutable $date
     */
    public function __construct(CarbonImmutable $date)
    {
        $this->date = $date->setTime(0, 0, 0);
    }

    /**
     * @param int $days
     * @return static
     */
    private function addDays(int $days): self
    {
        return new static(
            $this->date->addDays($days)
        );
    }

    /**
     * @param mixed $date
     * @return bool
     */
    private function lessThanOrEqual($date): bool
    {
        return $this->date->lessThanOrEqualTo($date->getDate());
    }

    /**
     * @return \Carbon\CarbonImmutable
     */
    protected function getDate(): CarbonImmutable
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}

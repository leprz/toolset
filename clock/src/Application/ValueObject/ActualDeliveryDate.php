<?php
declare(strict_types=1);

namespace Clock\Application\ValueObject;

use Clock\Application\Clock\Date;

class ActualDeliveryDate
{
    private Date $deliveredAt;

    private function __construct(Date $date)
    {
        $this->setEstimatedDelivery($date);
    }

    private function setEstimatedDelivery(Date $date): void
    {
        $this->deliveredAt = $date;
    }

    public static function at(Date $date): self
    {
        return new self($date);
    }

    public function wasWithin(EstimatedDeliveryDate $estimatedDeliveryDate): bool
    {
        return $this->deliveredAt->lessThanOrEqual($estimatedDeliveryDate->getDate());
    }
}

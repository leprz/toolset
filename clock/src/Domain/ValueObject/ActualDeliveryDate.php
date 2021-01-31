<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

final class ActualDeliveryDate
{
    /**
     * @var \Clock\Domain\ValueObject\Date
     */
    private Date $deliveredAt;

    /**
     * @param \Clock\Domain\ValueObject\Date $date
     */
    private function __construct(Date $date)
    {
        $this->setEstimatedDelivery($date);
    }

    /**
     * @param \Clock\Domain\ValueObject\Date $date
     */
    private function setEstimatedDelivery(Date $date): void
    {
        $this->deliveredAt = $date;
    }

    /**
     * @param \Clock\Domain\ValueObject\Date $date
     * @return self
     */
    public static function at(Date $date): self
    {
        return new self($date);
    }

    /**
     * @param \Clock\Domain\ValueObject\EstimatedDeliveryDate $estimatedDeliveryDate
     * @return bool
     */
    public function wasWithin(EstimatedDeliveryDate $estimatedDeliveryDate): bool
    {
        return $this->deliveredAt->lessThanOrEqual($estimatedDeliveryDate->getDate());
    }
}

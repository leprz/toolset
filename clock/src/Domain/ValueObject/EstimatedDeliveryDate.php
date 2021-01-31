<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

final class EstimatedDeliveryDate
{
    /**
     * @var \Clock\Domain\ValueObject\Date
     */
    private Date $estimatedDelivery;

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
        $this->estimatedDelivery = $date;
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
     * @return \Clock\Domain\ValueObject\Date
     */
    public function getDate(): Date
    {
        return $this->estimatedDelivery;
    }
}

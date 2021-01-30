<?php
declare(strict_types=1);

namespace Clock\Domain\ValueObject;

class EstimatedDeliveryDate
{
    /**
     * @var \Clock\Domain\ValueObject\Date
     */
    private Date $estimatedDelivery;

    private function __construct(Date $date)
    {
        $this->setEstimatedDelivery($date);
    }

    private function setEstimatedDelivery(Date $date): void
    {
        $this->estimatedDelivery = $date;
    }

    public static function at(Date $date): self
    {
        return new self($date);
    }

    public function getDate(): Date
    {
        return $this->estimatedDelivery;
    }
}

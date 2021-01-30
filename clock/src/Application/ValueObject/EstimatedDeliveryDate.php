<?php
declare(strict_types=1);

namespace Clock\Application\ValueObject;

use Clock\Application\Clock\Date;

class EstimatedDeliveryDate
{
    /**
     * @var \Clock\Application\Clock\Date
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

    /**
     * @return \Clock\Application\Clock\Date
     */
    public function getDate(): Date
    {
        return $this->estimatedDelivery;
    }
}

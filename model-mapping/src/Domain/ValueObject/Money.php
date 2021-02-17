<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Money
{
    private float $money;

    public function __construct(float $money)
    {
        $this->money = $money;
    }

    public function toFloat(): float
    {
        return $this->money;
    }
}

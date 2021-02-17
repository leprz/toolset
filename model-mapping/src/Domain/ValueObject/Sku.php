<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Sku
{
    private string $sku;

    private function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    public static function fromString(string $sku): self
    {
        return new self($sku);
    }

    public function __toString(): string
    {
        return $this->sku;
    }
}

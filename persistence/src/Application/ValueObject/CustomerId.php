<?php

declare(strict_types=1);

namespace Persistence\Application\ValueObject;

class CustomerId
{
    private string $id;

    private function __construct(string $id)
    {
        $this->setGuid($id);
    }

    private function setGuid(string $guid): void
    {
        $this->id = $guid;
    }

    public static function fromString(string $guid): self
    {
        return new self($guid);
    }

    public function __toString(): string
    {
        return $this->id;
    }
}

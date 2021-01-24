<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\Config;

class TenantConfig
{
    private string $name;
    private int $capacity;
    public function __construct(string $name, int $capacity)
    {
        $this->name = $name;
        $this->capacity = $capacity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }
}

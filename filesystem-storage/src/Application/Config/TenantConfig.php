<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\Config;

class TenantConfig
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $capacity;

    /**
     * @param string $name
     * @param int $capacity
     */
    public function __construct(string $name, int $capacity)
    {
        $this->name = $name;
        $this->capacity = $capacity;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }
}

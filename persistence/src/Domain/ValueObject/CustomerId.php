<?php

declare(strict_types=1);

namespace Persistence\Domain\ValueObject;

use Persistence\Domain\Exception\InvalidArgumentException;
use SharedKernel\Domain\ValueObject\UuidV4Trait;

class CustomerId
{
    use UuidV4Trait;

    /**
     * @param string $uuid
     * @return self
     * @throws \Persistence\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $uuid): self
    {
        try {
            return new self($uuid);
        } catch (\SharedKernel\Domain\Exception\InvalidArgumentException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}

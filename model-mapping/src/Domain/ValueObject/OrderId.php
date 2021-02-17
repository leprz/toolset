<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use SharedKernel\Domain\Exception\InvalidArgumentException;
use SharedKernel\Domain\ValueObject\UuidV4Trait;

class OrderId
{
    use UuidV4Trait {
        UuidV4Trait::equals as equalsImpl;
    }

    /**
     * @param string $uuid
     * @return self
     * @throws \App\Application\Exception\InvalidArgumentException
     */
    public static function fromString(string $uuid): self
    {
        try {
            return new self($uuid);
        } catch (InvalidArgumentException $e) {
            throw new \App\Application\Exception\InvalidArgumentException($e->getMessage());
        }
    }

    public function equals(self $uuid): bool
    {
        return $this->equalsImpl($uuid);
    }
}

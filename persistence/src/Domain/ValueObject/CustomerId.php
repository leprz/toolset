<?php

declare(strict_types=1);

namespace Persistence\Domain\ValueObject;

use Persistence\Domain\Exception\InvalidArgumentException;
use SharedKernel\Domain\ValueObject\UuidV4Trait;

class CustomerId
{
    /**
     * I Use trait here that comes from shared kernel. This allow all bounded contexts to have one implementation of
     * common things like uuid, email, url etc.
     * In my opinion value objects like CustomerId, Email etc. are more suitable for application layer than the domain
     * but they are heavily used by the domain. They don't secure any business logic of the application.
     * I didn't find a good way of keeping them in application layer yet. Either it adds to much PITA (pain in the ass)
     * or it's just not clean.
     */
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

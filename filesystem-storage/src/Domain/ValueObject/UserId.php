<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain\ValueObject;

use FilesystemStorage\Domain\Exception\InvalidArgumentException;
use SharedKernel\Domain\ValueObject\UuidV4Trait;

class UserId
{
    use UuidV4Trait;

    /**
     * @param string $id
     * @return static
     * @throws \FilesystemStorage\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $id): self
    {
        try {
            return new self($id);
        } catch (\SharedKernel\Domain\Exception\InvalidArgumentException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}

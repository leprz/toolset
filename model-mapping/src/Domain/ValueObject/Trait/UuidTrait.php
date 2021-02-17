<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Trait;

use SharedKernel\Domain\Exception\InvalidArgumentException;
use SharedKernel\Domain\ValueObject\UuidV4Trait;

trait UuidTrait
{
    use UuidV4Trait;

    /**
     * @param string $string
     * @return static
     * @throws \App\Application\Exception\InvalidArgumentException
     */
    public static function fromString(string $string): static
    {
        try {
            return new static($string);
        } catch (InvalidArgumentException $e) {
            throw new \App\Application\Exception\InvalidArgumentException($e->getMessage());
        }
    }
}

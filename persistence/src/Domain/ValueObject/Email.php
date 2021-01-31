<?php

declare(strict_types=1);

namespace Persistence\Domain\ValueObject;

use Persistence\Domain\Exception\InvalidArgumentException;
use SharedKernel\Domain\ValueObject\EmailTrait;

class Email
{
    /**
     * to see why it is used go to:
     * @see \Persistence\Domain\ValueObject\CustomerId
     */
    use EmailTrait;

    /**
     * @param string $email
     * @return self
     * @throws \Persistence\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $email): self
    {
        try {
            return new self($email);
        } catch (\SharedKernel\Domain\Exception\InvalidArgumentException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}

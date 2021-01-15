<?php

declare(strict_types=1);

namespace Persistence\Application\ValueObject;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function equals(self $email): bool
    {
        return $this->email === $email->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}

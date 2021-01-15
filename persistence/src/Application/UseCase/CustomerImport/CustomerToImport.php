<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerImport;

use Persistence\Application\ValueObject\CustomerFullName;
use Persistence\Application\ValueObject\Email;

class CustomerToImport
{
    private CustomerFullName $fullName;

    private Email $email;

    public function __construct(Email $email, CustomerFullName $fullName)
    {
        $this->email = $email;
        $this->fullName = $fullName;
    }

    public function getFullName(): CustomerFullName
    {
        return $this->fullName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}

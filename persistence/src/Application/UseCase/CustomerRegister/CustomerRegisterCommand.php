<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerRegister;

use Persistence\Domain\ValueObject\CustomerFullName;
use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;

class CustomerRegisterCommand
{
    private CustomerId $customerId;

    private CustomerFullName $customerFullName;

    private Email $email;

    public function __construct(CustomerId $customerId, Email $email, CustomerFullName $customerFullName)
    {
        $this->customerId = $customerId;
        $this->customerFullName = $customerFullName;
        $this->email = $email;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getFullName(): CustomerFullName
    {
        return $this->customerFullName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}

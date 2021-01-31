<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerChangeEmail;

use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;

class CustomerChangeEmailCommand
{
    /**
     * @var \Persistence\Domain\ValueObject\CustomerId
     */
    private CustomerId $customerId;
    /**
     * @var \Persistence\Domain\ValueObject\Email
     */
    private Email $email;

    /**
     * @var string
     */
    private string $changeRequestCode;

    public function __construct(CustomerId $customerId, Email $email, string $changeRequestCode)
    {
        $this->customerId = $customerId;
        $this->email = $email;
        $this->changeRequestCode = $changeRequestCode;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getNewEmail(): Email
    {
        return $this->email;
    }

    public function getChangeRequestCode(): string
    {
        return $this->changeRequestCode;
    }
}

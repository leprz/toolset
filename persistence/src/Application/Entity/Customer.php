<?php

declare(strict_types=1);

namespace Persistence\Application\Entity;

use Persistence\Application\UseCase\CustomerChangeEmail\Exception\InvalidChangeRequestCode;
use Persistence\Application\ValueObject\CustomerFullName;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Application\ValueObject\Email;

class Customer
{
    /**
     * @var \Persistence\Application\ValueObject\CustomerId
     */
    protected CustomerId $customerId;

    /**
     * @var \Persistence\Application\ValueObject\CustomerFullName
     */
    protected CustomerFullName $name;

    /**
     * @var \Persistence\Application\ValueObject\Email
     */
    protected Email $email;

    /**
     * @var string
     * On production app this should be generated for each change request.
     */
    private string $emailChangeRequestCode = 'abc123';

    /**
     * @param \Persistence\Application\ValueObject\CustomerId $customerId
     * @param \Persistence\Application\ValueObject\Email $email
     * @param \Persistence\Application\ValueObject\CustomerFullName $customerName
     */
    private function __construct(CustomerId $customerId, Email $email, CustomerFullName $customerName)
    {
        $this->customerId = $customerId;
        $this->email = $email;
        $this->name = $customerName;
    }

    /**
     * @param \Persistence\Application\ValueObject\CustomerId $customerId
     * @param \Persistence\Application\ValueObject\Email $email
     * @param \Persistence\Application\ValueObject\CustomerFullName $customerFullName
     * @return \Persistence\Application\Entity\Customer
     */
    public static function register(CustomerId $customerId, Email $email, CustomerFullName $customerFullName): Customer
    {
        return new self($customerId, $email, $customerFullName);
    }

    /**
     * @param \Persistence\Application\ValueObject\Email $email
     * @param string $changeRequestCode
     * @throws \Persistence\Application\UseCase\CustomerChangeEmail\Exception\InvalidChangeRequestCode
     */
    public function changeEmail(Email $email, string $changeRequestCode): void
    {
        if ($this->emailChangeRequestCode !== $changeRequestCode) {
            throw new InvalidChangeRequestCode('Code invalid. Can not change email');
        }

        $this->email = $email;
    }
}

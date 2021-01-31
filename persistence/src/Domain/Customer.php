<?php

declare(strict_types=1);

namespace Persistence\Domain;

use Persistence\Application\UseCase\CustomerChangeEmail\Exception\InvalidChangeRequestCode;
use Persistence\Domain\ValueObject\CustomerFullName;
use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;

class Customer
{
    /**
     * @var \Persistence\Domain\ValueObject\CustomerId
     */
    protected CustomerId $customerId;

    /**
     * @var \Persistence\Domain\ValueObject\CustomerFullName
     */
    protected CustomerFullName $name;

    /**
     * @var \Persistence\Domain\ValueObject\Email
     */
    protected Email $email;

    /**
     * @var string
     * On production app this should be generated for each change request.
     */
    private string $emailChangeRequestCode = 'abc123';

    /**
     * @param \Persistence\Domain\ValueObject\CustomerId $customerId
     * @param \Persistence\Domain\ValueObject\Email $email
     * @param \Persistence\Domain\ValueObject\CustomerFullName $customerName
     */
    private function __construct(CustomerId $customerId, Email $email, CustomerFullName $customerName)
    {
        $this->customerId = $customerId;
        $this->email = $email;
        $this->name = $customerName;
    }

    /**
     * @param \Persistence\Domain\ValueObject\CustomerId $customerId
     * @param \Persistence\Domain\ValueObject\Email $email
     * @param \Persistence\Domain\ValueObject\CustomerFullName $customerFullName
     * @return \Persistence\Domain\Customer
     */
    public static function register(CustomerId $customerId, Email $email, CustomerFullName $customerFullName): Customer
    {
        return new self($customerId, $email, $customerFullName);
    }

    /**
     * @param \Persistence\Domain\ValueObject\Email $email
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

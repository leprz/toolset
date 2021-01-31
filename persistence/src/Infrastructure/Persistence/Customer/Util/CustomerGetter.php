<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer\Util;

use Persistence\Domain\Customer;
use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;

class CustomerGetter extends Customer
{
    /**
     * @param \Persistence\Domain\Customer $customer
     * @return \Persistence\Domain\ValueObject\CustomerId
     */
    public static function getId(Customer $customer): CustomerId
    {
        return $customer->customerId;
    }

    /**
     * @param \Persistence\Domain\Customer $customer
     * @return string
     */
    public static function getFirstName(Customer $customer): string
    {
        return $customer->name->getFirstName();
    }

    /**
     * @param \Persistence\Domain\Customer $customer
     * @return string
     */
    public static function getLastName(Customer $customer): string
    {
        return $customer->name->getLastName();
    }

    /**
     * @param \Persistence\Domain\Customer $customer
     * @return \Persistence\Domain\ValueObject\Email
     */
    public static function getEmail(Customer $customer): Email
    {
        return $customer->email;
    }
}

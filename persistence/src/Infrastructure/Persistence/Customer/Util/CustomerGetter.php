<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer\Util;

use Persistence\Application\Entity\Customer;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Application\ValueObject\Email;

class CustomerGetter extends Customer
{
    public static function getId(Customer $customer): CustomerId
    {
        return $customer->customerId;
    }

    public static function getFirstName(Customer $customer): string
    {
        return $customer->name->getFirstName();
    }

    public static function getLastName(Customer $customer): string
    {
        return $customer->name->getLastName();
    }

    public static function getEmail(Customer $customer): Email
    {
        return $customer->email;
    }
}

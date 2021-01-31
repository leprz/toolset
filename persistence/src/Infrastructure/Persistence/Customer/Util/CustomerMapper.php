<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer\Util;

use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;
use Persistence\Domain\Customer;
use Persistence\Domain\ValueObject\CustomerFullName;
use Persistence\Infrastructure\Persistence\Exception\MappingException;
use ReflectionClass;
use ReflectionException;

class CustomerMapper
{
    /**
     * @param array<mixed> $row
     * @return \Persistence\Domain\Customer
     * @throws \Persistence\Infrastructure\Persistence\Exception\MappingException
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function mapFromDataSource(array $row): Customer
    {
        [$customerId, $email, $firstName, $lastName] = $row;

        $reflection = new ReflectionClass(Customer::class);

        /** @var Customer $customer */
        $customer = $reflection->newInstanceWithoutConstructor();

        try {
            $reflectionProperty = $reflection->getProperty('customerId');
            $reflectionProperty->setAccessible(true);

            /**
             * @noinspection PhpUnhandledExceptionInspection
             * This is fragile to data corruption coming from the data store. It should be handled somehow.
             */
            $reflectionProperty->setValue($customer, CustomerId::fromString($customerId));

            $reflectionProperty = $reflection->getProperty('email');
            $reflectionProperty->setAccessible(true);

            /** @noinspection PhpUnhandledExceptionInspection */
            $reflectionProperty->setValue($customer, Email::fromString($email));

            $reflectionProperty = $reflection->getProperty('name');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($customer, new CustomerFullName($firstName, $lastName));

            return $customer;
        } catch (ReflectionException $e) {
            throw new MappingException($e->getMessage());
        }
    }

    /**
     * @param \Persistence\Domain\Customer $customer
     * @return array<mixed>
     */
    public function mapToDataSource(Customer $customer): array
    {
        return [
            (string)CustomerGetter::getId($customer),
            (string)CustomerGetter::getEmail($customer),
            CustomerGetter::getFirstName($customer),
            CustomerGetter::getLastName($customer),
        ];
    }
}

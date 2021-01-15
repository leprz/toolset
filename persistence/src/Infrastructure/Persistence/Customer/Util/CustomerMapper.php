<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer\Util;

use Persistence\Application\Entity\Customer;
use Persistence\Application\ValueObject\CustomerFullName;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Application\ValueObject\Email;
use Persistence\Infrastructure\Persistence\Exception\MappingException;
use ReflectionClass;
use ReflectionException;

class CustomerMapper
{
    /**
     * @param array<mixed> $row
     * @return \Persistence\Application\Entity\Customer
     * @throws \Persistence\Infrastructure\Persistence\Exception\MappingException
     */
    public function mapFromDataSource(array $row): Customer
    {
        $reflection = new ReflectionClass(Customer::class);

        /** @var Customer $customer */
        $customer = $reflection->newInstanceWithoutConstructor();

        try {
            $reflectionProperty = $reflection->getProperty('customerId');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($customer, CustomerId::fromString($row[0]));

            $reflectionProperty = $reflection->getProperty('email');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($customer, new Email($row[1]));

            $reflectionProperty = $reflection->getProperty('name');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($customer, new CustomerFullName($row[2], $row[3]));

            return $customer;
        } catch (ReflectionException $e) {
            throw new MappingException($e->getMessage());
        }
    }

    /**
     * @param \Persistence\Application\Entity\Customer $customer
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

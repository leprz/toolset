<?php

declare(strict_types=1);

namespace App\UseCase\OrderPlace\Infrastructure;

use App\Domain\ValueObject\CustomerId;
use App\Infrastructure\Entity\CustomerEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderPlaceFixtures extends Fixture
{
    public const CUSTOMER_ID = '3ABB36F4-0F2A-4E61-87A7-34A5E0118342';

    public function load(ObjectManager $manager)
    {
        $customer = $this->createJohnDoeCustomer(self::CUSTOMER_ID, 'John Doe');
        $manager->persist($customer);
        $this->setReference(self::CUSTOMER_ID, $customer);

        $manager->flush();
    }

    private function createJohnDoeCustomer(string $customerId, string $name): CustomerEntity
    {
        return new CustomerEntity(
            CustomerId::fromString($customerId),
            $name
        );
    }
}

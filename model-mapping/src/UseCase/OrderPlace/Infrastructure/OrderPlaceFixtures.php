<?php

declare(strict_types=1);

namespace App\UseCase\OrderPlace\Infrastructure;

use App\Domain\ValueObject\CustomerId;
use App\Infrastructure\Entity\CustomerEntity;
use App\Infrastructure\DataFixture\ReferenceFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderPlaceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->createCustomer(ReferenceFixture::CUSTOMER_ID, 'John Doe', $manager);

        $manager->flush();
    }

    private function createCustomer(string $customerId, string $name, ObjectManager $manager): void
    {

        $customer = new CustomerEntity(
            CustomerId::fromString($customerId),
            $name
        );
        $manager->persist($customer);

        $this->setReference($customerId, $customer);
    }
}

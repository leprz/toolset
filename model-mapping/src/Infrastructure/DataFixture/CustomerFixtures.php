<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixture;

use App\Domain\ValueObject\CustomerId;
use App\Infrastructure\Entity\CustomerEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class CustomerFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker->build();
    }

    public function load(ObjectManager $manager): void
    {
        $this->createCustomer(ReferenceFixture::$CUSTOMER_ID, 'John Doe', $manager);

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

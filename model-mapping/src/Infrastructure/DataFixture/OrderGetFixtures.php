<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixture;

use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\Entity\OrderEntity;
use App\Infrastructure\Entity\OrderLineItemEntity;
use App\UseCase\OrderPlace\Infrastructure\OrderPlaceFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class OrderGetFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker->build();
    }

    public function load(ObjectManager $manager): void
    {
        $price1 = $this->faker->randomFloat(2, 1, 4);
        $price2 = $this->faker->randomFloat(2, 1, 4);

        $total = $price1 + $price2;

        $this->createOrder(
            ReferenceFixture::$ORDER_ID,
            ReferenceFixture::$CUSTOMER_ID,
            $total,
            $manager,
        );

        $this->createOrderLineItem(
            ReferenceFixture::$ORDER_LINE_ITEM_1_ID,
            ReferenceFixture::$ORDER_ID,
            $this->faker->sentence(3),
            $price1,
            $manager
        );

        $this->createOrderLineItem(
            ReferenceFixture::$ORDER_LINE_ITEM_2_ID,
            ReferenceFixture::$ORDER_ID,
            $this->faker->sentence(3),
            $price2,
            $manager
        );

        $manager->flush();
    }

    private function createOrderLineItem(
        string $lineItemId,
        string $orderId,
        string $name,
        float $price,
        ObjectManager $manager
    ): OrderLineItemEntity {
        /** @noinspection PhpParamsInspection */
        $lineItem = new OrderLineItemEntity(
            id: LineItemId::fromString($lineItemId),
            order: $this->getReference($orderId),
            name: $name,
            price: new Money($price)
        );

        $manager->persist($lineItem);

        $this->setReference($lineItemId, $lineItem);

        return $lineItem;
    }

    private function createOrder(
        string $orderId,
        string $customerId,
        float $totalPrice,
        ObjectManager $manager
    ): void {
        /** @noinspection PhpParamsInspection */
        $order = new OrderEntity(
            id: OrderId::fromString($orderId),
            customer: $this->getReference($customerId),
            totalPrice: new Money($totalPrice)
        );

        $manager->persist($order);

        $this->setReference($orderId, $order);
    }

    public function getDependencies(): array
    {
        return [
            OrderPlaceFixtures::class,
        ];
    }
}

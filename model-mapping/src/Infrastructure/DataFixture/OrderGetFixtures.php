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

class OrderGetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createOrder(
            ReferenceFixture::ORDER_ID,
            ReferenceFixture::CUSTOMER_ID,
            4.00,
            $manager,
        );

        $this->createOrderLineItem(
            ReferenceFixture::ORDER_LINE_ITEM_ID,
            ReferenceFixture::ORDER_ID,
            'Magic crystal ball',
            2.00,
            $manager
        );

        $this->createOrderLineItem(
            'FB29CF2D-CFD1-4EDB-AD97-E7A75590DC27',
            ReferenceFixture::ORDER_ID,
            'Golden fish',
            2.00,
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

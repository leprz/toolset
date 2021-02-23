<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Infrastructure;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Infrastructure\DataFixture\Faker;
use App\Infrastructure\DataFixture\ReferenceFixture;
use App\Infrastructure\Entity\CartEntity;
use App\Infrastructure\Entity\CartLineItemEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class ProductPlaceInCartDataFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker->build();
    }

    public function load(ObjectManager $manager)
    {
        $this->createCart(ReferenceFixture::$CART_ID, ReferenceFixture::$CUSTOMER_ID, $manager);

        $this->createCartLineItem(
            id: ReferenceFixture::$CART_LINE_ITEM_1_ID,
            name: $this->faker->word,
            price: 1.99,
            cartId: ReferenceFixture::$CART_ID,
            manager: $manager
        );

        $this->createCartLineItem(
            id: ReferenceFixture::$CART_LINE_ITEM_2_ID,
            name: $this->faker->word,
            price: 2.99,
            cartId: ReferenceFixture::$CART_ID,
            manager: $manager
        );

        $manager->flush();
    }

    /** @noinspection PhpParamsInspection */
    private function createCart(string $cartId, string $customerId, ObjectManager $manager): void
    {
        $cart = new CartEntity(
            CartId::fromString($cartId),
            $this->getReference($customerId)
        );

        $manager->persist($cart);

        $this->setReference($cartId, $cart);
    }

    private function createCartLineItem(
        string $id,
        string $name,
        float $price,
        string $cartId,
        ObjectManager $manager
    ): void {
        /** @noinspection PhpParamsInspection */
        $lineItem = new CartLineItemEntity(
            LineItemId::fromString($id),
            $this->getReference($cartId),
            $name,
            new Money($price)
        );

        $manager->persist($lineItem);

        $this->setReference($id, $lineItem);
    }
}

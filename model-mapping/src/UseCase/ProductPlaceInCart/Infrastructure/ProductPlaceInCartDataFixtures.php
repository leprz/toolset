<?php

declare(strict_types=1);

namespace App\UseCase\ProductPlaceInCart\Infrastructure;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Infrastructure\Entity\CartEntity;
use App\Infrastructure\Entity\CartLineItemEntity;
use App\Infrastructure\Entity\CustomerEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductPlaceInCartDataFixtures extends Fixture
{
    public const CART_ID = '55CD3A1C-4B9C-4262-8D12-1EBF4838231D';

    public function load(ObjectManager $manager)
    {
        /** @var \App\Infrastructure\Entity\CustomerEntity $customer */
        $customer = $this->getReference('3ABB36F4-0F2A-4E61-87A7-34A5E0118342');

        $cart = $this->createCart(self::CART_ID, $customer);

        $manager->persist(
            $this->createCartLineItem(
                id: 'EF87A7D4-20C6-432A-A15B-5D5AC060F8E2',
                name: 'Bag full of snacks',
                price: 1.99,
                cart: $cart
            )
        );

        $manager->persist(
            $this->createCartLineItem(
                id: '78C683F7-5A55-4620-A633-9F8FD791044A',
                name: 'Magic cristal ball',
                price: 3.99,
                cart: $cart
            )
        );

        $manager->persist($cart);

        $manager->flush();
    }

    private function createCart(string $cartId, CustomerEntity $customer): CartEntity
    {
        return new CartEntity(
            CartId::fromString($cartId),
            $customer
        );
    }

    private function createCartLineItem(string $id, string $name, float $price, CartEntity $cart): CartLineItemEntity
    {
        $lineItem = new CartLineItemEntity();

        $lineItem->setId(LineItemId::fromString($id));
        $lineItem->setCart($cart);
        $lineItem->setPrice(new Money($price));
        $lineItem->setName($name);

        return $lineItem;
    }
}

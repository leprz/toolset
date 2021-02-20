<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application\Persistence\Cart\CartRepositoryInterface;
use App\Domain\Cart;
use App\Domain\ValueObject\CartId;
use App\Infrastructure\DataFixture\ReferenceFixture;
use App\Infrastructure\Persistence\Cart\CartProxy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CartPersistenceTest extends KernelTestCase
{
    private CartRepositoryInterface $repository;

    public function testGetById(): void
    {
        $cart = $this->repository->getById($this->cartIdFixture());

        $this->assertCartProxyHasBeenFetched($cart);
    }

    private function assertCartProxyHasBeenFetched(Cart $cart): void
    {
        self::assertInstanceOf(CartProxy::class, $cart);

        if ($cart instanceof CartProxy) {
            $entity = $cart->getEntity();
            self::assertEquals($this->cartIdFixture(), $entity->getId());
        }
    }

    private function cartIdFixture(): CartId
    {
        return CartId::fromString(ReferenceFixture::$CART_ID);
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::$container->get(CartRepositoryInterface::class);
    }
}

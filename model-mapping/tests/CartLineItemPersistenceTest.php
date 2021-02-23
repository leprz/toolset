<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application\Persistence\CartLineItem\CartLineItemRepositoryInterface;
use App\Domain\CartLineItem;
use App\Domain\ValueObject\LineItemId;
use App\Infrastructure\DataFixture\ReferenceFixture;
use App\Infrastructure\Persistence\CartLineItem\CartLineItemEntityMapper;
use App\Infrastructure\Persistence\CartLineItem\CartLineItemProxy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CartLineItemPersistenceTest extends KernelTestCase
{
    private CartLineItemRepositoryInterface $repository;
    private CartLineItemEntityMapper $mapper;

    public function test(): void
    {
        $lineItem = $this->repository->getById($this->cartLineItemFixture());
        $this->assertLineItemProxyHasBeenFetched($lineItem);
    }

    private function assertLineItemProxyHasBeenFetched(CartLineItem $lineItem): void
    {
        self::assertInstanceOf(CartLineItemProxy::class, $lineItem);

        if ($lineItem instanceof CartLineItemProxy) {
            $entity = $lineItem->getEntity($this->mapper);
            self::assertEquals($this->cartLineItemFixture(), $entity->getId());
        }
    }

    private function cartLineItemFixture(): LineItemId
    {
        return LineItemId::fromString(ReferenceFixture::$CART_LINE_ITEM_1_ID);
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->mapper = self::$container->get(CartLineItemEntityMapper::class);
        $this->repository = self::$container->get(CartLineItemRepositoryInterface::class);
    }
}

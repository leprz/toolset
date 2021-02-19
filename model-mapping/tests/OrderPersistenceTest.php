<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application\Persistence\Order\OrderRepositoryInterface;
use App\Domain\Order;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\DataFixture\ReferenceFixture;
use App\Infrastructure\Persistence\Order\OrderEntityMapper;
use App\Infrastructure\Persistence\Order\OrderProxy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderPersistenceTest extends KernelTestCase
{
    private OrderRepositoryInterface $repository;
    private OrderEntityMapper $mapper;

    public function testGetForId(): void
    {
        $order = $this->repository->getForId($this->orderIdFixture());

        $this->assertOrderProxyHasBeenFetched($order);
    }

    private function orderIdFixture(): OrderId
    {
        return OrderId::fromString(ReferenceFixture::ORDER_ID);
    }

    private function assertOrderProxyHasBeenFetched(Order $order): void
    {
        self::assertInstanceOf(OrderProxy::class, $order);

        if ($order instanceof OrderProxy) {
            $entity = $order->getEntity($this->mapper);
            self::assertEquals($this->orderIdFixture(), $entity->getId());
        }
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::$container->get(OrderRepositoryInterface::class);
        $this->mapper = self::$container->get(OrderEntityMapper::class);
    }
}

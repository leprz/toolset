<?php

declare(strict_types=1);

namespace App\Tests\UseCase\OrderPlace;

use App\Application\Persistence\Cart\CartPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use App\Application\Persistence\Order\OrderPersistenceInterface;
use App\Application\Persistence\Order\OrderRepositoryInterface;
use App\Application\Persistence\OrderLineItem\OrderLineItemPersistenceInterface;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\OrderId;
use App\Infrastructure\Persistence\Order\OrderEntityMapper;
use App\Infrastructure\Persistence\Order\OrderProxy;
use App\UseCase\OrderPlace\Application\OrderPlaceCommand;
use App\UseCase\OrderPlace\Application\OrderPlaceUseCase;
use App\UseCase\ProductPlaceInCart\Infrastructure\ProductPlaceInCartDataFixtures;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderPlaceUseCaseTest extends KernelTestCase
{
    private OrderPlaceUseCase $useCase;
    private OrderRepositoryInterface $orderRepository;
    private OrderEntityMapper $orderMapper;
    private OrderPersistenceInterface $orderPersistence;
    private OrderLineItemPersistenceInterface $orderLineItemPersistence;
    private MockObject|CartPersistenceInterface $cartPersistenceMock;
    private MockObject|CartLineItemPersistenceInterface $cartLineItemPersistence;

    /** @var \App\Infrastructure\Entity\OrderEntity[] */
    private array $addedOrders;

    public function testOrderPlace(): void
    {
        $this->assertCartHasBeenCleared();
        $this->assertCartHasBeenRemoved();

        ($this->useCase)($this->placeOrderCommandFixture());

        $this->assertOrderHasBeenPlaced();

        $this->cleanUp();
    }

    private function cleanUp(): void
    {
        foreach ($this->addedOrders as $order) {
            $this->orderLineItemPersistence->removeForOrderId($order->getId());
            $this->orderPersistence->removeById($order->getId());
        }
    }

    private function placeOrderCommandFixture(): OrderPlaceCommand
    {
        return new OrderPlaceCommand(
            CartId::fromString(ProductPlaceInCartDataFixtures::CART_ID),
            $this->orderIdFixture(),
        );
    }

    private function orderIdFixture(): OrderId
    {
        return OrderId::fromString('0EEDCE9B-31E5-4386-B7E6-1E3C95289168');
    }

    private function assertOrderHasBeenPlaced(): void
    {
        $order = $this->orderRepository->getForId($this->orderIdFixture());

        if ($order instanceof OrderProxy) {
            $orderEntity = $order->getEntity($this->orderMapper);
            $this->addedOrders[] = $orderEntity;
            self::assertTrue($orderEntity->getId()->equals($this->orderIdFixture()));
        }
    }

    private function assertCartHasBeenCleared(): void
    {
        $this->cartLineItemPersistence->expects(self::once())->method('removeForCartId');
    }

    private function assertCartHasBeenRemoved(): void
    {
        $this->cartPersistenceMock->expects(self::once())->method('removeById');
    }

    /**
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    protected function setUp(): void
    {
        self::bootKernel();

        $this->cartPersistenceMock = $this->createMock(CartPersistenceInterface::class);
        self::$container->set(
            CartPersistenceInterface::class,
            $this->cartPersistenceMock
        );

        $this->cartLineItemPersistence = $this->createMock(CartLineItemPersistenceInterface::class);
        self::$container->set(
            CartLineItemPersistenceInterface::class,
            $this->cartLineItemPersistence
        );

        $this->useCase = self::$container->get(OrderPlaceUseCase::class);
        $this->orderLineItemPersistence = self::$container->get(OrderLineItemPersistenceInterface::class);
        $this->orderRepository = self::$container->get(OrderRepositoryInterface::class);
        $this->orderMapper = self::$container->get(OrderEntityMapper::class);
        $this->orderPersistence = self::$container->get(OrderPersistenceInterface::class);
    }
}

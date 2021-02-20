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
use App\Infrastructure\DataFixture\ReferenceFixture;
use phpDocumentor\Reflection\Types\Self_;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderPlaceUseCaseTest extends KernelTestCase
{
    private OrderPlaceUseCase $useCase;
    private MockObject|OrderPersistenceInterface $orderPersistenceMock;
    private MockObject|CartPersistenceInterface $cartPersistenceMock;
    private MockObject|CartLineItemPersistenceInterface $cartLineItemPersistence;

    public function testOrderPlace(): void
    {
        $this->assertCartHasBeenCleared();
        $this->assertCartHasBeenRemoved();
        $this->assertOrderHasBeenPlaced();

        ($this->useCase)($this->placeOrderCommandFixture());
    }

    private function placeOrderCommandFixture(): OrderPlaceCommand
    {
        return new OrderPlaceCommand(
            CartId::fromString(ReferenceFixture::$CART_ID),
            $this->orderIdFixture(),
        );
    }

    private function orderIdFixture(): OrderId
    {
        return OrderId::fromString('0EEDCE9B-31E5-4386-B7E6-1E3C95289168');
    }

    private function assertOrderHasBeenPlaced(): void
    {
        $this->orderPersistenceMock->expects(self::once())->method('add');
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
            'test.'.CartLineItemPersistenceInterface::class,
            $this->cartLineItemPersistence
        );

        $this->orderPersistenceMock = $this->createMock(OrderPersistenceInterface::class);
        self::$container->set(
            OrderPersistenceInterface::class,
            $this->orderPersistenceMock
        );

        $this->useCase = self::$container->get(OrderPlaceUseCase::class);
    }
}

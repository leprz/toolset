<?php

declare(strict_types=1);

namespace App\Tests\UseCase\ProductPlaceInCart;

use App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface;
use App\Application\Persistence\CartLineItem\CartLineItemRepositoryInterface;
use App\Domain\Product;
use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Sku;
use App\Infrastructure\DataFixture\ReferenceFixture;
use App\UseCase\ProductPlaceInCart\Application\ProductPlaceInCartCommand;
use App\UseCase\ProductPlaceInCart\Application\ProductPlaceInCartUseCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductPlaceInCartUseCaseTest extends KernelTestCase
{
    private ProductPlaceInCartUseCase $useCase;
    /**
     * @var \App\Application\Persistence\CartLineItem\CartLineItemPersistenceInterface
     */
    private CartLineItemPersistenceInterface $cartLineItemPersistence;

    private CartLineItemRepositoryInterface $cartLineItemRepository;

    public function testPlaceInCart(): void
    {
        ($this->useCase)($this->successfullyPlaceProductCommandFixture());

        $this->assertProductHasBeenPlacedInCart();

        $this->cleanUp();
    }

    private function cleanUp(): void
    {
        $this->cartLineItemPersistence->remove(self::cartLineItemIdFixture());
    }

    private function successfullyPlaceProductCommandFixture(): ProductPlaceInCartCommand
    {
        return new ProductPlaceInCartCommand(
            lineItemId: self::cartLineItemIdFixture(),
            cartId: CartId::fromString(ReferenceFixture::CART_ID),
            product: Product::fromExisting(Sku::fromString('PL-22'), new Money(2.99), 'Mobile Phone'),
        );
    }

    private static function cartLineItemIdFixture(): LineItemId
    {
        return LineItemId::fromString('E727BD93-C3DE-4397-9906-103B5F229469');
    }

    private function assertProductHasBeenPlacedInCart(): void
    {
        $this->cartLineItemRepository->getById(self::cartLineItemIdFixture());
        self::assertTrue(true);
    }

    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;

        $this->cartLineItemPersistence = $container->get(CartLineItemPersistenceInterface::class);
        $this->cartLineItemRepository = $container->get(CartLineItemRepositoryInterface::class);
        $this->useCase = $container->get(ProductPlaceInCartUseCase::class);
    }
}

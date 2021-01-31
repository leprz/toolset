<?php

declare(strict_types=1);

namespace Persistence\Tests\Application\UseCase\CustomerRegister;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\UseCase\CustomerRegister\CustomerRegisterCommand;
use Persistence\Application\UseCase\CustomerRegister\CustomerRegisterUseCase;
use Persistence\Domain\ValueObject\Email;
use Persistence\Domain\ValueObject\CustomerFullName;
use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomerRegisterTest extends TestCase
{
    private CustomerRegisterUseCase $useCase;
    /**
     * @var \Persistence\Application\Persistence\Customer\CustomerPersistenceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $persistenceMock;

    public function testRegister(): void
    {
        $customerId = (new CustomerIdGenerator())->generate();

        $this->assertCustomerHasBeenPersisted();

        $this->useCase->handle(
            $this->registerCustomerCommandFixture($customerId)
        );
    }

    private function registerCustomerCommandFixture(CustomerId $customerId): CustomerRegisterCommand
    {
        return new CustomerRegisterCommand(
            $customerId,
            Email::fromString('john.doe@example.com'),
            new CustomerFullName('John', 'Doe')
        );
    }

    private function assertCustomerHasBeenPersisted(): void
    {
        $this->persistenceMock->expects(self::once())->method('add');
    }

    protected function setUp(): void
    {
        $this->persistenceMock = $this->createMock(CustomerPersistenceInterface::class);

        $this->useCase = new CustomerRegisterUseCase($this->persistenceMock);
    }
}

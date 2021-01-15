<?php

declare(strict_types=1);

namespace Persistence\Tests\UseCase\CustomerChangeEmail;

use Persistence\Application\Entity\Customer;
use Persistence\Application\Persistence\CustomerPersistenceInterface;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailCommand;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase;
use Persistence\Application\UseCase\CustomerChangeEmail\Exception\InvalidChangeRequestCode;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Application\ValueObject\Email;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerGetter;
use Persistence\Tests\KernelTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerChangeEmailTest extends KernelTestCase
{
    /**
     * @var \Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase
     */
    private CustomerChangeEmailUseCase $useCase;

    /**
     * @var \Persistence\Application\Persistence\CustomerPersistenceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $customerPersistenceMock;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHandle(): void
    {
        $newEmail = new Email('test@example.com');

        $this->assertEmailHasBeenChanged($newEmail);

        $this->useCase->handle($this->changeJohnDoeEmailCommandFixture($newEmail));
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHandleWithInvalidChangeRequestEmail(): void
    {
        $newEmail = new Email('test@example.com');

        $this->assertInvalidChangeRequestCodeFound();

        $this->useCase->handle($this->changeInvalidChangeRequestCodeCommandFixture($newEmail));
    }

    private function changeInvalidChangeRequestCodeCommandFixture(Email $newEmail): CustomerChangeEmailCommand
    {
        return new CustomerChangeEmailCommand(CustomerId::fromString('a1'), $newEmail, 'invalid-code');
    }

    private function assertInvalidChangeRequestCodeFound(): void
    {
        $this->expectException(InvalidChangeRequestCode::class);
    }

    private function assertEmailHasBeenChanged(Email $newEmail): void
    {
        $this->customerPersistenceMock->expects(self::once())
            ->method('save')->with(
                self::callback(
                    function (Customer $customer) use ($newEmail): bool {
                        return CustomerGetter::getEmail($customer)->equals($newEmail);
                    }
                )
            );
    }

    private function changeJohnDoeEmailCommandFixture(Email $newEmail): CustomerChangeEmailCommand
    {
        return new CustomerChangeEmailCommand(CustomerId::fromString('a1'), $newEmail, 'abc123');
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::$container;

        $this->customerPersistenceMock = $this->createMock(CustomerPersistenceInterface::class);

        $container[CustomerPersistenceInterface::class] = $this->customerPersistenceMock;

        $this->useCase = $container[CustomerChangeEmailUseCase::class];
    }
}

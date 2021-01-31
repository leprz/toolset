<?php

declare(strict_types=1);

namespace Persistence\Tests\Application\UseCase\CustomerChangeEmail;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailCommand;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase;
use Persistence\Application\UseCase\CustomerChangeEmail\Exception\InvalidChangeRequestCode;
use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;
use Persistence\Domain\Customer;
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
     * @var \Persistence\Application\Persistence\Customer\CustomerPersistenceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $customerPersistenceMock;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHandle(): void
    {
        $newEmail = Email::fromString('test@example.com');

        $this->assertEmailHasBeenChanged($newEmail);

        $this->useCase->handle($this->changeJohnDoeEmailCommandFixture($newEmail));
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHandleWithInvalidChangeRequestEmail(): void
    {
        $newEmail = Email::fromString('test@example.com');

        $this->assertInvalidChangeRequestCodeFound();

        $this->useCase->handle($this->changeInvalidChangeRequestCodeCommandFixture($newEmail));
    }

    private function changeInvalidChangeRequestCodeCommandFixture(Email $newEmail): CustomerChangeEmailCommand
    {
        return new CustomerChangeEmailCommand($this->customerIdFixture(), $newEmail, 'invalid-code');
    }

    private function customerIdFixture(): CustomerId
    {
        return CustomerId::fromString('8B8B3F05-96BE-473C-80BF-5D6F2D0B1449');
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
        return new CustomerChangeEmailCommand($this->customerIdFixture(), $newEmail, 'abc123');
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

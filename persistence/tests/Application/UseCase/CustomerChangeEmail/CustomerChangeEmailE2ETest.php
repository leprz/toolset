<?php

declare(strict_types=1);

namespace Persistence\Tests\Application\UseCase\CustomerChangeEmail;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\Persistence\Customer\CustomerRepositoryInterface;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailCommand;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase;
use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Domain\ValueObject\Email;
use Persistence\Domain\Customer;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerGetter;
use Persistence\Tests\KernelTestCase;

class CustomerChangeEmailE2ETest extends KernelTestCase
{
    /**
     * @var \Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase
     */
    private CustomerChangeEmailUseCase $useCase;

    /**
     * @var mixed|\Persistence\Application\Persistence\Customer\CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var \Persistence\Application\Persistence\Customer\CustomerPersistenceInterface
     */
    private CustomerPersistenceInterface $customerPersistence;

    /**
     * @var \Persistence\Domain\Customer
     */
    private Customer $customerInitialState;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHandle(): void
    {
        $newEmail = Email::fromString('test@example.com');

        $this->useCase->handle($this->changeJohnDoeEmailCommandFixture($newEmail));

        $this->assertEmailHasBeenChanged($newEmail);

        $this->databaseCleanUp();
    }

    private function changeJohnDoeEmailCommandFixture(Email $newEmail): CustomerChangeEmailCommand
    {
        return new CustomerChangeEmailCommand($this->customerIdFixture(), $newEmail, 'abc123');
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function assertEmailHasBeenChanged(Email $newEmail): void
    {
        $customer = $this->customerRepository->getForId($this->customerIdFixture());

        self::assertEquals($newEmail, CustomerGetter::getEmail($customer));
    }

    private function customerIdFixture(): CustomerId
    {
        return CustomerId::fromString('8B8B3F05-96BE-473C-80BF-5D6F2D0B1449');
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function databaseCleanUp(): void
    {
        $this->customerPersistence->save($this->customerInitialState);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::$container;

        $this->useCase = $container[CustomerChangeEmailUseCase::class];

        $this->customerRepository = $container[CustomerRepositoryInterface::class];

        $this->customerPersistence = $container[CustomerPersistenceInterface::class];

        $this->customerInitialState = $this->customerRepository->getForId(
            CustomerId::fromString('8B8B3F05-96BE-473C-80BF-5D6F2D0B1449')
        );
    }
}

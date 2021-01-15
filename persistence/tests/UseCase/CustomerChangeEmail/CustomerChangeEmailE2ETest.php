<?php

declare(strict_types=1);

namespace Persistence\Tests\UseCase\CustomerChangeEmail;

use Persistence\Application\Entity\Customer;
use Persistence\Application\Persistence\CustomerPersistenceInterface;
use Persistence\Application\Repository\CustomerRepositoryInterface;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailCommand;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Application\ValueObject\Email;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerGetter;
use Persistence\Tests\KernelTestCase;

class CustomerChangeEmailE2ETest extends KernelTestCase
{
    /**
     * @var \Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase
     */
    private CustomerChangeEmailUseCase $useCase;

    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var \Persistence\Application\Persistence\CustomerPersistenceInterface
     */
    private CustomerPersistenceInterface $customerPersistence;

    /**
     * @var \Persistence\Application\Entity\Customer
     */
    private Customer $customerInitialState;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHandle(): void
    {
        $newEmail = new Email('test@example.com');

        $this->useCase->handle($this->changeJohnDoeEmailCommandFixture($newEmail));

        $this->assertEmailHasBeenChanged($newEmail);

        $this->databaseCleanUp();
    }

    private function changeJohnDoeEmailCommandFixture(Email $newEmail): CustomerChangeEmailCommand
    {
        return new CustomerChangeEmailCommand(CustomerId::fromString('a1'), $newEmail, 'abc123');
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function assertEmailHasBeenChanged(Email $newEmail): void
    {
        $customer = $this->customerRepository->getForId(CustomerId::fromString('a1'));

        self::assertEquals($newEmail, CustomerGetter::getEmail($customer));
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

        $this->customerInitialState = $this->customerRepository->getForId(CustomerId::fromString('a1'));
    }
}

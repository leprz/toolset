<?php

declare(strict_types=1);

namespace Persistence\Tests\UseCase\CustomerRegister;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\Persistence\Customer\CustomerRepositoryInterface;
use Persistence\Application\UseCase\CustomerRegister\CustomerRegisterCommand;
use Persistence\Application\UseCase\CustomerRegister\CustomerRegisterUseCase;
use Persistence\Application\ValueObject\CustomerFullName;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Application\ValueObject\Email;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerGetter;
use Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator;
use Persistence\Infrastructure\Persistence\Customer\CustomerInMemoryRepository;
use Persistence\Tests\KernelTestCase;

class CustomerRegisterE2ETest extends KernelTestCase
{
    /**
     * @var \Persistence\Application\UseCase\CustomerRegister\CustomerRegisterUseCase
     */
    private CustomerRegisterUseCase $useCase;

    /**
     * @var \Persistence\Infrastructure\Persistence\Customer\CustomerInMemoryRepository
     */
    private CustomerInMemoryRepository $repository;

    /**
     * @var \Persistence\Application\Entity\Customer[]
     */
    private array $savedCustomers;

    /**
     * @var \Persistence\Application\Persistence\Customer\CustomerPersistenceInterface
     */
    private CustomerPersistenceInterface $persistence;

    public function testRegister(): void
    {
        $customerId = (new CustomerIdGenerator())->generate();

        $this->useCase->handle(
            $this->registerCustomerCommandFixture($customerId)
        );

        $this->assertCustomerHasBeenPersisted($customerId);

        $this->databaseCleanUp();
    }

    private function registerCustomerCommandFixture(CustomerId $customerId): CustomerRegisterCommand
    {
        return new CustomerRegisterCommand(
            $customerId,
            new Email('john.doe@example.com'),
            new CustomerFullName('John', 'Doe')
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function assertCustomerHasBeenPersisted(CustomerId $customerId): void
    {
        $customer = $this->repository->getForId($customerId);

        self::assertEquals('John', CustomerGetter::getFirstName($customer));

        $this->savedCustomers[] = $customer;
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function databaseCleanUp(): void
    {
        foreach ($this->savedCustomers as $customer) {
            $this->persistence->remove($customer);
        }
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::$container;

        $this->repository = $container[CustomerRepositoryInterface::class];

        $this->persistence = $container[CustomerPersistenceInterface::class];

        $this->useCase = $container[CustomerRegisterUseCase::class];
    }
}

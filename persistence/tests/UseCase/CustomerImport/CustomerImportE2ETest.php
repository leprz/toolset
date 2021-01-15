<?php

declare(strict_types=1);

namespace Persistence\Tests\Application\UseCase\CustomerImport;

use Persistence\Application\Persistence\CustomerPersistenceInterface;
use Persistence\Application\Repository\CustomerRepositoryInterface;
use Persistence\Application\UseCase\CustomerImport\CustomerImportCommand;
use Persistence\Application\UseCase\CustomerImport\CustomerImportUseCase;
use Persistence\Application\UseCase\CustomerImport\CustomerToImport;
use Persistence\Application\ValueObject\CustomerFullName;
use Persistence\Application\ValueObject\Email;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerGetter;
use Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator;
use Persistence\Infrastructure\Persistence\Customer\CustomerInMemoryRepository;
use Persistence\Tests\Fixture\CustomerIdGeneratorFixture;
use Persistence\Tests\KernelTestCase;

class CustomerImportE2ETest extends KernelTestCase
{
    /**
     * @var \Persistence\Tests\Fixture\CustomerIdGeneratorFixture
     */
    private CustomerIdGeneratorFixture $customerIdGenerator;

    /**
     * @var \Persistence\Application\UseCase\CustomerImport\CustomerImportUseCase
     */
    private CustomerImportUseCase $useCase;

    /**
     * @var \Persistence\Infrastructure\Persistence\Customer\CustomerInMemoryRepository
     */
    private CustomerInMemoryRepository $repository;

    /**
     * @var \Persistence\Application\Entity\Customer[]
     */
    private array $savedCustomers = [];

    /**
     * @var \Persistence\Application\Persistence\CustomerPersistenceInterface
     */
    private CustomerPersistenceInterface $persistence;

    public function testImport(): void
    {
        $this->useCase->handle(
            $this->importBobAndMatCommandFixture()
        );

        $this->assertBothBobAndMatHasBeenImported();

        $this->databaseCleanUp();
    }

    private function importBobAndMatCommandFixture(): CustomerImportCommand
    {
        $command = new CustomerImportCommand();

        $command->addData(
            new CustomerToImport(
                new Email('bob@example.com'),
                new CustomerFullName('Bob', 'Lee')
            )
        );

        $command->addData(
            new CustomerToImport(
                new Email('matt@example.com'),
                new CustomerFullName('Matt', 'Lee')
            )
        );

        return $command;
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function assertBothBobAndMatHasBeenImported(): void
    {
        $generatedIds = $this->customerIdGenerator->getGeneratedIds();

        foreach ($generatedIds as $customerId) {
            $customer = $this->repository->getForId($customerId);

            self::assertContains(CustomerGetter::getFirstName($customer), ['Bob', 'Matt']);

            $this->savedCustomers[] = $customer;
        }

        self::assertCount(2, $this->savedCustomers);
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

        $this->customerIdGenerator = new CustomerIdGeneratorFixture();

        $container[CustomerIdGenerator::class] = $this->customerIdGenerator;

        $this->repository = $container[CustomerRepositoryInterface::class];

        $this->persistence = $container[CustomerPersistenceInterface::class];

        $this->useCase = $container[CustomerImportUseCase::class];
    }
}

<?php

declare(strict_types=1);

namespace Persistence\Tests\Application\UseCase\CustomerImport;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\UseCase\CustomerImport\CustomerImportCommand;
use Persistence\Application\UseCase\CustomerImport\CustomerImportUseCase;
use Persistence\Application\UseCase\CustomerImport\CustomerToImport;
use Persistence\Application\ValueObject\CustomerFullName;
use Persistence\Application\ValueObject\Email;
use Persistence\Tests\KernelTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerImportTest extends KernelTestCase
{
    /**
     * @var \Persistence\Application\UseCase\CustomerImport\CustomerImportUseCase
     */
    private CustomerImportUseCase $useCase;

    /**
     * @var \Persistence\Application\Persistence\Customer\CustomerPersistenceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $customerPersistenceMock;

    public function testImport(): void
    {
        $this->assertBothBobAndMatHasBeenImported();

        $this->useCase->handle(
            $this->importBobAndMatCommandFixture()
        );
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

    private function assertBothBobAndMatHasBeenImported(): void
    {
        $this->customerPersistenceMock->expects(self::exactly(2))->method('add');
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::$container;

        $this->customerPersistenceMock = $this->createMock(CustomerPersistenceInterface::class);

        $container[CustomerPersistenceInterface::class] = $this->customerPersistenceMock;

        $this->useCase = $container[CustomerImportUseCase::class];
    }
}

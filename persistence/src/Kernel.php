<?php

declare(strict_types=1);

namespace Persistence;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\Persistence\Customer\CustomerRepositoryInterface;
use Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailUseCase;
use Persistence\Application\UseCase\CustomerImport\CustomerImportUseCase;
use Persistence\Application\UseCase\CustomerRegister\CustomerRegisterUseCase;
use Persistence\Infrastructure\DataSource\CustomerDataSource;
use Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator;
use Persistence\Infrastructure\Persistence\Customer\CustomerInMemoryPersistence;
use Persistence\Infrastructure\Persistence\Customer\CustomerInMemoryRepository;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper;
use Pimple\Container;

class Kernel
{
    /**
     * @var \Pimple\Container
     */
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function boot(): void
    {
        $this->container[CustomerDataSource::class] = static function (): CustomerDataSource {
            return new CustomerDataSource();
        };

        $this->container[CustomerMapper::class] = static function (): CustomerMapper {
            return new CustomerMapper();
        };

        $this->container[CustomerRepositoryInterface::class] =
            static function (Container $c): CustomerInMemoryRepository {
                return new CustomerInMemoryRepository($c[CustomerDataSource::class], $c[CustomerMapper::class]);
            };

        $this->container[CustomerIdGenerator::class] =
            static function (): CustomerIdGenerator {
                return new CustomerIdGenerator();
            };

        $this->container[CustomerPersistenceInterface::class] =
            static function (Container $c): CustomerInMemoryPersistence {
                return new CustomerInMemoryPersistence(
                    $c[CustomerDataSource::class],
                    $c[CustomerIdGenerator::class],
                    $c[CustomerMapper::class]
                );
            };

        $this->container[CustomerImportUseCase::class] =
            static function (Container $c): CustomerImportUseCase {
                return new CustomerImportUseCase($c[CustomerPersistenceInterface::class]);
            };

        $this->container[CustomerRegisterUseCase::class] =
            static function (Container $c): CustomerRegisterUseCase {
                return new CustomerRegisterUseCase($c[CustomerPersistenceInterface::class]);
            };

        $this->container[CustomerChangeEmailUseCase::class] =
            static function (Container $c): CustomerChangeEmailUseCase {
                return new CustomerChangeEmailUseCase(
                    $c[CustomerRepositoryInterface::class],
                    $c[CustomerPersistenceInterface::class]
                );
            };
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}

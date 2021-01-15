<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer;

use Persistence\Application\Entity\Customer;
use Persistence\Application\Persistence\CustomerPersistenceInterface;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Infrastructure\DataSource\CustomerDataSource;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerGetter;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper;

class CustomerInMemoryPersistence implements CustomerPersistenceInterface
{
    /**
     * @var \Persistence\Infrastructure\DataSource\CustomerDataSource
     */
    private CustomerDataSource $dataSource;
    /**
     * @var \Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator
     */
    private CustomerIdGenerator $idGenerator;
    /**
     * @var \Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper
     */
    private CustomerMapper $mapper;

    /**
     * @param \Persistence\Infrastructure\DataSource\CustomerDataSource $dataSource
     * @param \Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator $idGenerator
     * @param \Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper $mapper
     */
    public function __construct(
        CustomerDataSource $dataSource,
        CustomerIdGenerator $idGenerator,
        CustomerMapper $mapper
    ) {
        $this->dataSource = $dataSource;
        $this->idGenerator = $idGenerator;
        $this->mapper = $mapper;
    }

    public function add(Customer $customer): void
    {
        $this->dataSource->add($this->mapper->mapToDataSource($customer));
    }

    /**
     * @inheritDoc
     */
    public function save(Customer $customer): void
    {
        $this->dataSource->update((string)CustomerGetter::getId($customer), $this->mapper->mapToDataSource($customer));
    }

    public function generateNextId(): CustomerId
    {
        return $this->idGenerator->generate();
    }

    /**
     * @inheritDoc
     */
    public function remove(Customer $customer): void
    {
        $this->dataSource->remove((string)CustomerGetter::getId($customer));
    }
}

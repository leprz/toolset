<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer;

use Persistence\Application\Entity\Customer;
use Persistence\Application\Exception\DataSourceErrorException;
use Persistence\Application\Exception\ResultNotFoundException;
use Persistence\Application\Repository\CustomerRepositoryInterface;
use Persistence\Application\ValueObject\CustomerId;
use Persistence\Infrastructure\DataSource\CustomerDataSource;
use Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper;
use Persistence\Infrastructure\Persistence\Exception\MappingException;

class CustomerInMemoryRepository implements CustomerRepositoryInterface
{
    /**
     * @var \Persistence\Infrastructure\DataSource\CustomerDataSource
     */
    private CustomerDataSource $dataSource;
    /**
     * @var \Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper
     */
    private CustomerMapper $mapper;

    /**
     * @param \Persistence\Infrastructure\DataSource\CustomerDataSource $dataSource
     * @param \Persistence\Infrastructure\Persistence\Customer\Util\CustomerMapper $mapper
     */
    public function __construct(CustomerDataSource $dataSource, CustomerMapper $mapper)
    {
        $this->dataSource = $dataSource;
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function getForId(CustomerId $customerId): Customer
    {
        $customerData = $this->dataSource->getById((string)$customerId);

        if (!empty($customerData)) {
            try {
                return $this->mapper->mapFromDataSource($customerData);
            } catch (MappingException $e) {
                throw new DataSourceErrorException($e->getMessage());
            }
        }

        throw ResultNotFoundException::forId((string)$customerId);
    }
}

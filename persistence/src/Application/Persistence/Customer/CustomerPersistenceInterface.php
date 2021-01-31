<?php

declare(strict_types=1);

namespace Persistence\Application\Persistence\Customer;

use Persistence\Domain\Customer;
use Persistence\Domain\ValueObject\CustomerId;

interface CustomerPersistenceInterface
{
    /**
     * @param \Persistence\Domain\Customer $customer
     */
    public function add(Customer $customer): void;

    /**
     * @return \Persistence\Domain\ValueObject\CustomerId
     */
    public function generateNextId(): CustomerId;

    /**
     * @param \Persistence\Domain\Customer $customer
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function save(Customer $customer): void;

    /**
     * @param \Persistence\Domain\Customer $customer
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function remove(Customer $customer): void;
}

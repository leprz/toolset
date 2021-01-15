<?php

declare(strict_types=1);

namespace Persistence\Application\Persistence;

use Persistence\Application\Entity\Customer;
use Persistence\Application\ValueObject\CustomerId;

interface CustomerPersistenceInterface
{
    /**
     * @param \Persistence\Application\Entity\Customer $customer
     */
    public function add(Customer $customer): void;

    /**
     * @return \Persistence\Application\ValueObject\CustomerId
     */
    public function generateNextId(): CustomerId;

    /**
     * @param \Persistence\Application\Entity\Customer $customer
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function save(Customer $customer): void;

    /**
     * @param \Persistence\Application\Entity\Customer $customer
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function remove(Customer $customer): void;
}

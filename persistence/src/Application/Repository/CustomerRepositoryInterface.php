<?php

declare(strict_types=1);

namespace Persistence\Application\Repository;

use Persistence\Application\Entity\Customer;
use Persistence\Application\ValueObject\CustomerId;

interface CustomerRepositoryInterface
{
    /**
     * @param \Persistence\Application\ValueObject\CustomerId $customerId
     * @return \Persistence\Application\Entity\Customer
     * @throws \Persistence\Application\Exception\DataSourceErrorException
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function getForId(CustomerId $customerId): Customer;
}

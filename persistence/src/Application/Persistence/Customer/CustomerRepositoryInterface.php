<?php

declare(strict_types=1);

namespace Persistence\Application\Persistence\Customer;

use Persistence\Domain\Customer;
use Persistence\Domain\ValueObject\CustomerId;

interface CustomerRepositoryInterface
{
    /**
     * @param \Persistence\Domain\ValueObject\CustomerId $customerId
     * @return \Persistence\Domain\Customer
     * @throws \Persistence\Application\Exception\DataSourceErrorException
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function getForId(CustomerId $customerId): Customer;
}

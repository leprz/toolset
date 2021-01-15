<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer;

use Persistence\Application\ValueObject\CustomerId;

class CustomerIdGenerator
{
    /**
     * @return \Persistence\Application\ValueObject\CustomerId
     */
    public function generate(): CustomerId
    {
        return CustomerId::fromString(uniqid('cst', true));
    }
}

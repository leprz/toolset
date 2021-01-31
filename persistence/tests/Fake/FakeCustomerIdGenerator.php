<?php

declare(strict_types=1);

namespace Persistence\Tests\Fake;

use Persistence\Domain\ValueObject\CustomerId;
use Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator;

class FakeCustomerIdGenerator extends CustomerIdGenerator
{
    /**
     * @var \Persistence\Domain\ValueObject\CustomerId[]
     */
    private array $generatedIds = [];

    public function generate(): CustomerId
    {
        $this->generatedIds[] = $generatedId = parent::generate();

        return $generatedId;
    }

    /**
     * @return \Persistence\Domain\ValueObject\CustomerId[]
     */
    public function getGeneratedIds(): array
    {
        return $this->generatedIds;
    }
}

<?php

declare(strict_types=1);

namespace Persistence\Tests\Fixture;

use Persistence\Application\ValueObject\CustomerId;
use Persistence\Infrastructure\Persistence\Customer\CustomerIdGenerator;

class CustomerIdGeneratorFixture extends CustomerIdGenerator
{
    /**
     * @var \Persistence\Application\ValueObject\CustomerId[]
     */
    private array $generatedIds = [];

    public function generate(): CustomerId
    {
        $this->generatedIds[] = $generatedId = parent::generate();

        return $generatedId;
    }

    /**
     * @return \Persistence\Application\ValueObject\CustomerId[]
     */
    public function getGeneratedIds(): array
    {
        return $this->generatedIds;
    }
}

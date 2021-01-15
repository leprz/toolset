<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerImport;

class CustomerImportCommand
{
    /**
     * @var \Persistence\Application\UseCase\CustomerImport\CustomerToImport[]
     */
    private array $customerData = [];

    public function addData(CustomerToImport $customerDataToImport): void
    {
        $this->customerData[] = $customerDataToImport;
    }

    /**
     * @return \Persistence\Application\UseCase\CustomerImport\CustomerToImport[]
     */
    public function getData(): array
    {
        return $this->customerData;
    }
}

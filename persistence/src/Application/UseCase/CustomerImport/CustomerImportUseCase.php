<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerImport;

use Persistence\Application\Entity\Customer;
use Persistence\Application\Persistence\CustomerPersistenceInterface;

class CustomerImportUseCase
{
    private CustomerPersistenceInterface $customerPersistence;

    public function __construct(CustomerPersistenceInterface $customerPersistence)
    {
        $this->customerPersistence = $customerPersistence;
    }

    public function handle(CustomerImportCommand $command): void
    {
        $customersToImport = $command->getData();

        foreach ($customersToImport as $customerToImportData) {
            $customer = Customer::register(
                $this->customerPersistence->generateNextId(),
                $customerToImportData->getEmail(),
                $customerToImportData->getFullName()
            );

            $this->customerPersistence->add($customer);
        }
    }
}

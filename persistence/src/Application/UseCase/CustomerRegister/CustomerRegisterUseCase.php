<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerRegister;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Domain\Customer;

class CustomerRegisterUseCase
{
    private CustomerPersistenceInterface $customerPersistence;

    public function __construct(CustomerPersistenceInterface $customerPersistence)
    {
        $this->customerPersistence = $customerPersistence;
    }

    public function handle(CustomerRegisterCommand $command): void
    {
        $customer = Customer::register(
            $command->getCustomerId(),
            $command->getEmail(),
            $command->getFullName()
        );

        $this->customerPersistence->add($customer);
    }
}

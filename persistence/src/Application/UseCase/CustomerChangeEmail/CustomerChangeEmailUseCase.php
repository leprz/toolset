<?php

declare(strict_types=1);

namespace Persistence\Application\UseCase\CustomerChangeEmail;

use Persistence\Application\Persistence\Customer\CustomerPersistenceInterface;
use Persistence\Application\Persistence\Customer\CustomerRepositoryInterface;

class CustomerChangeEmailUseCase
{
    private CustomerRepositoryInterface $customerRepository;

    private CustomerPersistenceInterface $customerPersistence;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerPersistenceInterface $customerPersistence
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerPersistence = $customerPersistence;
    }

    /**
     * @param \Persistence\Application\UseCase\CustomerChangeEmail\CustomerChangeEmailCommand $command
     * @throws \Persistence\Application\Exception\DataSourceErrorException
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     * @throws \Persistence\Application\UseCase\CustomerChangeEmail\Exception\InvalidChangeRequestCode
     */
    public function handle(CustomerChangeEmailCommand $command): void
    {
        $customer = $this->customerRepository->getForId($command->getCustomerId());

        $customer->changeEmail($command->getNewEmail(), $command->getChangeRequestCode());

        $this->customerPersistence->save($customer);
    }
}

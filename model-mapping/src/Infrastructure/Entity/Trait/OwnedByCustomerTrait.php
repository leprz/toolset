<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity\Trait;

use App\Infrastructure\Entity\CustomerEntity;
use Doctrine\ORM\Mapping as ORM;

trait OwnedByCustomerTrait
{
    /**
     * @var \App\Infrastructure\Entity\CustomerEntity
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Entity\CustomerEntity")
     */
    protected CustomerEntity $customer;
}

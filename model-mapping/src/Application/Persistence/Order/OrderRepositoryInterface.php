<?php

declare(strict_types=1);

namespace App\Application\Persistence\Order;

use App\Domain\Order;
use App\Domain\ValueObject\OrderId;

interface OrderRepositoryInterface
{
    public function getForId(OrderId $id): Order;
}

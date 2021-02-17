<?php

declare(strict_types=1);

namespace App\Application\Persistence\Order;

use App\Domain\Order;
use App\Domain\ValueObject\OrderId;

interface OrderPersistenceInterface
{
    public function add(Order $order): void;

    public function removeById(OrderId $id): void;

    public function flush(): void;
}

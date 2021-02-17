<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\OrderId;
use Exception;

class EmptyOrderException extends Exception
{
    public static function forCustomerOrder(OrderId $cartId, CustomerId $customerId)
    {
        return new self(
            sprintf('Cart [%s] for customer [%s] is empty', (string)$cartId, (string)$customerId)
        );
    }
}

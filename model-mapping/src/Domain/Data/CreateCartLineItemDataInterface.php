<?php

declare(strict_types=1);

namespace App\Domain\Data;

use App\Domain\ValueObject\CartId;
use App\Domain\ValueObject\LineItemId;
use App\Domain\ValueObject\Money;

interface CreateCartLineItemDataInterface
{
    public function getId(): LineItemId;

    public function getCartId(): CartId;

    public function getName(): string;

    public function getPrice(): Money;
}

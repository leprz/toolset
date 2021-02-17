<?php

declare(strict_types=1);

namespace App\Application\Persistence\Product;

use App\Domain\Product;
use App\Domain\ValueObject\Sku;

interface ProductRepositoryInterface
{
    public function findBySku(Sku $getProductSku): Product;
}

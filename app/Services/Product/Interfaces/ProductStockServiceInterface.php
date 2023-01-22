<?php

namespace App\Services\Product\Interfaces;

use App\Models\ProductStock;

interface ProductStockServiceInterface
{
    /**
     * Store product quantity
     * @param int $stockQuantity
     * @return ProductStock stored
     */
    public function store(int $stockQuantity, string $productId): ProductStock;

    /**
     * Store product quantity
     * @param int $stockQuantity
     * @return ProductStock
     */
    public function update(int $stockQuantity, string $productId): ProductStock;
}

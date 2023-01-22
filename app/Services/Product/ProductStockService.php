<?php

namespace App\Services\Product;

use App\Models\ProductStock;
use App\Services\Product\Interfaces\ProductStockServiceInterface;
use Exception;

class ProductStockService implements ProductStockServiceInterface
{
    public function store(int $productQuantity, string $productId): ProductStock
    {
        return ProductStock::create([
            'quantity' => $productQuantity,
            'product_id' => $productId
        ]);
    }

    public function update(int $productQuantity, string $productId): ProductStock
    {
        $productStock = ProductStock::where([
            'product_id' => $productId
        ])->first();

        if (!$productStock->update(['quantity' => $productQuantity]))
            throw new Exception(__('requestError.product.productStock.update'));
        return $productStock;
    }
}

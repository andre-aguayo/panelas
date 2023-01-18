<?php

namespace App\Services\Product\Interfaces;

use App\Models\ProductStock;

interface ProductInfotmationInterface
{
    /**
     * @param array of products or ProductStock $productStock
     */
    public function create(ProductStock|array $productStock): ProductStock;


}

<?php

namespace App\Services\Product\Interfaces;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ProductServiceInterface
{
    /**
     * @return Collection of all Product with ProductInformation
     */
    public function list(): Collection;

    /**
     * @param string $productCategoryId
     * @return Collection of products by product_category_id
     */
    public function profuctsOfCategory(string $productCategoryId): Collection;

    /**
     * @throws Exception if it doesn't exist
     * 
     * @param string $id product category
     * @return Product with ProductInformation and stock
     */
    public function show(string $id): Product;

    /**
     * Store product with informations
     * 
     * @throws Exception if it doesn't store
     * @param ProductCreateRequest $productRequest
     * @return Product
     */
    public function store(ProductCreateRequest $productRequest): Product;


    /**
     * @throws Exception if it doesn't updat or don't exists
     * 
     * @param ProductUpdateRequest $productRequest
     * @return Product
     */
    public function update(ProductUpdateRequest $productRequest): Product;


    /**
     * @throws Exception if it doesn't destroy or don't exists
     * 
     * @param string $productId is uuid
     * @return bool destroyed?
     */
    public function destroy(string $productId): bool;
}

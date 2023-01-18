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
     * @return Collection of all services
     */
    public function list(): Collection;

    /**
     * @param string $productCategoryId
     * @return Collection of products category
     */
    public function profuctsOfCategory(string $productCategoryId): Collection;

    /**
     * @param ProcuctCategoryCreateRequest $productCategoryCreateRequest
     * @return ProductCategory
     */
    public function store(ProductCreateRequest $productCategoryCreateRequest): Product;

    /**
     * @throws Exception if it doesn't exist
     * 
     * @param string $id product category
     * @return ProductCategory
     */
    public function show(string $id): Product;

    /**
     * @throws Exception if it doesn't exist
     * 
     * @param ProductCategory $productCategory
     * @return bool updated?
     */
    public function update(ProductUpdateRequest $productCategory): bool;


    /**
     * @throws Exception if it doesn't exist
     * 
     * @param ProductCategory $productCategory
     * @return bool updated?
     */
    public function destroy(Request $productCategory): bool;
}

<?php

namespace App\Services\Product\Interfaces;

use App\Http\Requests\ProductCategoryCreateRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ProductCategoryServiceInterface
{
    /**
     * @return Collection of all services
     */
    public function list(): Collection;

    /**
     * @param ProcuctCategoryCreateRequest $productCategoryCreateRequest
     * @return ProductCategory
     */
    public function store(ProductCategoryCreateRequest $productCategoryCreateRequest): ProductCategory;

    /**
     * @throws Exception if it doesn't exist
     * 
     * @param string $id product category
     * @return ProductCategory
     */
    public function show(string $id): ProductCategory;

    /**
     * @throws Exception if it doesn't exist
     * 
     * @param ProductCategory $productCategory
     * @return bool updated?
     */
    public function update(ProductCategoryUpdateRequest $productCategory): bool;


    /**
     * @throws Exception if it doesn't exist
     * 
     * @param ProductCategory $productCategory
     * @return bool updated?
     */
    public function destroy(Request $productCategory): bool;
}

<?php

namespace App\Services\Product;

use Exception;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\ProductCategoryCreateRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Services\Product\Interfaces\ProductCategoryServiceInterface;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    public function list(): Collection
    {
        return ProductCategory::select(['id', 'name'])->get();
    }

    public function store(ProductCategoryCreateRequest $productCategoryCreateRequest): ProductCategory
    {
        return ProductCategory::create(['name' => $productCategoryCreateRequest->name]);
    }

    public function show(string $id): ProductCategory
    {
        $productCategory = ProductCategory::where(['id' => $id])->first();

        if (!$productCategory)
            throw new Exception(__('requestErrors.productCategory.notFound'), 404);

        return $productCategory;
    }

    public function update(ProductCategoryUpdateRequest $productCategoryUpdateRequest): bool
    {
        $productCategory = $this->show($productCategoryUpdateRequest->id);

        $productCategory->name = $productCategoryUpdateRequest->name;

        return $productCategory->save();
    }

    public function destroy(string $productCategoryId): bool
    {
        $productCategory = $this->show($productCategoryId);

        return $productCategory->delete();
    }
}

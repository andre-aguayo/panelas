<?php

namespace App\Services\Product;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Product\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function list(): Collection
    {
        return Product::select(
            [
                'id',
                'product_category_id',
                'name',
                'image',
                'value'
            ]
        )->get();
    }

    public function profuctsOfCategory(string $productCategoryId): Collection
    {
        return Product::select(
            [
                'id',
                'product_category_id',
                'name',
                'image',
                'value'
            ]
        )->where(['product_category_id' => $productCategoryId])->get();
    }

    public function store(ProductCreateRequest $productCreateRequest): Product
    {
        return Product::create(['name' => $productCreateRequest->name]);
    }

    public function show(string $id): Product
    {
        $product = Product::select(
            [
                'id',
                'product_category_id',
                'name',
                'image',
                'value'
            ]
        )->where(['id' => $id])->first();

        if (!$product)
            throw new Exception(__('requestErrors.product.notFound'));

        return $product;
    }

    public function update(ProductUpdateRequest $productUpdateRequest): bool
    {
        $product = $this->show($productUpdateRequest->id);

        $product->name = $productUpdateRequest->name;

        return $product->save();
    }

    public function destroy(Request $product): bool
    {
        $product = $this->show($product->id);

        return $product->delete();
    }
}

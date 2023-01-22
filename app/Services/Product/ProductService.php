<?php

namespace App\Services\Product;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Product\ProductInformationService;
use App\Services\Product\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{

    public function __construct(
        private ProductInformationService $productInformationService,
        private ProductStockService $productStockService
    ) {
    }

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
        )->with('productInformations')->get();
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
        )
            ->with('productInformations')
            ->where(['product_category_id' => $productCategoryId])
            ->get();
    }

    public function show(string $id): Product
    {
        $product = Product::select(
            [
                'id',
                'product_category_id',
                'name',
                'image',
                'value',
            ]
        )
            ->where(['id' => $id])
            ->with('productInformations', 'stock')
            ->first();

        if (!$product)
            throw new Exception(__('requestErrors.product.notFound'));

        return $product;
    }

    public function store(ProductCreateRequest $productCreateRequest): Product
    {
        DB::beginTransaction();

        try { //tries to store a product, product information and product stock
            $product = Product::create([...$productCreateRequest->product]);

            //Store product stock
            $product->product_stock = $this->productStockService->store(
                $productCreateRequest->product_stock,
                $product->id
            );
            //Store product informations
            $product->product_informations = $this
                ->productInformationService
                ->storeInformations(
                    $productCreateRequest->product_informations,
                    $product->id
                );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(__('requestError.product.store'));
        }

        return $product;
    }

    public function update(ProductUpdateRequest $productUpdateRequest): Product
    {
        DB::beginTransaction();

        try { //try update product, product stock and product informations
            $product = Product::where([
                'id' => $productUpdateRequest->product['id']
            ])->first();
            //Update product
            $product->update(
                $productUpdateRequest->product
            );

            //update productStock
            $product->product_stock = $this->productStockService->update(
                $productUpdateRequest->product_stock,
                $productUpdateRequest->product['id']
            );
            //update productInformations and remove or add informations
            $product->product_informations = $this
                ->productInformationService
                ->processInformationsRequest(
                    $productUpdateRequest->product_informations,
                    $product
                );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(__('requestError.product.update'));
        }

        return $product;
    }

    public function destroy(string $productId): bool
    {
        $product = Product::where(['id' => $productId])->first();
        return $product->delete();
    }
}

<?php

namespace Tests\Unit;

use App\Models\ProductCategory;
use Tests\TestCase;
use App\Http\Requests\ProductCategoryCreateRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\Product;
use App\Models\ProductInformation;
use App\Models\ProductStock;
use App\Services\Product\ProductCategoryService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $productCategoryService;

    private $productCategoryFactory;

    private $productFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryService = new ProductCategoryService();

        $this->productCategoryFactory = (ProductCategory::factory(1)->create())[0];

        $this->productFactory = (Product::factory(1)->create(['product_category_id' => $this->productCategoryFactory->id])->each(
            function ($product) {
                ProductInformation::factory(1)->create(['product_id' => $product->id]);
                ProductStock::factory(1)->create(['product_id' => $product->id]);
            }
        ))[0];
    }

    /**
     * @test return list of categories
     */
    public function list_returns_product_categories_collection()
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Collection::class,
            $this->productCategoryService->list()
        );
    }

    /**
     * @test create product
     */
    public function store_creates_product_category_and_returns_product_category_instance()
    {
        $productCategoryCreateRequest = new ProductCategoryCreateRequest(['name' => 'Category Name']);

        $this->assertInstanceOf(
            ProductCategory::class,
            $this->productCategoryService->store($productCategoryCreateRequest)
        );
    }

    /**
     * @test show product category
     */
    public function show_returns_product_category_instance()
    {
        $this->assertInstanceOf(
            ProductCategory::class,
            $this->productCategoryService->show($this->productCategoryFactory->id)
        );
    }

    /**
     * @test show product category not found
     */
    public function show_returns_product_category_exception()
    {

        $this->expectException(Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage(__('requestErrors.productCategory.notFound'));

        $this->productCategoryService->show('');
    }

    /**
     * @test update category
     */
    public function update_updates_and_returns_true_on_success()
    {
        $productCategoryUpdateRequest = new ProductCategoryUpdateRequest([
            'id' => $this->productCategoryFactory->id,
            'name' => 'Updated Category Name'
        ]);

        $this->assertTrue($this->productCategoryService->update($productCategoryUpdateRequest));
    }

    /**
     * @test if destroy product category, product, product informations and product stock
     */
    public function destroy_deletes_product_category_and_returns_true_on_success()
    {
        $this->assertTrue($this->productCategoryService->destroy($this->productCategoryFactory->id));

        $this->assertSoftDeleted('product_categories', ['id' => $this->productCategoryFactory->id]);
        $this->assertSoftDeleted('products', ['product_category_id' => $this->productCategoryFactory->id]);
        $this->assertSoftDeleted('product_stocks', ['product_id' => $this->productFactory->id]);
        $this->assertSoftDeleted('product_informations', ['product_id' => $this->productFactory->id]);
    }
}

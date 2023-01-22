<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductCategory;
use App\Models\ProductInformation;
use App\Services\Product\ProductService;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\Product\ProductInformationService;
use App\Services\Product\ProductStockService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private $productService;

    private $productCategoryFactory;

    private $productFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productService = new ProductService(new ProductInformationService, new ProductStockService);

        $this->productCategoryFactory = (ProductCategory::factory(1)->create())[0];

        $this->productFactory = (Product::factory(1)->create(['product_category_id' => $this->productCategoryFactory->id])->each(
            function ($product) {
                ProductInformation::factory(2)->create(['product_id' => $product->id]);
                ProductStock::factory(1)->create(['product_id' => $product->id]);
            }
        ))[0];
    }

    /**
     * @test return list of categories
     */
    public function list_returns_product_collection_with_informations_and_stock()
    {
        $productCreated = $this->productService->list();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Collection::class,
            $productCreated
        );
        //check if product stock created
        $this->assertInstanceOf(
            ProductStock::class,
            $productCreated[0]->stock
        );
        //check product information is collection
        $this->assertInstanceOf(
            Collection::class,
            $productCreated[0]->productInformations
        );
        //check if store 2 productInformations
        $this->assertTrue(count($productCreated[0]->productInformations->toArray()) === 2);
    }

    /**
     * @test return Collection of Products
     */
    public function list_returns_product_collection_of_product_category()
    {
        $product = $this->productService->profuctsOfCategory($this->productCategoryFactory->id);
        //check if return Collection of Products
        $this->assertInstanceOf(
            Collection::class,
            $product
        );
        //check if product exists
        $this->assertInstanceOf(
            Product::class,
            $product[0]
        );
        //check if product stock created
        $this->assertInstanceOf(
            ProductStock::class,
            $product[0]->stock
        );
        //check product information is collection
        $this->assertInstanceOf(
            Collection::class,
            $product[0]->productInformations
        );
        //check if store 2 productInformations
        $this->assertTrue(count($product[0]->productInformations->toArray()) === 2);
    }

    /**
     * @test return Product with productInformations and ProductStock
     */
    public function show_returns_product_with_informations_and_stock()
    {
        $product = $this->productService->show($this->productFactory->id);

        //check if product instance
        $this->assertInstanceOf(Product::class, $product);
        //check if product stock created
        $this->assertInstanceOf(ProductStock::class, $product->stock);
        //check product information is collection
        $this->assertInstanceOf(Collection::class, $product->productInformations);
    }

    /**
     * @test return Product with productInformations and ProductStock
     */
    public function show_returns_exception()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage(__('requestErrors.product.notFound'));

        $this->productService->show('');
    }

    /**
     * @test create product
     */
    public function store_product_and_returns_product_instance()
    {
        $productCreateRequest = new ProductCreateRequest(
            [
                'product' =>
                [
                    'name' => 'Product Name',
                    'product_category_id' => $this->productCategoryFactory->id,
                    'image' => 'Product image',
                    'value' => 150,
                    'cost' => 100,
                ],
                'product_stock' => 8,
                'product_informations' => [
                    [
                        'name' => 'Information name',
                        'description' => 'Description where',
                    ],
                    [
                        'name' => 'Information name 2',
                        'description' => 'Description 2 where',
                    ]
                ]
            ]
        );

        $productCreated = $this->productService->store($productCreateRequest);

        //check if return product instance
        $this->assertInstanceOf(
            Product::class,
            $productCreated
        );
        //check if store 2 productInformations
        $this->assertTrue(count($productCreated->productInformations->toArray()) === 2);
    }

    /**
     * @test create product
     */
    public function update_product_and_returns_product_instance()
    {
        $updateName = 'Information update name';
        $updateDescription = 'Description update where';
        $newInformationCreated = 'new information created';
        $newDescriptionCreated = 'new description created';

        $productUpdateRequest = new ProductUpdateRequest(
            [
                'product' =>
                [

                    'id' => $this->productFactory->id,
                    'product_category_id' => $this->productFactory->product_category_id,
                    'name' => 'Product Name',
                    'product_category_id' => $this->productCategoryFactory->id,
                    'image' => 'Product image',
                    'value' => 150,
                    'cost' => 100,
                ],
                'product_stock' => 10,
                'product_informations' => [
                    [
                        'id' => $this->productFactory->productInformations[0]->id,
                        'name' => $updateName,
                        'description' => $updateDescription,
                    ],
                    [
                        'name' => $newInformationCreated,
                        'description' => $newDescriptionCreated,
                    ]
                ]
            ]
        );

        $productUpdated = $this->productService->update($productUpdateRequest);

        //check if return product instance
        $this->assertInstanceOf(Product::class, $productUpdated);
        //check if ProductStock instance
        $this->assertInstanceOf(ProductStock::class, $productUpdated->stock);
        //check if ProductStock instance
        $this->assertInstanceOf(ProductInformation::class, $productUpdated->productInformations[0]);
        //check if store 2 productInformations
        $this->assertTrue(count($productUpdated->productInformations->toArray()) === 2);
        //check if Product information is updated
        $this->assertDatabaseHas(ProductInformation::class, ['name' => $updateName, 'description' => $updateDescription]);
        //check if created new information
        $this->assertDatabaseHas(ProductInformation::class, ['name' => $newInformationCreated, 'description' => $newDescriptionCreated]);
        //check if Product information is deleting
        $this->assertSoftDeleted(ProductInformation::class, ['id' => $this->productFactory->productInformations[1]->id]);
    }

    /**
     * @test destroy product, product informations and stock
     */
    public function destroy_product_and_returns_product_instance()
    {
        $this->assertTrue($this->productService->destroy($this->productFactory->id));

        $this->assertSoftDeleted(Product::class, ['id' => $this->productFactory->id]);
        $this->assertSoftDeleted(ProductStock::class, ['product_id' => $this->productFactory->id]);
        $this->assertSoftDeleted(ProductInformation::class, ['product_id' => $this->productFactory->id]);
    }
}

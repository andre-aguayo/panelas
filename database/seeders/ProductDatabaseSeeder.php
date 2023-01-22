<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\ProductInformation;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Products seed
        ProductCategory::factory(2)->create()->each(
            function ($productCategory) {
                Product::factory(2)->create(['product_category_id' => $productCategory->id])->each(
                    function ($product) {
                        ProductInformation::factory(3)->create(['product_id' => $product->id]);
                        ProductStock::factory(1)->create(['product_id' => $product->id]);
                    }
                );
            }
        );
    }
}

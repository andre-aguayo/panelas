<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\CreditCard;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\ProductInformation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin
        User::create([
            'name' => 'iurru',
            'email' => 'iurru@iurru.com',
            'password' =>  Hash::make('iurru'),
            'as_admin' => 1,
        ])->each(function ($admin) {
            CreditCard::factory(1)->create(['user_id' => $admin->id]);

            Address::factory(1)->create(['user_id' => $admin->id]);
        });

        // Create a common user
        User::create([
            'name' => 'iurru',
            'email' => 'user@iurru.com',
            'password' =>  Hash::make('user'),
            'as_admin' => 0,
        ])->each(function ($user) {
            CreditCard::factory(1)->create(['user_id' => $user->id]);

            Address::factory(1)->create(['user_id' => $user->id]);
        });

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

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
        $this->call(
            UserDatabaseSeeder::class,
            ProductDatabaseSeeder::class,
        );
    }
}

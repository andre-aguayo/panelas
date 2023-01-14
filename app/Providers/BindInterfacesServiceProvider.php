<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AddressService;
use App\Services\Interfaces\AddreressServiceInterface;
use App\Services\ProductCategoryService;
use App\Services\Interfaces\ProductCategoryServiceInterface;
use App\Services\ProductService;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\ProductStockService;
use App\Services\Interfaces\ProductStockServiceInterface;
use App\Services\User\CreditCardService;
use App\Services\User\Interfaces\CreditCardServiceInterface;
use App\Services\User\Interfaces\UserServiceInterface;
use App\Services\User\UserService;

class BindInterfacesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AddreressServiceInterface::class, AddressService::class);
        $this->app->bind(ProductCategoryServiceInterface::class, ProductCategoryService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductStockServiceInterface::class, ProductStockService::class);
        $this->app->bind(CreditCardServiceInterface::class, CreditCardService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}

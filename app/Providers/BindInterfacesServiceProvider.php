<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AddressService;
use App\Services\Interfaces\AddreressServiceInterface;
use App\Services\Product\ProductCategoryService;
use App\Services\Product\Interfaces\ProductCategoryServiceInterface;
use App\Services\Product\Interfaces\ProductInfotmationServiceInterface;
use App\Services\Product\ProductService;
use App\Services\Product\Interfaces\ProductServiceInterface;
use App\Services\Product\ProductStockService;
use App\Services\Product\Interfaces\ProductStockServiceInterface;
use App\Services\Product\ProductInformationService;
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
        $this->app->bind(ProductInfotmationServiceInterface::class, ProductInformationService::class);
        $this->app->bind(CreditCardServiceInterface::class, CreditCardService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}

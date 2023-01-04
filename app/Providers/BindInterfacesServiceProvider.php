<?php

namespace App\Providers;

use App\Services\CompanyService;
use App\Services\CompanyServiceInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
    }
}
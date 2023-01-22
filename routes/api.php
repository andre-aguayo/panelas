<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api.response'])->get('isconnected', function () {
    return response()->json(['success' => true, 'isconnectes' => true]);
});

Route::post('login', [LoginController::class, 'login'])
    ->middleware('api.response')->name('login');

/**
 * Routes for admin access
 */
Route::middleware(['auth.admin', 'auth:sanctum', 'api.response'])
    ->prefix('admin')
    ->group(function () {
        Route::get('isconnected', function () {
            return response(['isconnected' => true]);
        });

        /**
         * Product Categories routes
         */
        Route::prefix('product-category')->group(function () {
            Route::post('store', [ProductCategoryController::class, 'store'])->name('productCategory.store');
            Route::put('update', [ProductCategoryController::class, 'update'])->name('productCategory.update');
            Route::delete('destroy', [ProductCategoryController::class, 'destroy'])->name('productCategory.destroy');
        });

        /**
         * Product routes
         */
        Route::prefix('product')->group(function () {
            Route::post('store', [ProductController::class, 'store'])->name('product.store');
            Route::put('update', [ProductController::class, 'update'])->name('product.update');
            Route::delete('destroy', [ProductController::class, 'destroy'])->name('product.destroy');
        });
    });

/**
 * Routes for user access
 */
Route::middleware(['auth:sanctum', 'api.response'])
    ->prefix('user')
    ->group(function () {

        Route::get('isconnected', function () {
            return response(['isconnectes' => true]);
        });
    });

/**
 * Product categories routes without authorization
 */
Route::middleware(['api.response'])->prefix('product-category')->group(function () {
    Route::get('index', [ProductCategoryController::class, 'index'])->name('productCategory.index');
    Route::get('show/{id}', [ProductCategoryController::class, 'show'])->name('productCategory.show');
});

/**
 * Products routes without authorization
 */
Route::middleware(['api.response'])->prefix('product')->group(function () {
    Route::get('index', [ProductController::class, 'index'])->name('product.index');
    Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('profucts-of-category/{id}', [ProductController::class, 'profuctsOfCategory'])->name('product.profuctsOfCategory');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;

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

Route::post('isconnected', function () {
    return response()->json(['success' => true, 'isconnectes' => true]);
});

Route::post('login', [LoginController::class, 'login'])->middleware('api.response');

Route::middleware(['api.response', 'auth.admin', 'auth:sanctum'])->prefix('admin')->name('admin')
    ->group(function () {
        Route::get('isconnected', function () {
            return response()->json(['success' => true, 'isconnected' => true]);
        });
    });

Route::middleware(['api.response', 'auth:sanctum'])->prefix('user')->name('admin')->group(function () {
    Route::get('isconnected', function () {
        return response()->json(['success' => true, 'isconnectes' => true]);
    });
});

Route::post('/send-mail', [CompanyController::class, 'sendMail']);

Route::get('/home', [CompanyController::class, 'index']);

<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;

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

Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth.admin', 'auth:sanctum'])
    ->prefix('admin')
    ->name('admin')
    ->group(function () {

        Route::get('isconnected', function () {
            return response()->json(['success' => true, 'isconnected' => true]);
        });
    });

Route::post('/send-mail', [CompanyController::class, 'sendMail']);

Route::get('/home', [CompanyController::class, 'index']);

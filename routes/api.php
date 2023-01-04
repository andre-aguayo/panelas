<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\CompanyController;

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

Route::post('/send-mail', [CompanyController::class, 'sendMail']);

Route::get('/home', [CompanyController::class, 'index']);

Route::get('/companies', [CompanyController::class, 'index']);

Route::post('/company/create', [CompanyController::class, 'store']);

Route::get('/UF', [CompanyController::class, 'listUf']);

Route::get('/cities', [CompanyController::class, 'listCities']);

Route::get('/state-cities', [CompanyController::class, 'listStateCities']);

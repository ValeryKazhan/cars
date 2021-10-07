<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::post('/signup', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::apiResource('brands', \App\Http\Controllers\BrandController::class);
    Route::apiResource('cars', \App\Http\Controllers\CarController::class);
});

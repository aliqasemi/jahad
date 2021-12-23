<?php

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

Route::group(['prefix' => 'jahad'], function () {
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        //auth routes
        Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::get('/users', [\App\Http\Controllers\Api\AuthController::class, 'user']);
        Route::post('/authorize/{user}', [\App\Http\Controllers\Api\AuthController::class, 'userAuthorize']);
        //category routes
        Route::resource('categories', \App\Http\Controllers\Api\CategoryController::class);

        //service routes
        Route::resource('services', \App\Http\Controllers\Api\ServiceController::class);

        //requirement routes
        Route::resource('requirements', \App\Http\Controllers\Api\RequirementController::class);

        //city routes
        Route::get('/provinces', [\App\Http\Controllers\Api\CityController::class, 'indexProvinces']);
        Route::get('/counties/{province}', [\App\Http\Controllers\Api\CityController::class, 'indexCounties']);
        Route::get('/cities/{county}', [\App\Http\Controllers\Api\CityController::class, 'indexCities']);
        Route::get('/cities/show/{city}', [\App\Http\Controllers\Api\CityController::class, 'showCity']);
    });
});



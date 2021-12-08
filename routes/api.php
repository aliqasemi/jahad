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
        Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::get('/users', [\App\Http\Controllers\Api\AuthController::class, 'user']);
        Route::post('/authorize/{user}', [\App\Http\Controllers\Api\AuthController::class, 'userAuthorize']);
    });
});



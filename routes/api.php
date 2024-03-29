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
    Route::post('/confirm-register/{user}', [\App\Http\Controllers\Api\AuthController::class, 'confirmRegister']);
    Route::post('/verify-register/{user}', [\App\Http\Controllers\Api\AuthController::class, 'verifyRegister']);
    Route::post('/forgot-password', [\App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
    Route::post('/verify-forgot-password', [\App\Http\Controllers\Api\AuthController::class, 'verifyForgotPassword']);
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::middleware(['auth:api', 'active'])->group(function () {

        //main information for chart
        Route::get('/chart/info', [\App\Http\Controllers\Api\MainController::class, 'indexChartInformation']);

        //reset password route
        Route::post('/change-password', [\App\Http\Controllers\Api\AuthController::class, 'changePassword']);

        //auth routes
        Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::get('/auth-user', [\App\Http\Controllers\Api\AuthController::class, 'user']);

        //user route
        Route::get('/users', [\App\Http\Controllers\Api\AuthController::class, 'index']);
        Route::post('/active/{user}', [\App\Http\Controllers\Api\AuthController::class, 'active']);

        //authorize route
        Route::post('/assign-role/{user}', [\App\Http\Controllers\Api\AuthController::class, 'assignRole']);
        Route::get('/role/{user}', [\App\Http\Controllers\Api\AuthController::class, 'userRole']);
        Route::get('/user/{user}', [\App\Http\Controllers\Api\AuthController::class, 'show']);
        Route::put('/user/{user}', [\App\Http\Controllers\Api\AuthController::class, 'update']);

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

        //attach requirement service
        Route::get('attach-requirement-service', \App\Http\Controllers\Api\AttachRequirementService::class);
        Route::get('attach-requirement-service/{requirement}', [\App\Http\Controllers\Api\AttachRequirementService::class, 'indexAttach']);

        //attach service requirement
        Route::get('attach-service-requirement', \App\Http\Controllers\Api\AttachServiceRequirement::class);
        Route::get('attach-service-requirement/{service}', [\App\Http\Controllers\Api\AttachServiceRequirement::class, 'indexAttach']);

        //project routes
        Route::resource('projects', \App\Http\Controllers\Api\ProjectController::class);
        Route::get('projects-user', [\App\Http\Controllers\Api\ProjectController::class, 'indexUser']);
        Route::get('projects-user/{project}', [\App\Http\Controllers\Api\ProjectController::class, 'showUser']);
        Route::post('projects/{project}/change-step', [\App\Http\Controllers\Api\ProjectController::class, 'changeStep']);
        Route::get('projects-filter', [\App\Http\Controllers\Api\ProjectController::class, 'indexFilter']);

        //step routes
        Route::get('project/{project}/steps', [\App\Http\Controllers\Api\StepController::class, 'index']);
        Route::get('/steps/{step}', [\App\Http\Controllers\Api\StepController::class, 'show']);
        Route::post('project/{project}/steps', [\App\Http\Controllers\Api\StepController::class, 'store']);
        Route::put('/steps/{step}', [\App\Http\Controllers\Api\StepController::class, 'update']);
        Route::delete('/steps/{step}', [\App\Http\Controllers\Api\StepController::class, 'destroy']);
        Route::post('steps/move-up/{step}', [\App\Http\Controllers\Api\StepController::class, 'moveUp']);
        Route::post('steps/move-down/{step}', [\App\Http\Controllers\Api\StepController::class, 'moveDown']);

        //template route
        Route::resource('templates', \App\Http\Controllers\Api\TemplateController::class);
        Route::get('templates-filter', [\App\Http\Controllers\Api\TemplateController::class, 'indexFilter']);

        //product route
        Route::resource('products', \App\Http\Controllers\Api\ProductController::class);
        Route::get('products-filter', [\App\Http\Controllers\Api\ProductController::class, 'indexFilter']);

        //branch route
        Route::resource('branches', \App\Http\Controllers\Api\BranchController::class);
        Route::get('branches-filter', [\App\Http\Controllers\Api\BranchController::class, 'indexFilter']);

        //require product route
        Route::get('project/{project}/require-products', [\App\Http\Controllers\Api\RequireProductController::class, 'index']);
        Route::delete('require-product-products/{requireProductProduct}', [\App\Http\Controllers\Api\RequireProductController::class, 'destroy']);
        Route::post('attach-product/{requireProduct}', [\App\Http\Controllers\Api\RequireProductController::class, 'attach']);
    });
});

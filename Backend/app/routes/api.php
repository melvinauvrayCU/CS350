<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UserController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user',[UserController::class, 'show']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/user/change-password',[UserController::class, 'change_password']);
    Route::post('/user/edit',[UserController::class, 'edit']);
});

// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('recipes', RecipeController::class);
    Route::apiResource('ingredients', IngredientController::class);
    Route::apiResource('ingredientcategories', IngredientCategoryController::class);
    Route::apiResource('utensils', UtensilController::class);
    Route::apiResource('utensilcategories', UtensilCategoryController::class);
    Route::apiResource('recipesteps', RecipeStepController::class);
    Route::post('recipesteps/bulk', ['uses' => 'RecipeStepController@bulkStore']);
});

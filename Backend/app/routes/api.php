<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SecurityQuestionsController;


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
Route::get('/user/auth',[AuthController::class, 'check']);
Route::get('/security-questions',[SecurityQuestionsController::class , 'index']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/{id}/change-password',[UserController::class, 'change_password']);
    Route::put('/user/{id}/edit',[UserController::class, 'edit']);
    Route::get('/user',[UserController::class, 'show']);
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
    Route::apiResource('recipecategories', RecipeCategoryController::class);
});

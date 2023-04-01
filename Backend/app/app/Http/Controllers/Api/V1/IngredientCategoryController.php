<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IngredientCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIngredientCategoryRequest;
use App\Http\Resources\V1\IngredientCategoryCollection;
use App\Http\Resources\V1\IngredientCategoryResource;

class IngredientCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->input('userId');

        if (!$userId) {
            return response()->json(['error' => 'User ID is required.'], 400);
        }

        $ingredientCategories = IngredientCategory::where('user_id', $userId)->get();

        return new IngredientCategoryCollection($ingredientCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIngredientCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIngredientCategoryRequest $request)
    {
        return new IngredientCategoryResource(IngredientCategory::create($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ingredientCategory = IngredientCategory::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Ingredient category not found'], 404);
        }

        try {
            $ingredientCategory->delete();
            return response()->json(['success' => 'Ingredient category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete ingredient category'], 500);
        }
    }
}

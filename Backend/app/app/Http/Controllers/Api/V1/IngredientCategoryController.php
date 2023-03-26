<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IngredientCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredientCategoryRequest;
use App\Http\Requests\UpdateIngredientCategoryRequest;
use App\Http\Resources\V1\IngredientCategoryCollection;
use App\Http\Resources\V1\IngredientCategoryResource;

class IngredientCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new IngredientCategoryCollection(IngredientCategory::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function show(IngredientCategory $ingredientCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(IngredientCategory $ingredientCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIngredientCategoryRequest  $request
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIngredientCategoryRequest $request, IngredientCategory $ingredientCategory)
    {
        //
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

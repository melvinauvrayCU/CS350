<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Resources\V1\IngredientCollection;
use App\Http\Resources\V1\IngredientResource;
use App\Models\IngredientCategory;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new IngredientCollection(Ingredient::all());
    }

    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::firstOrCreate(['name' => $request->name]);

        if ($request->has('ingredientCategoryId')) {
            $categoryIngredient = IngredientCategory::findOrFail($request->categoryIngredientId);
            $ingredient->ingredientCategories()->syncWithoutDetaching($categoryIngredient->id);
        }

        return new IngredientResource($ingredient);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ingredient $ingredient)
    {
        $ingredientCategoryId = $request->input('ingredientCategory');
        $category = IngredientCategory::find($ingredientCategoryId);

        if (!$category) {
            return response()->json(['error' => 'Category not found']);
        }

        $attachedCategoryIds = $ingredient->ingredientCategories()->pluck('ingredient_categories.id')->all();

        if (!in_array($ingredientCategoryId, $attachedCategoryIds)) {
            return response()->json(['error' => 'Category is not attached to the ingredient']);
        }

        $category->ingredients()->detach($ingredient->id);

        return response()->json(['success' => 'Ingredient removed from category !']);
    }
}

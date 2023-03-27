<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRecipeRequest;
use App\Http\Requests\V1\UpdateRecipeRequest;
use App\Http\Resources\V1\RecipeResource;
use App\Http\Resources\V1\RecipeCollection;
use Illuminate\Http\Request;
use App\Filters\V1\RecipeFilter;

/**
 * Class that handles the different requests method for the /recipes/ endpoint
 */
class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null)
    {
        $filter = new RecipeFilter();
        $filterItems = $filter->transform($request);

        $includeUser = $request->query('includeUser');

        $recipes = Recipe::where($filterItems);

        if ($includeUser) {
            $recipes = $recipes->with('user');
        }
        return new RecipeCollection($recipes->paginate()->appends($request->query()));
        // If an id parameter is present, return the recipe with the specified id
        // if ($id) {
        //     $recipe = Recipe::find($id);

        //     if (!$recipe) {
        //         return response()->json(['message' => 'Recipe not found'], 404);
        //     }

        //     return new RecipeResource($recipe);
        // }

        // // Otherwise, apply the recipe filter and return a collection of recipes
        // $filter = new RecipeFilter();
        // $filterItems = $filter->transform($request);

        // $includeUser = $request->query('includeUser');

        // $recipes = Recipe::where($filterItems);

        // if ($includeUser) {
        //     $recipes = $recipes->with('user');
        // }

        // return new RecipeCollection($recipes->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecipeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeRequest $request)
    {
        return new RecipeResource(Recipe::create($request->all()));
        // $validatedData = $request ->validate([
        //     'title' => 'required|string',
        //     'description' => 'required|string',
        //     'number_people' => 'required|integer|min:1',
        //     'rating' => 'required|integer|min:1|max:5',
        //     'image_url'=> 'nullable|string',
        // ]);

        // $recipe = Recipe::create($validatedData);
        // return new RecipeResource($recipe);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecipeRequest  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Recipe;
use App\Models\RecipeStep;
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecipeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeRequest $request)
    {
        $recipeData = $request->only([
            'title',
            'description',
            'number_people',
            'image_url',
            'rating',
            'user_id'
        ]);

        $recipe = Recipe::create($recipeData);

        $stepsData = $request->input('steps', []);

        $steps = collect($stepsData)->map(function ($stepData) {
            return new RecipeStep([
                'description' => $stepData['description'],
                'prep_time' => $stepData['prep_time'],
                'cook_time' => $stepData['cook_time'],
                'ingredients' => $stepData['ingredients']
            ]);
        });

        $recipe->recipeSteps()->saveMany($steps);

        return new RecipeResource($recipe);
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

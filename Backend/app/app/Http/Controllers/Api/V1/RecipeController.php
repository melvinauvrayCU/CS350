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
use App\Models\Ingredient;
use App\Models\Utensil;

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

        $stepsData = $request->input('recipe_steps', []);

        collect($stepsData)->map(function ($stepData) use (&$recipe) {
            $newstep = new RecipeStep([
                'description' => $stepData['description'],
                'prep_time' => $stepData['prep_time'],
                'cook_time' => $stepData['cook_time']
            ]);

            $recipe->recipeSteps()->save($newstep);

            collect($stepData['ingredients'])->map(function ($ingredientData) use ($newstep) {
                $ingredient = Ingredient::firstOrCreate(['name' => $ingredientData["name"]]);
                $quantity = $ingredientData["quantity"];
                $measurement = $ingredientData["measurement"];
                $ingredient->recipeSteps()->syncWithoutDetaching([$newstep->id => ['quantity' => $quantity, 'measurement' => $measurement]]);
            });

            collect($stepData['utensils'])->map(function ($utensilData) use ($newstep) {
                $utensil = Utensil::firstOrCreate(['name' => $utensilData["name"]]);
                $utensil->recipeSteps()->syncWithoutDetaching($newstep->id);
            });
            return $newstep;
        });

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
        $recipeData = $request->only([
            'title',
            'description',
            'number_people',
            'image_url',
            'rating',
        ]);

        $recipe->update($recipeData);

        $stepsData = $request->input('recipe_steps', []);

        collect($stepsData)->map(function ($stepData) use ($recipe) {
            $newstep = null;
            if (isset($stepData['id'])) {
                $newstep = RecipeStep::find($stepData['id']);
                if (!$newstep) {
                    // Recipe step with given ID does not exist, so create a new one
                    $newstep = new RecipeStep([
                        'description' => $stepData['description'],
                        'prep_time' => $stepData['prep_time'],
                        'cook_time' => $stepData['cook_time']
                    ]);
                    $recipe->recipeSteps()->save($newstep);
                } else {
                    // Recipe step with given ID already exists, so update it
                    $newstep->update([
                        'description' => $stepData['description'],
                        'prep_time' => $stepData['prep_time'],
                        'cook_time' => $stepData['cook_time']
                    ]);
                    return $newstep;
                }
            } else {
                $newstep = new RecipeStep([
                    'description' => $stepData['description'],
                    'prep_time' => $stepData['prep_time'],
                    'cook_time' => $stepData['cook_time']
                ]);
                $recipe->recipeSteps()->save($newstep);
            }

            collect($stepData['ingredients'])->map(function ($ingredientData) use ($newstep) {
                $ingredient = Ingredient::firstOrCreate(['name' => $ingredientData["name"]]);
                $quantity = $ingredientData["quantity"];
                $measurement = $ingredientData["measurement"];
                $ingredient->recipeSteps()->syncWithoutDetaching([$newstep->id => ['quantity' => $quantity, 'measurement' => $measurement]]);
            });

            collect($stepData['utensils'])->map(function ($utensilData) use ($newstep) {
                $utensil = Utensil::firstOrCreate(['name' => $utensilData["name"]]);
                $utensil->recipeSteps()->syncWithoutDetaching($newstep->id);
            });
            return $newstep;
        });
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

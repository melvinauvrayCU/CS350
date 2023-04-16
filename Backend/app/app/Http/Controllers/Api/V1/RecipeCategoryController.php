<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RecipeResource;
use App\Models\Recipe;

class RecipeCategoryController extends Controller
{
    public function index()
    {
        $allRecipes = RecipeResource::collection(Recipe::all());
        $latestRecipes = RecipeResource::collection(Recipe::orderByDesc('id')->take(10)->get());
        $mostRatedRecipes = RecipeResource::collection(Recipe::orderBy('rating', 'desc')->take(10)->get());
        $mostStepsRecipes = RecipeResource::collection(Recipe::withCount('recipeSteps')->orderBy('recipe_steps_count', 'desc')->take(10)->get());
        $recommendedRecipes =  RecipeResource::collection(Recipe::inRandomOrder()->take(10)->get());
        $madeforoneRecipes = RecipeResource::collection(Recipe::where('number_people', 1)->get());

        $data = [
            [
                'name' => 'Latest recipes',
                'recipes' => $latestRecipes,
            ],
            [
                'name' => 'Recommended',
                'recipes' => $recommendedRecipes,
            ],
            [
                'name' => 'Most rated',
                'recipes' => $mostRatedRecipes,
            ],
            [
                'name' => 'Most steps',
                'recipes' => $mostStepsRecipes,
            ],
            [
                'name' => "Made for one",
                'recipes' => $madeforoneRecipes,
            ],
            [
                'name' => 'All recipes',
                'recipes' => $allRecipes,
            ],

        ];

        return ['data' => $data];
    }
}

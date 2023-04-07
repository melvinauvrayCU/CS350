<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Utensil;
use App\Models\Recipe;
use App\Models\RecipeStep;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeStep>
 */
class RecipeStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => fake()->text(),
            'cook_time' => fake()->time(),
            'prep_time' => fake()->time(),
            'recipe_id' => Recipe::factory(),
        ];
    }

    // ! Create the ingredients for the steps
    public function configure()
    {
        return $this->afterCreating(function (RecipeStep $recipeStep) {
            $recipeStep->ingredients()->attach(Ingredient::factory()->count(3)->create()->pluck('id')->toArray());
            $recipeStep->utensils()->attach(Utensil::factory()->count(3)->create()->pluck('id')->toArray());
        });
    }
}

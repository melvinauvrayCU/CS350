<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeSteps>
 */
class RecipeStepsFactory extends Factory
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
}

<?php

namespace Database\Factories;

use App\Models\Recipe;

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
}
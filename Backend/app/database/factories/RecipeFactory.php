<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\RecipeSteps;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            
            'user_id' => User::factory(),
            'title' => fake()->name(),
            'description' => fake()->text(),
            'recipe_steps' => RecipeSteps::factory(), 
            'image_url' => fake()->url(),
            'number_people' => fake()->numberBetween(1, 50),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Recipe $recipe) {
            $recipe->recipeSteps()->saveMany(RecipeStep::factory()->count(3)->create([
                'recipe_id' => $recipe->id,
            ]));
        });
    }
}

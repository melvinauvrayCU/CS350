<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            'image_url' => fake()->url(),
            'number_people' => fake()->numberBetween(1, 50),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}

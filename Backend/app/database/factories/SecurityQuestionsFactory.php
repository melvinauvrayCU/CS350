<?php

namespace Database\Factories;


use App\Models\Answer;
use App\Models\User;
use App\Models\SecurityQuestions;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeStep>
 */
class SecurityQuestionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question' => fake()->sentence(),
        ];
    }

}
<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\SecurityQuestions;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class SecurityAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'answer' => $this->faker->word(),
            'user_id' => User::factory(),
            'security_question_id' => SecurityQuestions::factory(),
        ];
    }
}
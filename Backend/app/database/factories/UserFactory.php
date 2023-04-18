<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SecurityQuestions;
use App\Models\SecurityAnswers;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $attributes = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'bio' => fake()-> sentence(),
            'fname' => fake() -> name(),
            'lname' => fake() -> name(),
            'profile_photo' => fake() -> image(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        $securityQuestions = SecurityQuestions::factory()->count(3)->create();
        foreach ($securityQuestions as $securityQuestion){
            $attributes['security_question_answers'][] = SecurityAnswers::factory([
                'security_question_id' => $securityQuestion ->id,
            ])->make()->toArray();
        }

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

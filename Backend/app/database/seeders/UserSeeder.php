<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RecipeSteps;
use App\Models\Recipe;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(10)
            ->has(Recipe::factory()
                ->count(5)
                ->has(RecipeSteps::factory()
                    ->count(3)
                )
            )
            ->create();

        User::factory()
            ->count(5)
            ->has(Recipe::factory()
                ->count(1)
                ->has(RecipeSteps::factory()
                    ->count(3)
                )
            )
            ->create();
    }
}

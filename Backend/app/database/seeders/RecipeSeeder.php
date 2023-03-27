<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Model\Recipe;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Recipe::factory()
            ->hasRecipeSteps(2)
            ->create();

        Recipe::factory()
            ->hasRecipeSteps(5)
            ->create();
    }
}

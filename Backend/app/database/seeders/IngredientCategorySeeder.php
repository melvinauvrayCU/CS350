<?php

namespace Database\Seeders;

use App\Models\IngredientCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IngredientCategory::factory()->count(10)->hasIngredients(10)->create();
    }
}

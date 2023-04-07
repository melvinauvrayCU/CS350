<?php

namespace Database\Seeders;

use App\Models\UtensilCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UtensilCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UtensilCategory::factory()->count(10)->hasUtensils(15)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Utensil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UtensilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Utensil::factory()
            ->count(5)
            ->create();
    }
}

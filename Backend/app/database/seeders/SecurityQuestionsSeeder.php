<?php

namespace Database\Seeders;

use App\Models\SecurityQuestions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecurityQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $securityQuestions = [
            'What was your childhood nickname?',
            'What is the name of your favorite childhood friend?',
            'What is your favorite movie?',
            'What is the name of your first pet?',
            'What is your favorite book?',
            'What is the name of the street you grew up on?',
            'What is your mother\'s maiden name?',
            'What was the name of your elementary school?',
            'What is your favorite color?',
            'What is your favorite food?'
        ];

        foreach ($securityQuestions as $securityQuestion) {
            SecurityQuestions::create(['question' => $securityQuestion]);
        }
    }
}

    
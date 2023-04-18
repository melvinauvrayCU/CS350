<?php
use Illuminate\Database\Seeder;
use App\Models\SecurityAnswer;
use App\Models\SecurityAnswers;
use App\Models\User;
use App\Models\SecurityQuestion;
use App\Models\SecurityQuestions;

class SecurityAnswersTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $questions = SecurityQuestions::all();

        foreach ($users as $user) {
            foreach ($questions as $question) {
                SecurityAnswers::create([
                    'user_id' => $user->id,
                    'security_question_id' => $question->id,
                    'answer' => 'Some answer for ' . $question->question
                ]);
            }
        }
    }
}

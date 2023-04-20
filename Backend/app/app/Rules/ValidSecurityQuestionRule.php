<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\SecurityQuestions;

class ValidSecurityQuestionRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Get the list of valid security questions
        $validQuestions = SecurityQuestions::getQuestions();

        // Check if the given value is in the list of valid security questions
        return in_array($value, $validQuestions);
    }

    public function message()
    {
        return 'The :attribute must be a valid security question.';
    }
}

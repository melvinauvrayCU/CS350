<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SecurityQuestions;

class SecurityQuestionsController extends Controller
{
    public function index()
    {
        $questions = SecurityQuestions::getQuestions();
        $response=[
            'data' => $questions
        ];
        return response($response,200);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityAnswers extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
    ];


    protected $table = 'security_questions_question';

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function secuirtyQuestions()
    {
        return $this->belongsTo(SecurityQuestions::class);
    }
}
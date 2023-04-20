<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestions extends Model
{
    use HasFactory;
    protected $table = 'security_questions';
   protected $fillable =['question'];


    public function user()
    {
        return $this->hasMany(User::class, 'security_question_1','id')
        ->orWhere('security_question_2',$this->id)
        ->orWhere('security_question_3',$this->id);
    }
    
    public static function getQuestions(){
         
        $questions= static::pluck('question')->toArray();
        return $questions;
        
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{

    use HasFactory,HasApiTokens;
    protected $fillable=[
        'name',
        'email',
        'password',
        'bio',
        'fname',
        'lname',
        'profile_picture',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }


    public function securityQuestion1()
    {
        return $this->belongsTo(SecurityQuestions::class, 'security_question_1_id');
    }

    public function securityQuestion2()
    {
        return $this->belongsTo(SecurityQuestions::class, 'security_question_2_id');
    }

    public function securityQuestion3()
    {
        return $this->belongsTo(SecurityQuestions::class, 'security_question_3_id');
    }

    public function securityAnswer1()
    {
        return $this->belongsTo(SecurityAnswers::class, 'security_answer_1_id');
    }

    public function securityAnswer2()
    {
        return $this->belongsTo(SecurityAnswers::class, 'security_answer_2_id');
    }

    public function securityAnswer3()
    {
        return $this->belongsTo(SecurityAnswers::class, 'security_answer_3_id');
    }


    public function ingredientCategories()
    {
        return $this->hasMany(IngredientCategory::class);
    }

    protected $table = 'users';
}

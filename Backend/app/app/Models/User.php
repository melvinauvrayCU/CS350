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
        'security_answer_1',
        'security_answer_2',
        'security_answer_3',
        'security_question_1',
        'security_question_2',
        'security_question_3',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
      

    public function ingredientCategories()
    {
        return $this->hasMany(IngredientCategory::class);
    }

    protected $table = 'users';
}

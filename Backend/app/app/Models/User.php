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

    public function securityAnswers(){
        return $this->hasMany(SecurityAnswers::class);
    }

    public function ingredientCategories()
    {
        return $this->hasMany(IngredientCategory::class);
    }

    protected $table = 'users';
}

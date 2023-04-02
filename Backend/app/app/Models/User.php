<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{

    use HasFactory,HasApiTokens;

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

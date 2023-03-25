<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    use HasFactory;

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

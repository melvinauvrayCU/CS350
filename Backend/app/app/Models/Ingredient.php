<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function ingredientCategories()
    {
        return $this->belongsToMany(IngredientCategory::class, 'ingredient_ingredient_category');
    }

    protected $table = 'ingredients';

    public function recipeSteps()
    {
        return $this->belongsToMany(RecipeStep::class, "recipe_step_ingredient");
                    
    }
}

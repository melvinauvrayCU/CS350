<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utensil extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function utensilCategories()
    {
        return $this->belongsToMany(UtensilCategory::class, 'utensil_utensil_category');
    }

    protected $table = 'utensils';

    public function recipeSteps()
    {
        return $this->belongsToMany(RecipeStep::class, "recipe_step_utensil");
    }
}

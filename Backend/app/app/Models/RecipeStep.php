<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    use HasFactory;
    protected $table = 'recipe_steps';
    // protected $connection = 'mysql';

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'number_people',
        'image_url',
        'rating',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipeSteps()
    {
        return $this->hasMany(RecipeSteps::class);
    }
}

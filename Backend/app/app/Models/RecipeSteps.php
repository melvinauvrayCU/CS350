<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeSteps extends Model
{
    use HasFactory;

    protected $fillable = [

        'description',
        'cook_time',
        'prep_time',
        'user_id',
    ];
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }


    //something like this for ingredients, would be the same for utensils
    /**
     * public function ingredients(){
     * return $this->hasMany(ingredients::class)
     * }
     */
}

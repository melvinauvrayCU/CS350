<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtensilCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function utensils()
    {
        return $this->belongsToMany(Utensil::class, 'utensil_utensil_category');
    }

    protected $table = 'utensil_categories';
}

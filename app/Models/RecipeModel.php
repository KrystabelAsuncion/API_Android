<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeModel extends Model
{
    use HasFactory;
    protected $table = 'recipes';
    protected $fillable = [
        'recipe_name',
        'recipe_description',
        'category',
        'steps',
        'ingredients'
    ];
}

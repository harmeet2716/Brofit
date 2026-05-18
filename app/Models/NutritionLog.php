<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NutritionLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'nutrition_logs';

    protected $fillable = [
        'user_id',
        'date',
        'meal_type',
        'food_name',
        'quantity_grams',
        'calories',
        'protein_g',
        'carbs_g',
        'fat_g',
    ];

    protected $casts = [
        'quantity_grams' => 'float',
        'calories' => 'float',
        'protein_g' => 'float',
        'carbs_g' => 'float',
        'fat_g' => 'float',
    ];
}

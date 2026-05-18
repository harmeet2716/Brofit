<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'courses';

    protected $fillable = [
        'name',
        'description',
        'difficulty',
        'category',
        'duration_weeks',
        'price',
        'image_url',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'float',
        'duration_weeks' => 'integer',
    ];
}

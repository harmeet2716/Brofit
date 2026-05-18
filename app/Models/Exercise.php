<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Exercise extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'exercises';

    protected $fillable = [
        'name',
        'muscle_group',
        'difficulty',
        'image_url',
        'description',
        'problems_solved',
        'steps',
        'duration_seconds',
        'calories_burned_per_set',
    ];

    protected $casts = [
        'problems_solved' => 'array',
        'steps' => 'array',
        'duration_seconds' => 'integer',
        'calories_burned_per_set' => 'integer',
    ];
}

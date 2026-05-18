<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DailyGoal extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'daily_goals';

    protected $fillable = [
        'user_id',
        'date',
        'goals', // array of objects: [['title' => '...', 'type' => '...', 'completed' => false]]
        'notes',
    ];

    protected $casts = [
        'goals' => 'array',
    ];
}

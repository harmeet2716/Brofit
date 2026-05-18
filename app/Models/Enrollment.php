<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Enrollment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'enrollments';

    protected $fillable = [
        'user_id',
        'course_id',
        'progress', // percentage
        'status', // active, completed, etc.
        'enrolled_at',
    ];

    protected $casts = [
        'progress' => 'integer',
        'enrolled_at' => 'datetime',
    ];
}

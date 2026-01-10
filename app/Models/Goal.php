<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'key',
        'title_hindi',
        'title_english',
        'description_hindi',
        'description_english',
        'steps_hindi',
        'steps_english',
        'default_progress',
        'difficulty_level',
        'estimated_duration_days',
        'required_skills',
        'resources',
        'icon',
        'color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'steps_hindi' => 'array',
        'steps_english' => 'array',
        'required_skills' => 'array',
        'resources' => 'array',
        'is_active' => 'boolean',
    ];
}

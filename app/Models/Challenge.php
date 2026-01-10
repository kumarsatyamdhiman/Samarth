<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'key',
        'title_hindi',
        'title_english',
        'description_hindi',
        'description_english',
        'category',
        'difficulty',
        'estimated_time_minutes',
        'instructions_hindi',
        'instructions_english',
        'resources',
        'reflection_questions',
        'points_reward',
        'badge_rewards',
        'is_daily',
        'is_weekly',
        'is_active',
        'sort_order',
        'target_audience'
    ];

    protected $casts = [
        'instructions_hindi' => 'array',
        'instructions_english' => 'array',
        'resources' => 'array',
        'reflection_questions' => 'array',
        'badge_rewards' => 'array',
        'target_audience' => 'array',
        'is_daily' => 'boolean',
        'is_weekly' => 'boolean',
        'is_active' => 'boolean',
    ];
}

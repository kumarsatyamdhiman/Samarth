<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $fillable = [
        'user_id',
        'goal_id',
        'progress_percentage',
        'status',
        'started_at',
        'completed_at',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user()
    {
        return $this->belongsTo(SamarthUser::class);
    }

    /**
     * Get the goal associated with this progress.
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}

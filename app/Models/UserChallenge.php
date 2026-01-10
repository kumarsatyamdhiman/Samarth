<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChallenge extends Model
{
    protected $fillable = [
        'user_id',
        'challenge_id',
        'is_completed',
        'completed_at',
        'points_earned',
    ];

    /**
     * Get the user that completed the challenge.
     */
    public function user()
    {
        return $this->belongsTo(SamarthUser::class);
    }

    /**
     * Get the challenge associated with this completion.
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}

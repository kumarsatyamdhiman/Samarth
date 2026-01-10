<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoLike extends Model
{
    protected $fillable = [
        'video_id',
        'user_id',
    ];

    /**
     * Get the video that owns the like
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Get the user that liked the video
     */
    public function user()
    {
        return $this->belongsTo(SamarthUser::class, 'user_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoShare extends Model
{
    protected $fillable = [
        'video_id',
        'user_id',
    ];

    /**
     * Get the video that was shared
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Get the user that shared the video
     */
    public function user()
    {
        return $this->belongsTo(SamarthUser::class, 'user_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoComment extends Model
{
    protected $fillable = [
        'video_id',
        'user_id',
        'comment',
    ];

    /**
     * Get the video that owns the comment
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Get the user that wrote the comment
     */
    public function user()
    {
        return $this->belongsTo(SamarthUser::class, 'user_id');
    }
}


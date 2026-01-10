<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name',
        'link',
        'type',
        'thumbnail',
        'duration',
        'views_count',
        'likes_count',
        'comments_count',
        'author',
    ];

    /**
     * Get comments for this video
     */
    public function comments()
    {
        return $this->hasMany(VideoComment::class);
    }

    /**
     * Get likes for this video
     */
    public function likes()
    {
        return $this->hasMany(VideoLike::class);
    }

    /**
     * Get shares for this video
     */
    public function shares()
    {
        return $this->hasMany(VideoShare::class);
    }
}


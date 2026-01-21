<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action_type',
        'points',
        'description',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    /**
     * Get the user that owns the points.
     */
    public function user()
    {
        return $this->belongsTo(SamarthUser::class, 'user_id');
    }

    /**
     * Check if user has already earned points for an action.
     */
    public static function hasEarnedPoints(int $userId, string $actionType): bool
    {
        return static::where('user_id', $userId)
            ->where('action_type', $actionType)
            ->exists();
    }

    /**
     * Get total points for a user.
     */
    public static function getTotalPoints(int $userId): int
    {
        return static::where('user_id', $userId)->sum('points');
    }

    /**
     * Award points to a user.
     */
    public static function awardPoints(int $userId, string $actionType, int $points, string $description = ''): self
    {
        return static::create([
            'user_id' => $userId,
            'action_type' => $actionType,
            'points' => $points,
            'description' => $description,
        ]);
    }

    /**
     * Get all point transactions for a user.
     */
    public static function getUserTransactions(int $userId)
    {
        return static::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}


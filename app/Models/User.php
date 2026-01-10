<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'samarth_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'role',
        'status',
        'language',
        'preferences',
        'is_terms_accepted',
        'is_privacy_accepted',
        'timezone',
        'two_factor_enabled',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_terms_accepted' => 'boolean',
            'is_privacy_accepted' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'preferences' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function challengeCompletions()
    {
        return $this->hasMany(UserChallenge::class);
    }

    /**
     * Get the user's education profiles.
     */
    public function educationProfiles()
    {
        return $this->hasMany(UserEducationProfile::class, 'user_id');
    }

    /**
     * Get the user's education plans.
     */
    public function educationPlans()
    {
        return $this->hasMany(UserEducationPlan::class, 'user_id');
    }
}

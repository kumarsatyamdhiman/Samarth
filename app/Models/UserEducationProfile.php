<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserEducationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_class',
        'planned_stream',
        'interest_tags',
        'strengths_hindi',
        'strengths_english',
        'challenges_hindi',
        'challenges_english',
        'family_support_level',
        'financial_constraints',
        'career_goals_hindi',
        'career_goals_english',
        'preferred_learning_style',
        'profile_completed_at'
    ];

    protected $casts = [
        'interest_tags' => 'array',
        'strengths_hindi' => 'array',
        'strengths_english' => 'array',
        'challenges_hindi' => 'array',
        'challenges_english' => 'array',
        'preferred_learning_style' => 'array',
        'profile_completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educationPlans()
    {
        return $this->hasMany(UserEducationPlan::class, 'profile_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('profile_completed_at');
    }

    public function scopeIncomplete($query)
    {
        return $query->whereNull('profile_completed_at');
    }

    public function scopeByClass($query, $class)
    {
        return $query->where('current_class', $class);
    }

    public function scopeByStream($query, $stream)
    {
        return $query->where('planned_stream', $stream);
    }

    // Helper methods
    public function isCompleted()
    {
        return !is_null($this->profile_completed_at);
    }

    public function getStrengthsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->strengths_hindi : $this->strengths_english;
    }

    public function getChallengesAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->challenges_hindi : $this->challenges_english;
    }

    public function getCareerGoalsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->career_goals_hindi : $this->career_goals_english;
    }

    public function hasInterest($interest)
    {
        return in_array($interest, $this->interest_tags ?? []);
    }

    public function addInterest($interest)
    {
        $interests = $this->interest_tags ?? [];
        if (!in_array($interest, $interests)) {
            $interests[] = $interest;
            $this->update(['interest_tags' => $interests]);
        }
    }

    public function removeInterest($interest)
    {
        $interests = $this->interest_tags ?? [];
        $this->update(['interest_tags' => array_filter($interests, fn($i) => $i !== $interest)]);
    }

    public function completeProfile()
    {
        $this->update(['profile_completed_at' => now()]);
    }

    // Static helper methods
    public static function getAvailableClasses()
    {
        return ['8', '9', '10', '11', '12', 'dropout'];
    }

    public static function getAvailableStreams()
    {
        return ['not_decided', 'science', 'commerce', 'arts', 'vocational'];
    }

    public static function getInterestTags()
    {
        return [
            'maths' => 'गणित',
            'biology' => 'जीव विज्ञान',
            'physics' => 'भौतिक विज्ञान',
            'chemistry' => 'रसायन विज्ञान',
            'computers' => 'कंप्यूटर',
            'business' => 'व्यापार',
            'drawing' => 'चित्रकला',
            'languages' => 'भाषाएं',
            'helping_people' => 'लोगों की मदद',
            'government_job' => 'सरकारी नौकरी',
            'army_police' => 'आर्मी/पुलिस',
            'craft_hands_on' => 'शिल्प/व्यावहारिक काम',
            'medicine' => 'चिकित्सा',
            'engineering' => 'इंजीनियरिंग',
            'teaching' => 'शिक्षण',
            'research' => 'शोध'
        ];
    }

    public static function getFamilySupportLevels()
    {
        return [
            'high' => 'बहुत अच्छा',
            'medium' => 'मध्यम',
            'low' => 'कम',
            'none' => 'कोई सहारा नहीं'
        ];
    }

    public static function getFinancialConstraintLevels()
    {
        return [
            'none' => 'कोई समस्या नहीं',
            'some' => 'कुछ समस्या',
            'significant' => 'गंभीर समस्या'
        ];
    }
}

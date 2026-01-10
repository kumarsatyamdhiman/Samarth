<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationSector extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name_hindi',
        'name_english',
        'description_hindi',
        'description_english',
        'why_important_hindi',
        'why_important_english',
        'eligibility_10th_hindi',
        'eligibility_10th_english',
        'eligibility_12th_hindi',
        'eligibility_12th_english',
        'career_prospects_hindi',
        'career_prospects_english',
        'icon',
        'color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'eligibility_10th_hindi' => 'array',
        'eligibility_10th_english' => 'array',
        'eligibility_12th_hindi' => 'array',
        'eligibility_12th_english' => 'array',
        'career_prospects_hindi' => 'array',
        'career_prospects_english' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class, 'sector_id');
    }

    public function competitiveExams()
    {
        return $this->hasMany(CompetitiveExam::class, 'sector_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Helper methods
    public function getNameAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->name_hindi : $this->name_english;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->description_hindi : $this->description_english;
    }

    public function getWhyImportantAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->why_important_hindi : $this->why_important_english;
    }

    public function getEligibility10thAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->eligibility_10th_hindi : $this->eligibility_10th_english;
    }

    public function getEligibility12thAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->eligibility_12th_hindi : $this->eligibility_12th_english;
    }

    public function getCareerProspectsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->career_prospects_hindi : $this->career_prospects_english;
    }
}

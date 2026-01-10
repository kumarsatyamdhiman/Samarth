<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'sector_id',
        'stream_id',
        'key',
        'name_hindi',
        'name_english',
        'description_hindi',
        'description_english',
        'duration',
        'eligibility_hindi',
        'eligibility_english',
        'job_prospects_hindi',
        'job_prospects_english',
        'avg_salary_hindi',
        'avg_salary_english',
        'required_subjects_hindi',
        'required_subjects_english',
        'skills_needed_hindi',
        'skills_needed_english',
        'course_type',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'required_subjects_hindi' => 'array',
        'required_subjects_english' => 'array',
        'skills_needed_hindi' => 'array',
        'skills_needed_english' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function sector()
    {
        return $this->belongsTo(EducationSector::class);
    }

    public function stream()
    {
        return $this->belongsTo(EducationStream::class);
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

    public function scopeBySector($query, $sectorId)
    {
        return $query->where('sector_id', $sectorId);
    }

    public function scopeByStream($query, $streamId)
    {
        return $query->where('stream_id', $streamId);
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

    public function getEligibilityAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->eligibility_hindi : $this->eligibility_english;
    }

    public function getJobProspectsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->job_prospects_hindi : $this->job_prospects_english;
    }

    public function getAvgSalaryAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->avg_salary_hindi : $this->avg_salary_english;
    }

    public function getRequiredSubjectsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->required_subjects_hindi : $this->required_subjects_english;
    }

    public function getSkillsNeededAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->skills_needed_hindi : $this->skills_needed_english;
    }
}

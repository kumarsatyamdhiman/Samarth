<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name_hindi',
        'name_english',
        'description_hindi',
        'description_english',
        'subjects_hindi',
        'subjects_english',
        'career_paths_hindi',
        'career_paths_english',
        'icon',
        'color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'subjects_hindi' => 'array',
        'subjects_english' => 'array',
        'career_paths_hindi' => 'array',
        'career_paths_english' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function competitiveExams()
    {
        return $this->hasMany(CompetitiveExam::class);
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

    public function getSubjectsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->subjects_hindi : $this->subjects_english;
    }

    public function getCareerPathsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->career_paths_hindi : $this->career_paths_english;
    }
}

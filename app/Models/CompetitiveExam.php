<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompetitiveExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'sector_id',
        'stream_id',
        'key',
        'name_hindi',
        'name_english',
        'sector',
        'applicable_for',
        'eligibility_class',
        'eligibility_hindi',
        'eligibility_english',
        'exam_pattern',
        'frequency',
        'subjects_hindi',
        'subjects_english',
        'preparation_tips_hindi',
        'preparation_tips_english',
        'official_website',
        'registration_period',
        'exam_months',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'eligibility_hindi' => 'array',
        'eligibility_english' => 'array',
        'subjects_hindi' => 'array',
        'subjects_english' => 'array',
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

    public function scopeBySector($query, $sector)
    {
        return $query->where('sector', $sector);
    }

    public function scopeByClass($query, $class)
    {
        return $query->where('eligibility_class', $class);
    }

    public function scopeForDegree($query)
    {
        return $query->where('applicable_for', 'degree');
    }

    public function scopeForDiploma($query)
    {
        return $query->where('applicable_for', 'diploma');
    }

    public function scopeForGovtJob($query)
    {
        return $query->where('applicable_for', 'govt_job');
    }

    // Helper methods
    public function getNameAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->name_hindi : $this->name_english;
    }

    public function getEligibilityAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->eligibility_hindi : $this->eligibility_english;
    }

    public function getSubjectsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->subjects_hindi : $this->subjects_english;
    }

    public function getPreparationTipsAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->preparation_tips_hindi : $this->preparation_tips_english;
    }

    public function getEligibilityClassAttribute($value)
    {
        // Normalize class values
        $classMap = [
            '10' => '10th',
            '12' => '12th',
            'graduation' => 'graduation',
            'post_graduation' => 'post_graduation'
        ];
        
        return $classMap[$value] ?? $value;
    }
}

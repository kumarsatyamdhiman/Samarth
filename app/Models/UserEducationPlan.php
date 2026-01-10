<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserEducationPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
        'plan_type',
        'recommended_streams',
        'recommended_sectors',
        'recommended_courses',
        'recommended_exams',
        'plan_data',
        'progress',
        'milestones',
        'study_schedule',
        'resources',
        'personalized_message_hindi',
        'personalized_message_english',
        'is_active',
        'generated_at'
    ];

    protected $casts = [
        'recommended_streams' => 'array',
        'recommended_sectors' => 'array',
        'recommended_courses' => 'array',
        'recommended_exams' => 'array',
        'plan_data' => 'array',
        'progress' => 'array',
        'milestones' => 'array',
        'study_schedule' => 'array',
        'resources' => 'array',
        'is_active' => 'boolean',
        'generated_at' => 'datetime',
    ];

// Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(UserEducationProfile::class, 'profile_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('plan_type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('generated_at', 'desc');
    }

    // Helper methods
    public function getPersonalizedMessageAttribute()
    {
        return app()->getLocale() === 'hi' ? $this->personalized_message_hindi : $this->personalized_message_english;
    }

    public function getProgressPercentageAttribute()
    {
        if (!$this->progress) return 0;
        
        $completed = collect($this->progress)->where('completed', true)->count();
        $total = count($this->progress);
        
        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    public function updateProgress($taskId, $completed = true, $notes = null)
    {
        $progress = $this->progress ?? [];
        
        $taskIndex = collect($progress)->search(fn($item) => $item['id'] === $taskId);
        
        if ($taskIndex !== false) {
            $progress[$taskIndex]['completed'] = $completed;
            $progress[$taskIndex]['completed_at'] = $completed ? now()->toISOString() : null;
            $progress[$taskIndex]['notes'] = $notes;
        }
        
        $this->update(['progress' => $progress]);
    }

    public function markMilestoneCompleted($milestoneId)
    {
        $milestones = $this->milestones ?? [];
        
        $milestoneIndex = collect($milestones)->search(fn($item) => $item['id'] === $milestoneId);
        
        if ($milestoneIndex !== false) {
            $milestones[$milestoneIndex]['completed'] = true;
            $milestones[$milestoneIndex]['completed_at'] = now()->toISOString();
            $this->update(['milestones' => $milestones]);
        }
    }

    public function getRecommendedStreams()
    {
        if (!$this->recommended_streams) return collect();
        
        return EducationStream::whereIn('id', $this->recommended_streams)->get();
    }

    public function getRecommendedSectors()
    {
        if (!$this->recommended_sectors) return collect();
        
        return EducationSector::whereIn('id', $this->recommended_sectors)->get();
    }

    public function getRecommendedCourses()
    {
        if (!$this->recommended_courses) return collect();
        
        return Course::whereIn('id', $this->recommended_courses)->get();
    }

    public function getRecommendedExams()
    {
        if (!$this->recommended_exams) return collect();
        
        return CompetitiveExam::whereIn('id', $this->recommended_exams)->get();
    }

    // Static helper methods for plan generation
    public static function generateStreamRecommendations($profile)
    {
        $streams = EducationStream::active()->ordered()->get();
        $recommendations = [];
        $interests = $profile->interest_tags ?? [];
        
        foreach ($streams as $stream) {
            $score = 0;
            
            // Interest-based scoring
            if (in_array('maths', $interests) && in_array('physics', $interests) && $stream->key === 'science') {
                $score += 3;
            }
            if (in_array('biology', $interests) && $stream->key === 'science') {
                $score += 3;
            }
            if (in_array('business', $interests) && $stream->key === 'commerce') {
                $score += 3;
            }
            if (in_array('drawing', $interests) || in_array('languages', $interests) && $stream->key === 'arts') {
                $score += 3;
            }
            if (in_array('craft_hands_on', $interests) && $stream->key === 'vocational') {
                $score += 3;
            }
            
            // Class-based adjustments
            if (in_array($profile->current_class, ['8', '9']) && $stream->key !== 'vocational') {
                $score += 1; // Encourage academic streams for younger students
            }
            
            if ($score > 0) {
                $recommendations[] = [
                    'stream_id' => $stream->id,
                    'score' => $score,
                    'stream' => $stream
                ];
            }
        }
        
        // Sort by score and return top recommendations
        usort($recommendations, fn($a, $b) => $b['score'] <=> $a['score']);
        
        return array_slice($recommendations, 0, 3);
    }

    public static function generateSectorRecommendations($profile, $streamKey = null)
    {
        $sectors = EducationSector::active()->ordered()->get();
        $recommendations = [];
        $interests = $profile->interest_tags ?? [];
        
        foreach ($sectors as $sector) {
            $score = 0;
            
            // Interest-based scoring
            $sectorInterestMap = [
                'engineering' => ['maths', 'computers', 'physics'],
                'medicine' => ['biology', 'helping_people'],
                'commerce' => ['business', 'maths'],
                'law' => ['languages', 'helping_people'],
                'defence' => ['army_police', 'government_job'],
                'government' => ['government_job', 'helping_people'],
                'skills' => ['craft_hands_on']
            ];
            
            $relevantInterests = $sectorInterestMap[$sector->key] ?? [];
            foreach ($relevantInterests as $interest) {
                if (in_array($interest, $interests)) {
                    $score += 2;
                }
            }
            
            // Stream alignment
            if ($streamKey) {
                $streamSectorMap = [
                    'science' => ['engineering', 'medicine', 'research'],
                    'commerce' => ['commerce', 'business'],
                    'arts' => ['law', 'media', 'social'],
                    'vocational' => ['skills', 'technical']
                ];
                
                if (isset($streamSectorMap[$streamKey]) && in_array($sector->key, $streamSectorMap[$streamKey])) {
                    $score += 2;
                }
            }
            
            if ($score > 0) {
                $recommendations[] = [
                    'sector_id' => $sector->id,
                    'score' => $score,
                    'sector' => $sector
                ];
            }
        }
        
        // Sort by score and return top recommendations
        usort($recommendations, fn($a, $b) => $b['score'] <=> $a['score']);
        
        return array_slice($recommendations, 0, 4);
    }
}

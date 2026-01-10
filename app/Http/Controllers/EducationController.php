<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EducationStream;
use App\Models\EducationSector;
use App\Models\Course;
use App\Models\CompetitiveExam;
use App\Models\UserEducationProfile;
use App\Models\UserEducationPlan;

class EducationController extends Controller
{

    /**
     * Display the main education page with all sections
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get or create user's education profile
        $profile = UserEducationProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['current_class' => '10'] // Default class
        );

        // Get all active streams
        $streams = EducationStream::active()->ordered()->get();

        // Get all active sectors
        $sectors = EducationSector::active()->ordered()->get();

        // Get user's education plans
        $educationPlans = UserEducationPlan::where('user_id', $user->id)
            ->where('is_active', true)
            ->latest()
            ->limit(3)
            ->get();

        // Get recommended exams based on user's profile
        $recommendedExams = $this->getRecommendedExams($profile);

        return view('education.index', compact(
            'profile',
            'streams',
            'sectors',
            'educationPlans',
            'recommendedExams'
        ));
    }

    /**
     * Display the user context section (profile setup)
     */
    public function profile()
    {
        $user = Auth::user();
        
        $profile = UserEducationProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['current_class' => '10']
        );

        $availableClasses = UserEducationProfile::getAvailableClasses();
        $availableStreams = UserEducationProfile::getAvailableStreams();
        $interestTags = UserEducationProfile::getInterestTags();
        $familySupportLevels = UserEducationProfile::getFamilySupportLevels();
        $financialConstraintLevels = UserEducationProfile::getFinancialConstraintLevels();

        return view('education.profile', compact(
            'profile',
            'availableClasses',
            'availableStreams',
            'interestTags',
            'familySupportLevels',
            'financialConstraintLevels'
        ));
    }

    /**
     * Update user education profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'current_class' => 'required|in:' . implode(',', UserEducationProfile::getAvailableClasses()),
            'planned_stream' => 'nullable|in:' . implode(',', UserEducationProfile::getAvailableStreams()),
            'interest_tags' => 'nullable|array',
            'family_support_level' => 'nullable|in:' . implode(',', array_keys(UserEducationProfile::getFamilySupportLevels())),
            'financial_constraints' => 'nullable|in:' . implode(',', array_keys(UserEducationProfile::getFinancialConstraintLevels())),
            'career_goals_hindi' => 'nullable|string|max:500',
            'career_goals_english' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        
        $profile = UserEducationProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'current_class',
                'planned_stream',
                'interest_tags',
                'family_support_level',
                'financial_constraints',
                'career_goals_hindi',
                'career_goals_english'
            ])
        );

        // Generate recommendations if profile is completed
        if ($profile->isCompleted()) {
            $this->generateRecommendations($profile);
        }

        return redirect()->route('education.index')
            ->with('success', 'प्रोफ़ाइल सफलतापूर्वक अपडेट हो गया!');
    }

    /**
     * Display streams section
     */
    public function streams()
    {
        $user = Auth::user();
        $profile = UserEducationProfile::where('user_id', $user->id)->first();
        
        $streams = EducationStream::active()->ordered()->get();
        
        // Get stream recommendations if profile exists
        $recommendations = [];
        if ($profile && $profile->isCompleted()) {
            $recommendations = UserEducationPlan::generateStreamRecommendations($profile);
        }

        return view('education.streams', compact('streams', 'profile', 'recommendations'));
    }

    /**
     * Display sectors and courses section
     */
    public function sectors($sectorKey = null)
    {
        $sectors = EducationSector::active()->ordered()->get();
        
        $selectedSector = null;
        $courses = collect();
        $exams = collect();
        
        if ($sectorKey) {
            $selectedSector = EducationSector::where('key', $sectorKey)->firstOrFail();
            $courses = Course::where('sector_id', $selectedSector->id)
                ->active()
                ->ordered()
                ->with('stream')
                ->get();
            $exams = CompetitiveExam::where('sector_id', $selectedSector->id)
                ->active()
                ->ordered()
                ->get();
        }

        return view('education.sectors', compact(
            'sectors',
            'selectedSector',
            'courses',
            'exams'
        ));
    }

    /**
     * Display competitive exams section
     */
    public function exams(Request $request)
    {
        $class = $request->get('class');
        $sector = $request->get('sector');
        
        $examsQuery = CompetitiveExam::active()->ordered()->with('sector', 'stream');
        
        if ($class) {
            $examsQuery->where('eligibility_class', $class);
        }
        
        if ($sector) {
            $examsQuery->where('sector', $sector);
        }
        
        $exams = $examsQuery->get();
        
        $classes = ['10th', '12th', 'graduation'];
        $sectors = ['engineering', 'medicine', 'commerce', 'government', 'defence', 'law'];
        
        return view('education.exams', compact('exams', 'classes', 'sectors', 'class', 'sector'));
    }

    /**
     * Generate personalized education plan
     */
    public function generatePlan()
    {
        $user = Auth::user();
        $profile = UserEducationProfile::where('user_id', $user->id)->firstOrFail();
        
        if (!$profile->isCompleted()) {
            return redirect()->route('education.profile')
                ->with('error', 'कृपया पहले अपनी प्रोफ़ाइल पूरी करें।');
        }

        // Generate stream recommendations
        $streamRecommendations = UserEducationPlan::generateStreamRecommendations($profile);
        
        // Generate sector recommendations
        $sectorRecommendations = UserEducationPlan::generateSectorRecommendations($profile);
        
        // Create education plan
        $plan = UserEducationPlan::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'plan_type' => 'comprehensive',
            'recommended_streams' => array_column($streamRecommendations, 'stream_id'),
            'recommended_sectors' => array_column($sectorRecommendations, 'sector_id'),
            'plan_data' => [
                'stream_recommendations' => $streamRecommendations,
                'sector_recommendations' => $sectorRecommendations,
                'generated_at' => now()->toISOString()
            ],
            'personalized_message_hindi' => $this->generatePersonalizedMessage($profile, 'hindi'),
            'personalized_message_english' => $this->generatePersonalizedMessage($profile, 'english'),
            'generated_at' => now()
        ]);

        return redirect()->route('education.plan', $plan->id)
            ->with('success', 'आपकी व्यक्तिगत शिक्षा योजना तैयार हो गई है!');
    }

    /**
     * Display personalized education plan
     */
    public function showPlan($planId)
    {
        $user = Auth::user();
        
        $plan = UserEducationPlan::where('id', $planId)
            ->where('user_id', $user->id)
            ->with('profile')
            ->firstOrFail();

        return view('education.plan', compact('plan'));
    }

    /**
     * Get recommended exams based on user profile
     */
    private function getRecommendedExams($profile)
    {
        if (!$profile || !$profile->isCompleted()) {
            return collect();
        }

        $examsQuery = CompetitiveExam::active()->ordered()->with('sector', 'stream');
        
        // Filter by class
        $examsQuery->where('eligibility_class', $profile->current_class);
        
        // Filter by stream if planned stream is decided
        if ($profile->planned_stream && $profile->planned_stream !== 'not_decided') {
            $stream = EducationStream::where('key', $profile->planned_stream)->first();
            if ($stream) {
                $examsQuery->where('stream_id', $stream->id);
            }
        }
        
        return $examsQuery->limit(6)->get();
    }

    /**
     * Generate recommendations for user profile
     */
    private function generateRecommendations($profile)
    {
        // This method can be expanded to generate more comprehensive recommendations
        // Currently handled in the generatePlan method
    }

    /**
     * Generate personalized message for user
     */
    private function generatePersonalizedMessage($profile, $language)
    {
        $class = $profile->current_class;
        $interests = $profile->interest_tags ?? [];
        $plannedStream = $profile->planned_stream;
        
        if ($language === 'hindi') {
            $message = "आपकी कक्षा {$class} के आधार पर और आपकी रुचियों को देखते हुए, हमने आपके लिए सबसे उपयुक्त विकल्प तैयार किए हैं। ";
            
            if ($plannedStream && $plannedStream !== 'not_decided') {
                $streamName = EducationStream::where('key', $plannedStream)->first()?->name ?? '';
                $message .= "आपका चुना हुआ {$streamName} स्ट्रीम आपके लक्ष्यों के अनुकूल है। ";
            }
            
            $message .= "शिक्षा जारी रखने से आपको अधिक विकल्प मिलेंगे और भविष्य में बेहतर अवसर प्राप्त होंगे।";
            
            return $message;
        } else {
            $message = "Based on your class {$class} and interests, we have prepared the most suitable options for you. ";
            
            if ($plannedStream && $plannedStream !== 'not_decided') {
                $streamName = EducationStream::where('key', $plannedStream)->first()?->name ?? '';
                $message .= "Your chosen {$streamName} stream aligns with your goals. ";
            }
            
            $message .= "Continuing education will give you more options and better opportunities in the future.";
            
            return $message;
        }
    }
}

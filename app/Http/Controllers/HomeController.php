<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use App\Models\Challenge;
use App\Models\UserProgress;
use App\Models\UserChallenge;
use App\Models\UserEducationProfile;
use App\Models\UserEducationPlan;
use App\Models\EducationStream;
use App\Services\PointsService;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Initialize empty data if user not logged in
        if (!$user) {
            return view('home', [
                'userProgress' => [],
                'todayChallenges' => [],
                'completedChallenges' => [],
                'recentAchievements' => [],
                'educationProfile' => null,
                'educationPlans' => [],
                'streamRecommendations' => [],
                'userProgressData' => null,
                'user' => null
            ]);
        }

        // Get user's progress on goals
        $userProgress = UserProgress::where('user_id', $user->id)->get();

        // Get today's challenges
        $todayChallenges = Challenge::where('is_daily', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get user's completed challenges
        $completedChallenges = UserChallenge::where('user_id', $user->id)
            ->whereDate('completed_at', today())
            ->pluck('challenge_id')
            ->toArray();

        // Get recent achievements
        $recentAchievements = UserChallenge::where('user_id', $user->id)
            ->where('completed_at', '>=', now()->subDays(7))
            ->with('challenge')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get();

        // Get education profile and recommendations for widget
        $educationProfile = UserEducationProfile::where('user_id', $user->id)->first();
        $educationPlans = UserEducationPlan::where('user_id', $user->id)
            ->where('is_active', true)
            ->latest()
            ->limit(2)
            ->get();
        $streamRecommendations = [];
        if ($educationProfile && $educationProfile->isCompleted()) {
            $streamRecommendations = UserEducationPlan::generateStreamRecommendations($educationProfile);
        }

        // Get user progress data from PointsService
        $userProgressData = PointsService::getUserProgress($user->id);

        return view('home', compact(
            'user',
            'userProgress',
            'todayChallenges',
            'completedChallenges',
            'recentAchievements',
            'educationProfile',
            'educationPlans',
            'streamRecommendations',
            'userProgressData'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Challenge;
use App\Models\UserChallenge;

class ChallengeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $challenges = Challenge::where('is_active', true)->orderBy('sort_order')->get();
        
        // Get user's completed challenges
        $completedChallenges = UserChallenge::where('user_id', $user->id)
            ->whereDate('completed_at', today())
            ->pluck('challenge_id')
            ->toArray();
            
        return view('challenges.index', compact('challenges', 'completedChallenges'));
    }

    public function show(Challenge $challenge)
    {
        $user = Auth::user();
        
        // Check if user has completed this challenge today
        $userChallenge = UserChallenge::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->whereDate('completed_at', today())
            ->first();
            
        return view('challenges.show', compact('challenge', 'userChallenge'));
    }

    public function complete(Challenge $challenge, Request $request)
    {
        $user = Auth::user();
        
        // Check if already completed today
        $existing = UserChallenge::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->whereDate('completed_at', today())
            ->first();
            
        if ($existing) {
            return back()->with('error', 'आपने यह चैलेंज आज पहले ही पूरा कर लिया है।');
        }
        
        // Create completion record
        UserChallenge::create([
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'completed_at' => now(),
            'points_earned' => $challenge->points_reward,
            'notes' => $request->notes ?? null
        ]);
        
        return back()->with('success', 'बधाई हो! आपने चैलेंज पूरा किया और ' . $challenge->points_reward . ' अंक अर्जित किए।');
    }

    public function publicIndex()
    {
        $challenges = Challenge::where('is_active', true)->orderBy('sort_order')->get();
        return view('challenges.public', compact('challenges'));
    }
}

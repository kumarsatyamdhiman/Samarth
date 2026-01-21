<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SamarthUser;
use App\Models\UserProfile;
use App\Models\UserProgress;
use App\Models\UserChallenge;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();
        
        // Get user's overall progress
        $totalProgress = UserProgress::where('user_id', $user->id)->avg('progress_percentage') ?? 0;
        
        // Get total points earned
        $totalPoints = UserChallenge::where('user_id', $user->id)->sum('points_earned');
        
        // Get recent activities
        $recentActivities = UserChallenge::where('user_id', $user->id)
            ->with('challenge')
            ->orderBy('completed_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('profile.show', compact('user', 'profile', 'totalProgress', 'totalPoints', 'recentActivities'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'display_name' => 'nullable|string|max:255',
            'language_preference' => 'nullable|string|in:hi,en',
            'notification_preferences' => 'nullable|array'
        ]);
        
        // Update or create user profile
        $profile = UserProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['language_preference' => 'hi']
        );
        
        $profile->update([
            'display_name' => $request->display_name,
            'language_preference' => $request->language_preference ?? 'hi',
            'notification_preferences' => $request->notification_preferences ?? []
        ]);
        
        return back()->with('success', 'प्रोफ़ाइल अपडेट की गई!');
    }

    public function notifications()
    {
        $user = Auth::user();
        return view('profile.notifications', compact('user'));
    }

    public function settings()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();
        return view('profile.settings', compact('user', 'profile'));
    }
}

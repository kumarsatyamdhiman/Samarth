<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;

class GoalController extends Controller
{
    /**
     * Display the goals page
     */
    public function index()
    {
        $goals = Goal::where('is_active', true)->orderBy('sort_order')->get();
        return view('goals.index', compact('goals'));
    }

    /**
     * Display public goals page
     */
    public function publicIndex()
    {
        $goals = Goal::where('is_active', true)->orderBy('sort_order')->get();
        return view('goals.index', compact('goals'));
    }

    /**
     * Display a specific goal
     */
    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    /**
     * Store a new goal (simplified - just redirect)
     */
    public function store(Request $request)
    {
        $request->validate([
            'goal_key' => 'required|string|exists:goals,key'
        ]);

        // Store goal in session for now
        session(['selected_goal' => $request->goal_key]);

        return redirect()->route('education.index')->with('success', 'लक्ष्य चुन लिया गया! अब अपना शिक्षा पथ बनाएं।');
    }
}

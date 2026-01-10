<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\VideoController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('web');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Recovery Routes
Route::get('/password/recovery', function() {
    return view('auth.password-recovery');
})->name('password.security.request');
Route::post('/password/security/check', [AuthController::class, 'checkSecurityQuestion'])->name('password.security.check');
Route::post('/password/security/reset', [AuthController::class, 'resetPassword'])->name('password.security.reset');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/goals', [GoalController::class, 'index'])->name('goals.index');
    Route::get('/goals/{goal}', [GoalController::class, 'show'])->name('goals.show');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
    
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');
    Route::post('/challenges/{challenge}/complete', [ChallengeController::class, 'complete'])->name('challenges.complete');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Education Module Routes
    Route::get('/education', [EducationController::class, 'index'])->name('education.index');
    Route::get('/education/profile', [EducationController::class, 'profile'])->name('education.profile');
    Route::post('/education/profile', [EducationController::class, 'updateProfile'])->name('education.profile.update');
    Route::get('/education/streams', [EducationController::class, 'streams'])->name('education.streams');
    Route::get('/education/sectors', [EducationController::class, 'sectors'])->name('education.sectors');
    Route::get('/education/sectors/{sectorKey}', [EducationController::class, 'sectors'])->name('education.sectors.show');
    Route::get('/education/exams', [EducationController::class, 'exams'])->name('education.exams');
    Route::post('/education/plan/generate', [EducationController::class, 'generatePlan'])->name('education.plan.generate');
    Route::get('/education/plan/{planId}', [EducationController::class, 'showPlan'])->name('education.plan');
    
    // Videos Routes
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::post('/videos/{videoId}/like', [VideoController::class, 'like'])->name('videos.like');
    Route::post('/videos/{videoId}/share', [VideoController::class, 'share'])->name('videos.share');
    Route::post('/videos/{videoId}/comment', [VideoController::class, 'comment'])->name('videos.comment');
    Route::get('/videos/{videoId}/comments', [VideoController::class, 'getComments'])->name('videos.comments');
});

// Public Routes (accessible without login)
Route::get('/public/goals', [GoalController::class, 'publicIndex'])->name('public.goals');
Route::get('/public/challenges', [ChallengeController::class, 'publicIndex'])->name('public.challenges');

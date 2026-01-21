<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return redirect()->route('home'); });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/welcome', function () { return view('welcome'); });

// Social Routes
Route::get('/social', [SocialController::class, 'index'])->name('social.index');
Route::post('/social/post', [SocialController::class, 'storePost'])->name('social.post.store');
Route::post('/social/like/{postId}', [SocialController::class, 'like'])->name('social.like');
Route::post('/social/bookmark/{postId}', [SocialController::class, 'bookmark'])->name('social.bookmark');
Route::post('/social/share/{postId}', [SocialController::class, 'share'])->name('social.share');
Route::post('/social/comment/{postId}', [SocialController::class, 'comment'])->name('social.comment'); // Existing legacy if any, replacing usage below
Route::get('/social/comments/{postId}', [SocialController::class, 'getComments']);
Route::post('/social/comments/{postId}', [SocialController::class, 'postComment']);
Route::get('/social/notifications', [SocialController::class, 'getNotifications']);

// Story Routes
Route::get('/social/stories', [SocialController::class, 'stories'])->name('social.stories');
Route::post('/social/story/create', [SocialController::class, 'createStory'])->name('social.story.create');
Route::get('/social/story/view/{storyId}', [SocialController::class, 'viewStory'])->name('social.story.view');
Route::delete('/social/story/delete/{storyId}', [SocialController::class, 'deleteStory'])->name('social.story.delete');

// Explore Routes
Route::get('/social/explore', [SocialController::class, 'explore'])->name('social.explore');

// Message Routes
Route::get('/social/messages', [SocialController::class, 'messages'])->name('social.messages');
Route::get('/social/chat/{userId}', [SocialController::class, 'chat'])->name('social.chat');
Route::get('/social/messages/{userId}', [SocialController::class, 'getMessages']);
Route::post('/social/message/send', [SocialController::class, 'sendMessage'])->name('social.message.send');
Route::get('/social/messages/search', [SocialController::class, 'searchMessages'])->name('social.messages.search');

// Auth Routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/password/recovery', [App\Http\Controllers\AuthController::class, 'showRecovery'])->name('password.recovery');
Route::post('/password/recovery', [App\Http\Controllers\AuthController::class, 'sendRecovery'])->name('password.send');

// Profile Routes
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('profile.settings');
Route::get('/profile/notifications', [App\Http\Controllers\ProfileController::class, 'notifications'])->name('profile.notifications');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// Education Routes
Route::get('/education', [App\Http\Controllers\EducationController::class, 'index'])->name('education.index');
Route::get('/education/profile', [App\Http\Controllers\EducationController::class, 'profile'])->name('education.profile');
Route::put('/education/profile', [App\Http\Controllers\EducationController::class, 'updateProfile'])->name('education.profile.update');
Route::get('/education/streams', [App\Http\Controllers\EducationController::class, 'streams'])->name('education.streams');
Route::get('/education/sectors', [App\Http\Controllers\EducationController::class, 'sectors'])->name('education.sectors');
Route::get('/education/exams', [App\Http\Controllers\EducationController::class, 'exams'])->name('education.exams');
Route::get('/education/plan', [App\Http\Controllers\EducationController::class, 'plan'])->name('education.plan');
Route::post('/education/plan', [App\Http\Controllers\EducationController::class, 'generatePlan'])->name('education.plan.generate');

// Video Routes
Route::get('/videos', [App\Http\Controllers\VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{id}', [App\Http\Controllers\VideoController::class, 'show'])->name('videos.show');
Route::post('/videos/{id}/like', [App\Http\Controllers\VideoController::class, 'like'])->name('videos.like');
Route::post('/videos/{id}/comment', [App\Http\Controllers\VideoController::class, 'comment'])->name('videos.comment');
Route::post('/videos/{id}/share', [App\Http\Controllers\VideoController::class, 'share'])->name('videos.share');

// Goals Routes - Load from JSON
Route::get('/goals', function() {
    $goalsPath = storage_path('data/goals.json');
    $goals = file_exists($goalsPath) ? json_decode(file_get_contents($goalsPath), true) : [];
    return view('goals.index', compact('goals'));
})->name('goals.index');
Route::post('/goals', function(\Illuminate\Http\Request $r) { return redirect()->back()->with('success', 'Goal added!'); })->name('goals.store');

// Challenges Routes - Load from JSON
Route::get('/challenges', function() {
    $challengesPath = storage_path('data/challenges.json');
    $challenges = file_exists($challengesPath) ? json_decode(file_get_contents($challengesPath), true) : [];
    return view('challenges.index', compact('challenges'));
})->name('challenges.index');

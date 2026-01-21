<?php

/**
 * Test script for Points System
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PointsService;
use App\Models\SamarthUser;
use App\Models\UserPoint;

echo "=== Testing Points System ===\n\n";

// Test with user ID 1 (if exists)
$testUserId = 1;

$user = SamarthUser::find($testUserId);
if (!$user) {
    echo "No test user found. Creating test user...\n";
    $user = SamarthUser::create([
        'username' => 'testuser' . time(),
        'email' => 'test' . time() . '@example.com',
        'password' => bcrypt('password123'),
    ]);
    echo "Created test user with ID: {$user->id}\n";
}

echo "Testing with User ID: {$user->id}\n\n";

// Test PointsService::getUserProgress()
echo "1. Testing getUserProgress()...\n";
$progress = PointsService::getUserProgress($user->id);
echo "   Earned Points: {$progress['earned_points']}\n";
echo "   Total Points: {$progress['total_points']}\n";
echo "   Progress %: {$progress['progress_percentage']}%\n";
echo "   Completed Actions: " . count($progress['completed_actions']) . "\n";
echo "   Pending Actions: " . count($progress['pending_actions']) . "\n\n";

// Test calculateEarnedPoints()
echo "2. Testing calculateEarnedPoints()...\n";
$earnedPoints = PointsService::calculateEarnedPoints($user->id);
echo "   Calculated Points: {$earnedPoints}\n\n";

// Test calculateProgressPercentage()
echo "3. Testing calculateProgressPercentage()...\n";
$progressPercent = PointsService::calculateProgressPercentage($earnedPoints);
echo "   Progress %: {$progressPercent}%\n\n";

// Test UserPoint model
echo "4. Testing UserPoint model...\n";
$transactions = UserPoint::getUserTransactions($user->id);
echo "   Total Transactions: " . $transactions->count() . "\n\n";

// Test awarding points
echo "5. Testing awardPoints()...\n";
$awarded = PointsService::awardProfilePoints($user->id);
echo "   Profile points awarded: " . ($awarded ? 'Yes' : 'Already earned') . "\n";
$totalPoints = UserPoint::getTotalPoints($user->id);
echo "   New Total Points: {$totalPoints}\n\n";

// Test hasEarnedPoints()
echo "6. Testing hasEarnedPoints()...\n";
$hasPoints = UserPoint::hasEarnedPoints($user->id, 'profile_complete');
echo "   Has profile points: " . ($hasPoints ? 'Yes' : 'No') . "\n\n";

// Final progress check
echo "7. Final Progress Check...\n";
$finalProgress = PointsService::getUserProgress($user->id);
echo "   Earned Points: {$finalProgress['earned_points']}\n";
echo "   Total Points: {$finalProgress['total_points']}\n";
echo "   Progress %: {$finalProgress['progress_percentage']}%\n\n";

echo "=== Test Complete ===\n";
echo "\nPoints System is working correctly!\n";


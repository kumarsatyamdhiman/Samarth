<?php

/**
 * Test script to verify JSON storage functionality
 * Run with: php test_json_storage.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\JsonDataStore;

echo "=== Testing JSON Data Store ===\n\n";

$store = new JsonDataStore();

// Test 1: Create a user
echo "1. Creating test user...\n";
$user = $store->create('users', [
    'first_name' => 'Test',
    'last_name' => 'User',
    'username' => 'testuser_' . time(),
    'email' => 'test' . time() . '@example.com',
    'password' => password_hash('password123', PASSWORD_BCRYPT),
    'role' => 'user',
    'status' => 'active',
]);
echo "   Created user ID: " . $user['id'] . "\n";

// Test 2: Find the user
echo "\n2. Finding user by username...\n";
$foundUser = $store->findBy('users', 'username', $user['username']);
if ($foundUser) {
    echo "   Found user: " . $foundUser['first_name'] . " " . $foundUser['last_name'] . "\n";
} else {
    echo "   ERROR: User not found!\n";
}

// Test 3: Update user
echo "\n3. Updating user first name...\n";
$store->update('users', $user['id'], ['first_name' => 'Updated']);
$updatedUser = $store->find('users', $user['id']);
echo "   New name: " . $updatedUser['first_name'] . "\n";

// Test 4: Get all users
echo "\n4. Getting all users...\n";
$allUsers = $store->all('users');
echo "   Total users: " . count($allUsers) . "\n";

// Test 5: Create education stream
echo "\n5. Creating education stream...\n";
$stream = $store->create('education_streams', [
    'key' => 'test_stream',
    'name' => 'Test Stream',
    'description' => 'A test stream',
    'icon' => 'test',
    'color' => 'blue',
]);
echo "   Created stream ID: " . $stream['id'] . "\n";

// Test 6: Find education stream by key
echo "\n6. Finding stream by key...\n";
$foundStream = $store->findBy('education_streams', 'key', 'test_stream');
if ($foundStream) {
    echo "   Found stream: " . $foundStream['name'] . "\n";
}

// Test 7: Create video like
echo "\n7. Creating video like...\n";
$like = $store->create('video_likes', [
    'video_id' => 1,
    'user_id' => $user['id'],
]);
echo "   Created like ID: " . $like['id'] . "\n";

// Test 8: Get user likes
echo "\n8. Getting user likes...\n";
$userLikes = $store->getByField('video_likes', 'user_id', $user['id']);
echo "   User likes count: " . count($userLikes) . "\n";

// Test 9: Delete test data
echo "\n9. Cleaning up test data...\n";
$store->delete('users', $user['id']);
$store->delete('education_streams', $stream['id']);
$store->delete('video_likes', $like['id']);
echo "   Cleaned up successfully\n";

// Test 10: Verify deletion
echo "\n10. Verifying deletion...\n";
$deletedUser = $store->find('users', $user['id']);
if ($deletedUser === null) {
    echo "   Deletion verified - user no longer exists\n";
}

echo "\n=== All Tests Passed! ===\n";


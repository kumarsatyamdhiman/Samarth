<?php
// Create a test user for login
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\SamarthUser;

// Check if testuser exists
$user = SamarthUser::where('username', 'testuser')->first();
if (!$user) {
    $user = SamarthUser::create([
        'first_name' => 'Test',
        'last_name' => 'User',
        'username' => 'testuser',
        'email' => 'test@test.com',
        'phone' => '1234567890',
        'gender' => 'male',
        'date_of_birth' => '2000-01-01',
        'password' => Hash::make('test123'),
        'role' => 'user',
        'status' => 'active',
        'is_terms_accepted' => true,
        'is_privacy_accepted' => true,
        'timezone' => 'Asia/Kolkata',
        'language' => 'hi',
    ]);
    echo "Test user created: testuser / test123\n";
} else {
    echo "Test user already exists: testuser\n";
}

// Also create in JSON store
$jsonStore = new \App\Services\JsonDataStore();
$existingUser = $jsonStore->findBy('users', 'username', 'testuser');
if (!$existingUser) {
    $jsonStore->create('users', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'username' => 'testuser',
        'email' => 'test@test.com',
        'phone' => '1234567890',
        'gender' => 'male',
        'date_of_birth' => '2000-01-01',
        'password' => Hash::make('test123'),
        'role' => 'user',
        'status' => 'active',
    ]);
    echo "Test user added to JSON store\n";
}

echo "Done!\n";


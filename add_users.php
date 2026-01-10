<?php

echo "=== ADDING MISSING TEST USERS ===\n\n";

try {
    require __DIR__.'/vendor/autoload.php';
    
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $pdo = new PDO("sqlite:" . database_path('database.sqlite'));
    
    // Add the missing test users that are shown in the UI
    echo "Adding test users shown in login page...\n";
    
    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO samarth_users (username, email, password, first_name, last_name, role, status, language, is_terms_accepted, is_privacy_accepted, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now'))");
    
    $usersToAdd = [
        ['ritu', 'ritu@example.com', $hashedPassword, 'Ritu', 'Sharma', 'user', 'active', 'hindi', 1, 1],
        ['raju', 'raju@example.com', $hashedPassword, 'Raju', 'Kumar', 'user', 'active', 'hindi', 1, 1],
        ['admin', 'admin@example.com', $adminPassword, 'Admin', 'User', 'admin', 'active', 'hindi', 1, 1]
    ];
    
    foreach ($usersToAdd as $user) {
        $stmt->execute($user);
        echo "✅ Added/Updated user: " . $user[0] . "\n";
    }
    
    // Verify all users
    echo "\nCurrent users in database:\n";
    $stmt = $pdo->query("SELECT id, username, email, first_name, last_name, role FROM samarth_users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "   • ID: {$user['id']}, Username: {$user['username']}, Name: {$user['first_name']} {$user['last_name']} ({$user['role']})\n";
    }
    
    // Create user profiles for new users
    echo "\nCreating user profiles...\n";
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO user_profiles (user_id, preferred_language, created_at, updated_at) VALUES (?, 'hindi', datetime('now'), datetime('now'))");
    
    foreach ($users as $user) {
        $stmt->execute([$user['id']]);
        echo "✅ Created profile for user: " . $user['username'] . "\n";
    }
    
    echo "\n=== USERS ADDED SUCCESSFULLY ===\n";
    echo "You can now login with:\n";
    echo "• ritu / password123\n";
    echo "• raju / password123\n";
    echo "• admin / admin123\n";
    echo "• testuser / password123 (original)\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

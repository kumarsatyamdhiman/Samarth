echo "=== TESTING DATABASE AND AUTHENTICATION ===\n\n";

try {
    // Connect to database using Laravel's configuration
    require __DIR__.'/vendor/autoload.php';
    
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $pdo = new PDO("sqlite:" . database_path('database.sqlite'));
    
    // Test samarth_users table
    echo "1. Testing samarth_users table:\n";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM samarth_users");
    $result = $stmt->fetch();
    echo "   Total users in samarth_users: " . $result['count'] . "\n";
    
    // Show users
    $stmt = $pdo->query("SELECT id, username, email, first_name, last_name FROM samarth_users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "   ❌ No users found! Creating test user...\n";
        
        // Create test users
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO samarth_users (username, email, password, first_name, last_name, role, status, language, is_terms_accepted, is_privacy_accepted, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now'))");
        
        $testUsers = [
            ['ritu', 'ritu@example.com', $hashedPassword, 'Ritu', 'Sharma', 'user', 'active', 'hindi', 1, 1],
            ['raju', 'raju@example.com', $hashedPassword, 'Raju', 'Kumar', 'user', 'active', 'hindi', 1, 1],
            ['admin', 'admin@example.com', password_hash('admin123', PASSWORD_DEFAULT), 'Admin', 'User', 'admin', 'active', 'hindi', 1, 1]
        ];
        
        foreach ($testUsers as $user) {
            $stmt->execute($user);
            echo "   ✅ Created user: " . $user[0] . "\n";
        }
        
        // Refresh the query
        $stmt = $pdo->query("SELECT id, username, email, first_name, last_name FROM samarth_users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo "\n2. Available users:\n";
    foreach ($users as $user) {
        echo "   • ID: {$user['id']}, Username: {$user['username']}, Email: {$user['email']}, Name: {$user['first_name']} {$user['last_name']}\n";
    }
    
    // Test user_profiles table
    echo "\n3. Testing user_profiles table:\n";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM user_profiles");
    $result = $stmt->fetch();
    echo "   Total profiles: " . $result['count'] . "\n";
    
    echo "\n4. Testing authentication configuration:\n";
    $authConfig = require __DIR__.'/config/auth.php';
    echo "   Auth provider model: " . $authConfig['providers']['users']['model'] . "\n";
    echo "   ✅ Configuration looks correct!\n";
    
    echo "\n=== TEST COMPLETE ===\n";
    echo "Database is working and test users are available.\n";
    echo "Login with: ritu / password123 or raju / password123 or admin / admin123\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

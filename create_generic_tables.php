<?php

// Generic Database Creation Script with Standard Table Names
echo "=== Creating Database Tables with Generic Names ===\n";

try {
    // Connect to SQLite database
    $dbPath = __DIR__ . '/database/database.sqlite';
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database\n\n";
    
    // Drop existing tables if they exist (for clean start)
    $tablesToDrop = ['user_challenges', 'user_progress', 'challenges', 'goals', 'user_profiles', 'users'];
    foreach ($tablesToDrop as $table) {
        $pdo->exec("DROP TABLE IF EXISTS $table");
    }
    echo "✅ Cleaned up existing tables\n\n";
    
    // Create users table (generic name)
    echo "Creating users table...\n";
    $pdo->exec("CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255),
        username VARCHAR(255) UNIQUE NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(255),
        last_name VARCHAR(255),
        phone VARCHAR(20),
        date_of_birth DATE,
        gender VARCHAR(10),
        is_active BOOLEAN DEFAULT 1,
        email_verified_at TIMESTAMP NULL,
        last_login_at TIMESTAMP NULL,
        remember_token VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✅ users table created\n";
    
    // Create user_profiles table
    echo "Creating user_profiles table...\n";
    $pdo->exec("CREATE TABLE user_profiles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        bio TEXT,
        location VARCHAR(255),
        website VARCHAR(255),
        avatar VARCHAR(255),
        preferred_language VARCHAR(10) DEFAULT 'hindi',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
    )");
    echo "✅ user_profiles table created\n";
    
    // Create goals table
    echo "Creating goals table...\n";
    $pdo->exec("CREATE TABLE goals (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title_hindi VARCHAR(255) NOT NULL,
        title_english VARCHAR(255),
        description_hindi TEXT,
        description_english TEXT,
        category VARCHAR(100),
        target_age_group VARCHAR(50),
        estimated_time_hours INTEGER DEFAULT 1,
        points_reward INTEGER DEFAULT 10,
        is_active BOOLEAN DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✅ goals table created\n";
    
    // Create challenges table
    echo "Creating challenges table...\n";
    $pdo->exec("CREATE TABLE challenges (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title_hindi VARCHAR(255) NOT NULL,
        title_english VARCHAR(255),
        description_hindi TEXT,
        description_english TEXT,
        category VARCHAR(100),
        estimated_time_minutes INTEGER DEFAULT 30,
        points_reward INTEGER DEFAULT 5,
        is_active BOOLEAN DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✅ challenges table created\n";
    
    // Create user_progress table
    echo "Creating user_progress table...\n";
    $pdo->exec("CREATE TABLE user_progress (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        goal_id INTEGER NOT NULL,
        progress_percentage DECIMAL(5,2) DEFAULT 0.00,
        status VARCHAR(50) DEFAULT 'in_progress',
        started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        completed_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
        FOREIGN KEY (goal_id) REFERENCES goals (id) ON DELETE CASCADE
    )");
    echo "✅ user_progress table created\n";
    
    // Create user_challenges table
    echo "Creating user_challenges table...\n";
    $pdo->exec("CREATE TABLE user_challenges (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        challenge_id INTEGER NOT NULL,
        is_completed BOOLEAN DEFAULT 0,
        completed_at TIMESTAMP NULL,
        points_earned INTEGER DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
        FOREIGN KEY (challenge_id) REFERENCES challenges (id) ON DELETE CASCADE
    )");
    echo "✅ user_challenges table created\n";
    
    // Insert test user
    echo "\nInserting test user...\n";
    $stmt = $pdo->prepare("INSERT INTO users (name, username, email, password, first_name, last_name, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Test User', 'test', 'test@example.com', password_hash('password', PASSWORD_DEFAULT), 'Test', 'User', 1]);
    echo "✅ Test user created (ID: " . $pdo->lastInsertId() . ")\n";
    
    echo "\n=== Generic Database Setup Complete ===\n";
    echo "✅ All tables created with generic names:\n";
    echo "  - users (not users)\n";
    echo "  - user_profiles\n";
    echo "  - goals\n";
    echo "  - challenges\n";
    echo "  - user_progress\n";
    echo "  - user_challenges\n";
    echo "✅ Test user created (username: test, password: password)\n";
    echo "✅ User model now works with standard 'users' table\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

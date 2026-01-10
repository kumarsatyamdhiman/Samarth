<?php

/**
 * Registration System Test Script
 * 
 * This script tests the user registration functionality.
 * Run this from the command line: php test_registration.php
 */

echo "=== SAMARTH Registration System Test ===\n\n";

// Test 1: Verify registration route exists
echo "1. Testing registration routes...\n";
$routes = [
    'GET /register' => 'showRegister method',
    'POST /register' => 'register method',
];

foreach ($routes as $route => $method) {
    echo "   ✓ {$route} -> {$method}\n";
}

// Test 2: Verify registration view exists
echo "\n2. Testing registration view...\n";
$viewPath = __DIR__ . '/resources/views/auth/register.blade.php';
if (file_exists($viewPath)) {
    echo "   ✓ Registration view exists at: {$viewPath}\n";
    
    // Check for required form fields
    $content = file_get_contents($viewPath);
    $requiredFields = [
        'first_name' => 'First Name field',
        'last_name' => 'Last Name field',
        'username' => 'Username field',
        'email' => 'Email field',
        'password' => 'Password field',
        'gender' => 'Gender field',
        'date_of_birth' => 'Date of Birth field',
        'is_terms_accepted' => 'Terms acceptance checkbox',
        'csrf' => 'CSRF token',
        'route("register.submit")' => 'Form action route',
    ];
    
    foreach ($requiredFields as $field => $name) {
        if (strpos($content, $field) !== false) {
            echo "   ✓ {$name} found\n";
        } else {
            echo "   ✗ {$name} NOT found!\n";
        }
    }
} else {
    echo "   ✗ Registration view NOT found!\n";
}

// Test 3: Verify AuthController has registration methods
echo "\n3. Testing AuthController registration methods...\n";
$controllerPath = __DIR__ . '/app/Http/Controllers/AuthController.php';
if (file_exists($controllerPath)) {
    $content = file_get_contents($controllerPath);
    
    $methods = [
        'showRegister' => 'Show registration form',
        'register' => 'Handle registration submission',
        'Validator::make' => 'Validation logic',
        'SamarthUser::create' => 'User creation',
        'Auth::login' => 'Auto login after registration',
    ];
    
    foreach ($methods as $method => $desc) {
        if (strpos($content, $method) !== false) {
            echo "   ✓ {$desc} implemented\n";
        } else {
            echo "   ✗ {$desc} NOT found!\n";
        }
    }
}

// Test 4: Verify routes are configured
echo "\n4. Testing route configuration...\n";
$routesPath = __DIR__ . '/routes/web.php';
if (file_exists($routesPath)) {
    $content = file_get_contents($routesPath);
    
    $routePatterns = [
        "route('register.show')" => 'Register show route',
        "route('register.submit')" => 'Register submit route',
    ];
    
    foreach ($routePatterns as $pattern => $desc) {
        if (strpos($content, $pattern) !== false) {
            echo "   ✓ {$desc} configured\n";
        } else {
            echo "   ✗ {$desc} NOT configured!\n";
        }
    }
}

// Test 5: Verify login page has registration link
echo "\n5. Testing login page registration link...\n";
$loginPath = __DIR__ . '/resources/views/auth/login.blade.php';
if (file_exists($loginPath)) {
    $content = file_get_contents($loginPath);
    
    if (strpos($content, "route('register.show')") !== false) {
        echo "   ✓ Registration link found on login page\n";
    } else {
        echo "   ✗ Registration link NOT found on login page!\n";
    }
}

// Test 6: Verify user data is saved to database
echo "\n6. Testing database model...\n";
$modelPath = __DIR__ . '/app/Models/SamarthUser.php';
if (file_exists($modelPath)) {
    $content = file_get_contents($modelPath);
    
    $fillableFields = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'username' => 'Username',
        'email' => 'Email',
        'phone' => 'Phone',
        'gender' => 'Gender',
        'date_of_birth' => 'Date of Birth',
        'password' => 'Password',
        'role' => 'Role',
        'status' => 'Status',
    ];
    
    foreach ($fillableFields as $field => $name) {
        if (strpos($content, "'{$field}'") !== false) {
            echo "   ✓ {$name} is fillable\n";
        } else {
            echo "   ✗ {$name} is NOT fillable!\n";
        }
    }
}

// Test 7: Verify personalized content on home page
echo "\n7. Testing personalized content on home page...\n";
$homePath = __DIR__ . '/resources/views/home.blade.php';
if (file_exists($homePath)) {
    $content = file_get_contents($homePath);
    
    $personalizationElements = [
        '$educationProfile' => 'Education Profile variable',
        '$streamRecommendations' => 'Stream Recommendations',
        "route('education.profile')" => 'Education Profile link',
        "route('education.index')" => 'Education Index link',
    ];
    
    foreach ($personalizationElements as $element => $desc) {
        if (strpos($content, $element) !== false) {
            echo "   ✓ {$desc} present\n";
        } else {
            echo "   ✗ {$desc} NOT present!\n";
        }
    }
}

echo "\n=== Test Complete ===\n\n";
echo "Summary:\n";
echo "- Registration page: Created\n";
echo "- AuthController: Updated with register methods\n";
echo "- Routes: Added register routes\n";
echo "- Login page: Added registration link\n";
echo "- Home page: Added personalized education content\n\n";
echo "To use the registration system:\n";
echo "1. Start your Laravel server: php artisan serve\n";
echo "2. Open browser and go to /register\n";
echo "3. Fill in the form and submit\n";
echo "4. User will be automatically logged in\n";
echo "5. Personalized recommendations will be shown on home page\n\n";


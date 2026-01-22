<?php

/**
 * Samarth Application - Deployment Configuration for Shared Hosting
 * 
 * Server: 103.133.214.97:9825
 * Target: /home/udyogastra/public_html
 */

return [
    'app' => [
        'name' => 'SAMARTH',
        'env' => 'production',
        'debug' => false,
        'url' => 'http://udyogastra.com',
        'timezone' => 'Asia/Kolkata',
        'locale' => 'hi',
        'fallback_locale' => 'en',
        'key' => env('APP_KEY', 'base64:your-generated-key-here'),
        'cipher' => 'AES-256-CBC',
    ],

    'database' => [
        // For shared hosting, we'll use file-based SQLite for simplicity
        // Or configure MySQL if available on the server
        'default' => 'sqlite',
        
        'connections' => [
            'sqlite' => [
                'driver' => 'sqlite',
                'database' => database_path('database.sqlite'),
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ],
        
        // Alternative MySQL configuration (uncomment if MySQL is available)
        /*
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'udyogastra_samarth',
            'username' => 'udyogastra_user',
            'password' => 'your-password',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
        */
    ],

    'session' => [
        'driver' => 'file',
        'lifetime' => '120',
        'expire_on_close' => false,
        'encrypt' => false,
        'files' => storage_path('framework/sessions'),
    ],

    'cache' => [
        'driver' => 'file',
        'stores' => [
            'file' => [
                'driver' => 'file',
                'path' => storage_path('framework/cache/data'),
            ],
        ],
    ],

    'filesystems' => [
        'default' => 'local',
        'disks' => [
            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
            ],
            'public' => [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => env('APP_URL') . '/storage',
                'visibility' => 'public',
            ],
        ],
    ],

    'logging' => [
        'default' => 'stack',
        'channels' => [
            'stack' => [
                'driver' => 'single',
                'path' => storage_path('logs/laravel.log'),
                'level' => 'error',
            ],
        ],
    ],
];


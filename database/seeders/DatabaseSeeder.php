<?php

namespace Database\Seeders;

use App\Models\SamarthUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        SamarthUser::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'first_name' => 'Test',
            'last_name' => 'User',
            'role' => 'user',
            'status' => 'active',
            'language' => 'hindi',
            'is_terms_accepted' => true,
            'is_privacy_accepted' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\SamarthUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['username' => 'TEST', 'email' => 'TEST@example.com', 'password' => 'TEST', 'first_name' => 'TEST', 'last_name' => '', 'status' => 'active'],
            ['username' => 'meet', 'email' => 'meet@example.com', 'password' => 'password123', 'first_name' => 'मीत', 'last_name' => '', 'status' => 'active'],
            ['username' => 'ritu', 'email' => 'ritu@example.com', 'password' => 'password123', 'first_name' => 'रितु', 'last_name' => '', 'status' => 'active'],
            ['username' => 'raju', 'email' => 'raju@example.com', 'password' => 'password123', 'first_name' => 'राजु', 'last_name' => '', 'status' => 'active'],
            ['username' => 'admin', 'email' => 'admin@example.com', 'password' => 'admin123', 'first_name' => 'एडमिन', 'last_name' => '', 'status' => 'active'],
        ];

        foreach ($users as $userData) {
SamarthUser::create([
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'status' => $userData['status'],
                'is_terms_accepted' => true,
                'is_privacy_accepted' => true
            ]);
        }
    }
}

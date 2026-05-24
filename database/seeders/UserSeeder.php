<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add Admin User
        User::updateOrCreate(
            ['email' => 'admin@Frank.test'],
            [
                'full_name' => 'Frank Administrator',
                'role' => 'admin',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        // Add Council User
        User::updateOrCreate(
            ['email' => 'council@Frank.test'],
            [
                'full_name' => 'Council Officer',
                'role' => 'council',
                'password' => Hash::make('Password@123'),
                'email_verified_at' => now(),
            ]
        );

        // Add a few more generic users for stats
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@example.test"],
                [
                    'full_name' => "Generic Starter User {$i}",
                    'role' => 'citizen',
                    'password' => Hash::make('Password@123'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 regular users using the factory
        User::factory()->count(10)->create();

        // Create a specific 'user' role entry
        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser123',
            'email' => 'test1@example.com',
            'password' => Hash::make('password123'), // Changed password for clarity
            'role' => 'user',
        ]);

        // Create a specific 'admin' role entry
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
            'role' => 'admin',
        ]);

        // Create a specific 'editor' role entry
        User::factory()->create([
            'name' => 'Editor User',
            'username' => 'editoruser',
            'email' => 'editor@example.com',
            'password' => Hash::make('editorpassword'),
            'role' => 'editor',
        ]);

        // Create a specific 'contributor' role entry
        User::factory()->create([
            'name' => 'Contributor User',
            'username' => 'contributoruser',
            'email' => 'contributor@example.com',
            'password' => Hash::make('contributorpassword'),
            'role' => 'contributor',
        ]);
    }
}

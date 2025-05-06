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
        User::factory()->count(10)->create();

        User::factory()->create([
            'name' => 'Test user',
            'username' => 'testuser123',
            'email' => 'test1@example.com',
            'password' => Hash::make('test1@example.com'),
            'role' => 'user',
        ]);
    }
}
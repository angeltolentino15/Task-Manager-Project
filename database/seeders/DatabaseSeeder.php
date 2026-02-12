<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@example.com'], // The unique ID to check
        [
            'name' => 'Main Admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            // Add other required fields like department if necessary
            'department' => 'IT', 
            'position' => 'System Administrator',
        ]
    );
}
}

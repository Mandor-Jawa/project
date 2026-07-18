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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Reviewer User',
            'email' => 'reviewer@example.com',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
        ]);

        User::factory()->create([
            'name' => 'Proposer User',
            'email' => 'proposer@example.com',
            'password' => bcrypt('password'),
            'role' => 'proposer',
        ]);
    }
}

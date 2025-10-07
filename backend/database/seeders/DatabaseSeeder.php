<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user (avoid duplicates)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'),
                'status' => 'other',
            ]
        );

        // Create additional test users if they don't exist
        if (User::count() < 6) {
            User::factory(5)->create();
        }

        // Seed review site data
        $this->call([
            ReviewSiteCategorySeeder::class,
            BusinessSeeder::class,
            LaboratorySeeder::class,
        ]);
    }
}

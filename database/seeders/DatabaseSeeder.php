<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin Konsultan',
            'email' => 'admin@konsultanpajak.com',
        ]);

        // Run all seeders
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
            ActivitySeeder::class,
            TrainingSeeder::class,
            BannerSeeder::class,
        ]);
    }
}

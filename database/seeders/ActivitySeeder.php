<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityImage;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 activities with images
        Activity::factory()
            ->count(10)
            ->create()
            ->each(function ($activity) {
                // Create 3-8 images for each activity
                ActivityImage::factory()
                    ->count(fake()->numberBetween(3, 8))
                    ->create([
                        'activity_id' => $activity->id,
                    ]);
            });

        // Create 2 featured activities
        Activity::factory()
            ->count(2)
            ->featured()
            ->upcoming()
            ->create()
            ->each(function ($activity) {
                ActivityImage::factory()
                    ->count(fake()->numberBetween(5, 10))
                    ->create([
                        'activity_id' => $activity->id,
                    ]);
            });
    }
}

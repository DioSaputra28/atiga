<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\ActivityImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityImage>
 */
class ActivityImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'activity_id' => Activity::factory(),
            'image_path' => fake()->imageUrl(800, 600, 'business'),
            'caption' => fake()->optional(0.5)->sentence(),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}

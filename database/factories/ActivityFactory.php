<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(3, true),
            'held_at' => fake()->dateTimeBetween('-6 months', '+6 months'),
            'location' => fake()->optional(0.7)->city(),
            'is_featured' => fake()->boolean(15),
        ];
    }

    /**
     * Indicate that the activity is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the activity is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'held_at' => fake()->dateTimeBetween('now', '+6 months'),
        ]);
    }

    /**
     * Indicate that the activity is past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'held_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $startDate = fake()->dateTimeBetween('now', '+6 months');
        // Clone startDate and add 1-7 days to ensure end_date is always after start_date
        $endDate = (clone $startDate)->modify('+'.fake()->numberBetween(1, 7).' days');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(4, true),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => fake()->city(),
            'price' => fake()->randomElement([0, 500000, 750000, 1000000, 1500000, 2000000]),
            'capacity' => fake()->optional(0.7)->numberBetween(10, 100),
            'status' => fake()->randomElement([
                Training::STATUS_UPCOMING,
                Training::STATUS_UPCOMING,
                Training::STATUS_UPCOMING,
                Training::STATUS_ONGOING,
                Training::STATUS_COMPLETED,
            ]),
            'is_featured' => fake()->boolean(20),
            'registration_link' => fake()->optional(0.8)->url(),
            'instructor_name' => fake()->optional(0.9)->name(),
            'thumbnail' => fake()->optional(0.9)->imageUrl(800, 600, 'education'),
        ];
    }

    /**
     * Indicate that the training is free.
     */
    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => 0,
        ]);
    }

    /**
     * Indicate that the training is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the training is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = fake()->dateTimeBetween('now', '+6 months');
            $endDate = (clone $startDate)->modify('+'.fake()->numberBetween(1, 7).' days');

            return [
                'status' => Training::STATUS_UPCOMING,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([
            Banner::TYPE_HERO,
            Banner::TYPE_SIDEBAR,
            Banner::TYPE_FOOTER,
        ]);

        return [
            'title' => fake()->sentence(),
            'type' => $type,
            'image_path' => fake()->imageUrl(1200, 400, 'business'),
            'link_url' => fake()->optional(0.8)->url(),
            'alt_text' => fake()->optional()->sentence(),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'starts_at' => fake()->optional(0.3)->dateTimeBetween('-1 month', 'now'),
            'ends_at' => fake()->optional(0.3)->dateTimeBetween('now', '+3 months'),
            'click_count' => fake()->numberBetween(0, 5000),
            'view_count' => fake()->numberBetween(0, 50000),
        ];
    }

    /**
     * Indicate that the banner is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the banner is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the banner is currently running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'starts_at' => null,
            'ends_at' => null,
        ]);
    }

    /**
     * Indicate that the banner is of hero type.
     */
    public function hero(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Banner::TYPE_HERO,
        ]);
    }

    /**
     * Indicate that the banner is of sidebar type.
     */
    public function sidebar(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Banner::TYPE_SIDEBAR,
        ]);
    }
}

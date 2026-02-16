<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AboutPage>
 */
class AboutPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hero_title' => fake()->sentence(5),
            'hero_subtitle' => fake()->sentence(8),
            'intro_text' => fake()->paragraphs(2, true),
            'stats_json' => [
                [
                    'label' => 'UMKM Binaan',
                    'value' => (string) fake()->numberBetween(100, 500),
                    'suffix' => '+',
                ],
                [
                    'label' => 'Provinsi Jangkauan',
                    'value' => (string) fake()->numberBetween(5, 38),
                    'suffix' => null,
                ],
            ],
            'vision_json' => [
                ['text' => fake()->sentence(12)],
            ],
            'mission_json' => [
                ['text' => fake()->sentence(10)],
                ['text' => fake()->sentence(10)],
            ],
            'core_values_json' => [
                [
                    'icon' => 'handshake',
                    'title' => 'Kolaborasi',
                    'description' => fake()->sentence(12),
                ],
                [
                    'icon' => 'chart-bar',
                    'title' => 'Dampak Nyata',
                    'description' => fake()->sentence(12),
                ],
            ],
            'cta_title' => fake()->sentence(4),
            'cta_description' => fake()->paragraph(),
            'cta_label' => fake()->words(2, true),
            'cta_url' => '/contact',
            'is_published' => fake()->boolean(70),
        ];
    }
}

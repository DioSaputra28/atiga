<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServicesPage>
 */
class ServicesPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hero_badge' => fake()->boolean(80) ? fake()->words(2, true) : null,
            'hero_title' => fake()->sentence(4),
            'hero_highlight' => fake()->boolean(70) ? fake()->words(2, true) : null,
            'hero_description' => fake()->paragraphs(2, true),
            'main_services_json' => [
                [
                    'id' => '01',
                    'icon' => 'fa-solid fa-briefcase',
                    'title' => fake()->sentence(3),
                    'description' => fake()->sentence(10),
                    'features' => [
                        fake()->sentence(4),
                        fake()->sentence(4),
                    ],
                ],
                [
                    'id' => '02',
                    'icon' => 'fa-solid fa-users',
                    'title' => fake()->sentence(3),
                    'description' => fake()->sentence(10),
                    'features' => [
                        fake()->sentence(4),
                        fake()->sentence(4),
                    ],
                ],
            ],
            'is_published' => fake()->boolean(70),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\TaxRegulation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaxRegulation>
 */
class TaxRegulationFactory extends Factory
{
    protected $model = TaxRegulation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'document_path' => fake()->optional(0.6)->regexify('tax-regulations/[A-Za-z0-9]{10}.pdf'),
            'document_name' => fake()->optional(0.6)->words(3, true).'.pdf',
            'youtube_url' => fake()->optional(0.5)->url(),
            'is_published' => fake()->boolean(70),
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-6 months', 'now'),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}

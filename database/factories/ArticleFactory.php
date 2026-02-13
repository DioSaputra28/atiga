<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $publishedAt = fake()->optional(0.8)->dateTimeBetween('-1 year', 'now');

        return [
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => $this->generateContentBlocks(),
            'thumbnail' => fake()->optional(0.9)->imageUrl(800, 600, 'business'),
            'is_highlighted' => fake()->boolean(20),
            'is_published' => $publishedAt !== null,
            'published_at' => $publishedAt,
            'view_count' => fake()->numberBetween(0, 10000),
        ];
    }

    /**
     * Generate content blocks for the article.
     *
     * @return array<int, array<string, mixed>>
     */
    private function generateContentBlocks(): array
    {
        $blocks = [];
        $blockCount = fake()->numberBetween(3, 8);

        for ($i = 0; $i < $blockCount; $i++) {
            $type = fake()->randomElement(['text', 'text', 'text', 'image', 'youtube']);

            match ($type) {
                'text' => $blocks[] = [
                    'type' => 'text',
                    'content' => fake()->paragraph(fake()->numberBetween(3, 8)),
                ],
                'image' => $blocks[] = [
                    'type' => 'image',
                    'src' => fake()->imageUrl(800, 600, 'business'),
                    'alt' => fake()->sentence(),
                    'caption' => fake()->optional()->sentence(),
                ],
                'youtube' => $blocks[] = [
                    'type' => 'youtube',
                    'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'title' => fake()->optional()->sentence(),
                ],
            };
        }

        return $blocks;
    }

    /**
     * Indicate that the article is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the article is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the article is highlighted.
     */
    public function highlighted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_highlighted' => true,
        ]);
    }
}

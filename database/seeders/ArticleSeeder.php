<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing categories and tags
        $categories = Category::all();
        $tags = Tag::all();

        // Get first user or create one
        $user = User::first();
        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@konsultanpajak.com',
            ]);
        }

        // Create 20 published articles
        Article::factory()
            ->count(20)
            ->published()
            ->create([
                'user_id' => $user->id,
            ])
            ->each(function ($article) use ($categories, $tags) {
                // Attach random category
                $article->category_id = $categories->random()->id;
                $article->save();

                // Attach random tags (2-5 tags)
                $article->tags()->attach(
                    $tags->random(fake()->numberBetween(2, 5))->pluck('id')
                );
            });

        // Create 3 highlighted articles
        Article::factory()
            ->count(3)
            ->published()
            ->highlighted()
            ->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
            ])
            ->each(function ($article) use ($tags) {
                $article->tags()->attach(
                    $tags->random(fake()->numberBetween(2, 4))->pluck('id')
                );
            });

        // Create 5 draft articles
        Article::factory()
            ->count(5)
            ->draft()
            ->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
            ]);
    }
}

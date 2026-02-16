<?php

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

it('renders articles index with mobile-first responsive classes', function (): void {
    $category = Category::factory()->create([
        'name' => 'Perpajakan',
        'slug' => 'perpajakan',
    ]);

    Article::factory()->published()->highlighted()->create([
        'category_id' => $category->id,
        'title' => 'Artikel Unggulan Responsif',
        'slug' => 'artikel-unggulan-responsif',
        'published_at' => Carbon::parse('2026-02-10 09:00:00'),
    ]);

    Article::factory()->count(3)->published()->create([
        'category_id' => $category->id,
        'is_highlighted' => false,
        'published_at' => Carbon::parse('2026-02-09 09:00:00'),
    ]);

    $response = get('/artikel');

    $response->assertOk();
    $response->assertSeeText('Artikel & Insight');
    $response->assertSeeText('Artikel Unggulan Responsif');
    $response->assertSee('class="relative mx-auto max-w-7xl px-3 py-12 sm:px-4 sm:py-16 md:py-24"', false);
    $response->assertSee('class="mb-4 text-3xl font-extrabold leading-tight text-white sm:mb-6 sm:text-4xl md:text-5xl lg:text-6xl"', false);
    $response->assertSee('class="max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base md:text-lg"', false);
    $response->assertSee('class="grid gap-6 lg:gap-8 lg:grid-cols-3"', false);
    $response->assertSee('class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6"', false);
    $response->assertSee('class="article-card group min-w-0 overflow-hidden rounded-xl bg-white shadow-sm sm:rounded-2xl"', false);
    $response->assertSee('class="p-4 sm:p-5"', false);
    $response->assertSee('class="mb-3 text-sm leading-6 text-slate-600 line-clamp-2 sm:mb-4"', false);
});

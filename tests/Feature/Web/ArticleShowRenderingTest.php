<?php

use App\Models\Article;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

it('renders article show with 320px-safe responsive classes', function (): void {
    $article = Article::factory()->published()->create([
        'title' => 'Artikel Responsif Detail',
        'slug' => 'artikel-responsif-detail',
        'published_at' => Carbon::parse('2026-02-10 09:00:00'),
        'content' => [
            [
                'type' => 'text',
                'content' => '<p>Konten utama artikel untuk pengujian tampilan responsif.</p>',
            ],
        ],
    ]);

    Article::factory()->published()->create([
        'category_id' => $article->category_id,
        'title' => 'Artikel Terkait Responsif',
        'slug' => 'artikel-terkait-responsif',
        'published_at' => Carbon::parse('2026-02-09 09:00:00'),
    ]);

    $response = get('/artikel/'.$article->slug);

    $response->assertOk();
    $response->assertSeeText('Artikel Responsif Detail');
    $response->assertSee('class="relative h-52 sm:h-64 md:h-96"', false);
    $response->assertSee('class="mb-2 max-w-4xl text-xl font-extrabold leading-tight text-white sm:mb-3 sm:text-2xl md:text-4xl"', false);
    $response->assertSee('class="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-[11px] leading-5 text-white/80 sm:text-xs md:text-sm"', false);
    $response->assertSee('class="mx-auto grid max-w-7xl items-start gap-8 px-3 sm:px-4 lg:grid-cols-3 lg:gap-10"', false);
    $response->assertSee('class="article-rich-content max-w-none text-sm leading-7 text-slate-700 sm:text-base sm:leading-8"', false);
    $response->assertSee('class="min-w-0 break-words"', false);
    $response->assertSee('class="min-w-0 space-y-4 sm:space-y-6"', false);
    $response->assertSee('class="break-words text-sm font-semibold leading-6 text-primary-700 transition group-hover:text-secondary-600"', false);
    $response->assertSee('class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-4 py-2 text-sm font-bold text-primary-700 hover:bg-accent/90 sm:w-auto"', false);
});

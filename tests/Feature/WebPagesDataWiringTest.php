<?php

use App\Models\Activity;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Settings\SiteSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use function Pest\Laravel\get;

it('uses hero fallback and renders home sections with real data', function (): void {
    $category = Category::factory()->create([
        'name' => 'Perpajakan',
        'slug' => 'perpajakan',
    ]);

    $featuredAndMain = Article::factory()->count(8)->published()->create([
        'category_id' => $category->id,
        'is_highlighted' => false,
        'is_published' => true,
        'published_at' => Carbon::parse('2026-01-08 10:00:00'),
    ]);

    foreach ($featuredAndMain as $index => $article) {
        $article->update([
            'title' => 'Artikel Dinamis '.($index + 1),
            'slug' => 'artikel-dinamis-'.($index + 1).'-'.Str::lower(Str::random(5)),
            'published_at' => Carbon::parse('2026-01-08 10:00:00')->subMinutes($index),
        ]);
    }

    $recommendedArticle = Article::factory()->published()->create([
        'category_id' => $category->id,
        'title' => 'Artikel Rekomendasi Teratas',
        'slug' => 'artikel-rekomendasi-teratas',
        'is_highlighted' => false,
        'is_published' => true,
        'published_at' => Carbon::parse('2026-01-01 10:00:00'),
        'view_count' => 9999,
    ]);

    Activity::factory()->create([
        'title' => 'Kegiatan Pajak Nasional',
        'slug' => 'kegiatan-pajak-nasional',
    ]);

    $response = get('/');

    $response->assertOk();
    $response->assertSeeText('Konsultan Pajak Tepercaya untuk Bisnis Anda');
    $response->assertSeeText('Artikel Dinamis 1');
    $response->assertSeeText('Artikel Dinamis 2');
    $response->assertDontSeeText('Strategi Perencanaan Pajak Efektif untuk Perusahaan di Tahun 2025');
    $response->assertSeeText('Langkah Awal Audit Pajak Internal');
    $response->assertSeeText($recommendedArticle->title);
    $response->assertSeeText('Kegiatan Pajak Nasional');
    $response->assertSeeText('Rekomendasi Artikel');
    $response->assertSeeText('Galeri Kegiatan');
    $response->assertSee('id="slider" class="relative mx-auto h-[280px] w-full overflow-hidden rounded-2xl bg-primary-600 shadow-lg sm:h-[320px] md:h-[360px]"', false);
    $response->assertSee('class="mt-3 text-xl font-bold leading-tight text-balance sm:text-2xl md:text-4xl"', false);
    $response->assertSee('class="mt-4 inline-flex min-h-[44px] items-center justify-center rounded-md bg-accent px-4 py-2.5 text-sm font-semibold text-primary-700 transition hover:bg-accent/90 sm:px-6"', false);
    $response->assertSee('class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4"', false);
    $response->assertSee('id="prevSlide" class="absolute left-2 top-1/2 inline-flex min-h-[44px] min-w-[44px] -translate-y-1/2 items-center justify-center rounded-full bg-neutral/85 px-3 py-2 text-primary-700 shadow transition hover:bg-neutral sm:left-4"', false);
});

it('applies article filters and keeps query string in pagination links', function (): void {
    $taxCategory = Category::factory()->create([
        'name' => 'Pajak',
        'slug' => 'pajak',
    ]);
    $otherCategory = Category::factory()->create([
        'name' => 'Audit',
        'slug' => 'audit',
    ]);

    $taxTag = Tag::factory()->create([
        'name' => 'PPh',
        'slug' => 'pph',
    ]);
    $otherTag = Tag::factory()->create([
        'name' => 'PPN',
        'slug' => 'ppn',
    ]);

    $matchingArticles = Article::factory()->count(7)->published()->create([
        'category_id' => $taxCategory->id,
        'is_published' => true,
        'is_highlighted' => false,
        'published_at' => Carbon::parse('2026-01-12 10:00:00'),
        'title' => 'Pajak penghasilan badan',
        'excerpt' => 'Strategi pajak perusahaan',
    ]);

    foreach ($matchingArticles as $index => $article) {
        $article->update([
            'title' => 'Pajak penghasilan badan '.($index + 1),
            'slug' => 'pajak-penghasilan-badan-'.($index + 1).'-'.Str::lower(Str::random(5)),
            'published_at' => Carbon::parse('2026-01-12 10:00:00')->subMinutes($index),
        ]);

        $article->tags()->sync([$taxTag->id]);
    }

    $wrongSearchArticle = Article::factory()->published()->create([
        'category_id' => $taxCategory->id,
        'title' => 'Administrasi perusahaan',
        'slug' => 'administrasi-perusahaan',
        'is_published' => true,
        'published_at' => Carbon::parse('2026-01-11 10:00:00'),
    ]);
    $wrongSearchArticle->tags()->sync([$taxTag->id]);

    $wrongCategoryArticle = Article::factory()->published()->create([
        'category_id' => $otherCategory->id,
        'title' => 'Pajak audit khusus',
        'slug' => 'pajak-audit-khusus',
        'is_published' => true,
        'published_at' => Carbon::parse('2026-01-11 09:00:00'),
    ]);
    $wrongCategoryArticle->tags()->sync([$taxTag->id]);

    $wrongTagArticle = Article::factory()->published()->create([
        'category_id' => $taxCategory->id,
        'title' => 'Pajak tanpa tag tepat',
        'slug' => 'pajak-tanpa-tag-tepat',
        'is_published' => true,
        'published_at' => Carbon::parse('2026-01-11 08:00:00'),
    ]);
    $wrongTagArticle->tags()->sync([$otherTag->id]);

    $query = [
        'search' => 'Pajak',
        'category' => $taxCategory->slug,
        'tag' => $taxTag->slug,
    ];

    $response = get('/artikel?'.http_build_query($query));

    $response->assertOk();
    $response->assertSeeText('Pajak penghasilan badan 1');
    $response->assertDontSeeText('Administrasi perusahaan');
    $response->assertDontSeeText('Pajak audit khusus');
    $response->assertDontSeeText('Pajak tanpa tag tepat');

    $escapedPattern = '/href="(?=[^"]*page=2)(?=[^"]*search=Pajak)(?=[^"]*category='.
        preg_quote($taxCategory->slug, '/').')(?=[^"]*tag='.preg_quote($taxTag->slug, '/').')[^"]*"/';

    expect($response->getContent())->toMatch($escapedPattern);
});

it('uses whatsapp quick action when configured and mailto fallback when whatsapp is absent', function (): void {
    $siteSetting = app(SiteSetting::class);
    $siteSetting->social_whatsapp = '+62 812-3456-7890';
    $siteSetting->company_email = 'support@atiga.test';
    $siteSetting->save();

    $whatsappResponse = get('/kontak');

    $whatsappResponse->assertOk();
    $whatsappResponse->assertSee('https://wa.me/6281234567890');
    $whatsappResponse->assertSeeText('Chat WhatsApp');
    $whatsappResponse->assertSee('class="bg-gradient-to-br from-primary-700 to-primary-600 py-12 md:py-24"', false);
    $whatsappResponse->assertSee('class="text-2xl font-extrabold text-white text-balance sm:text-3xl md:text-5xl"', false);
    $whatsappResponse->assertSee('class="grid gap-6 overflow-x-clip lg:grid-cols-2 lg:gap-8"', false);
    $whatsappResponse->assertSee('class="rounded-2xl bg-white p-4 shadow-lg sm:p-6 md:p-8"', false);
    $whatsappResponse->assertSee('class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-primary-700 placeholder-slate-400 focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20 sm:px-4 sm:py-3"', false);
    $whatsappResponse->assertSee('class="overflow-x-clip py-12 sm:py-16" data-faq-accordion', false);
    $whatsappResponse->assertSee('class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-slate-50 sm:px-5 sm:py-4"', false);

    $siteSetting = app(SiteSetting::class);
    $siteSetting->social_whatsapp = null;
    $siteSetting->company_email = 'fallback@atiga.test';
    $siteSetting->save();

    $mailtoResponse = get('/kontak');

    $mailtoResponse->assertOk();
    $mailtoResponse->assertSee('mailto:fallback@atiga.test');
    $mailtoResponse->assertSeeText('Kirim Email');
});

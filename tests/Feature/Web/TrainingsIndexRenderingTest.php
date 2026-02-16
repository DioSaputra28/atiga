<?php

use App\Models\Training;

use function Pest\Laravel\get;

it('renders trainings index with mobile-first responsive classes', function (): void {
    Training::factory()->upcoming()->create([
        'title' => 'Brevet Pajak A Responsif',
        'slug' => 'brevet-pajak-a-responsif',
        'status' => Training::STATUS_UPCOMING,
        'registration_link' => 'https://example.test/register/training-a',
        'is_featured' => true,
    ]);

    Training::factory()->upcoming()->create([
        'title' => 'Workshop Tax Planning',
        'slug' => 'workshop-tax-planning',
        'status' => Training::STATUS_ONGOING,
        'registration_link' => null,
    ]);

    $response = get('/training');

    $response->assertOk();
    $response->assertSee('Pelatihan & Sertifikasi', false);
    $response->assertSeeText('Brevet Pajak A Responsif');
    $response->assertSee('class="relative mx-auto max-w-7xl px-3 py-12 sm:px-4 sm:py-16 md:py-24 lg:py-28"', false);
    $response->assertSee('class="mb-4 text-3xl font-extrabold leading-tight text-white sm:mb-6 sm:text-4xl md:text-5xl lg:text-6xl"', false);
    $response->assertSee('class="grid grid-cols-1 items-start gap-6 sm:gap-8 md:grid-cols-2 lg:grid-cols-3"', false);
    $response->assertSee('class="training-card group flex min-w-0 flex-col overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm sm:rounded-2xl"', false);
    $response->assertSee('class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-6 py-2.5 text-base font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg sm:w-auto sm:px-8 sm:py-4 sm:text-lg"', false);
    $response->assertSee('class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl border-2 border-white/30 px-6 py-2.5 text-base font-semibold text-white transition-all hover:bg-white/10 sm:w-auto sm:px-8 sm:py-4 sm:text-lg"', false);
});

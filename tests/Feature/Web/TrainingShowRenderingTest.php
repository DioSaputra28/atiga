<?php

use App\Models\Training;

use function Pest\Laravel\get;

it('renders training show with 320px-safe responsive classes', function (): void {
    $training = Training::factory()->upcoming()->create([
        'title' => 'Pelatihan Responsif Detail',
        'slug' => 'pelatihan-responsif-detail',
        'status' => Training::STATUS_ONGOING,
        'location' => 'Ruang Pelatihan Atiga',
        'registration_link' => 'https://example.test/register/pelatihan-responsif-detail',
    ]);

    $response = get('/training/'.$training->slug);

    $response->assertOk();
    $response->assertSeeText('Pelatihan Responsif Detail');
    $response->assertSee('class="bg-slate-50 py-10 sm:py-12 md:py-16"', false);
    $response->assertSee('class="mx-auto max-w-5xl px-3 sm:px-4"', false);
    $response->assertSee('class="mb-5 flex flex-wrap items-center gap-x-2 gap-y-1.5 text-xs text-slate-500 sm:mb-6 sm:text-sm"', false);
    $response->assertSee('class="h-48 w-full object-cover sm:h-64 md:h-80"', false);
    $response->assertSee('class="p-4 sm:p-6 md:p-8"', false);
    $response->assertSee('class="mb-3 break-words text-xl font-extrabold leading-tight text-primary-700 sm:mb-4 sm:text-2xl md:text-3xl"', false);
    $response->assertSee('class="grid grid-cols-1 gap-2.5 rounded-xl bg-slate-50 p-3 text-xs text-slate-600 sm:gap-3 sm:p-4 sm:text-sm md:grid-cols-2"', false);
    $response->assertSee('class="flex min-w-0 items-start gap-2"', false);
    $response->assertSee('class="whitespace-pre-line break-words text-sm leading-7 text-slate-600 sm:text-base sm:leading-8"', false);
    $response->assertSee('class="mt-6 flex flex-wrap gap-2.5 sm:mt-8 sm:gap-3"', false);
    $response->assertSee('class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-primary-700 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary-600 sm:w-auto sm:px-5 sm:py-3"', false);
    $response->assertSee('class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 sm:w-auto sm:px-5 sm:py-3"', false);
});

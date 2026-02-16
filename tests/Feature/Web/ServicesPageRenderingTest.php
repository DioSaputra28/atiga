<?php

use App\Models\ServicesPage;

use function Pest\Laravel\get;

function seedServicesPageSingleton(array $overrides = []): ServicesPage
{
    $defaults = [
        'hero_badge' => 'Solusi Pajak Strategis',
        'hero_title' => 'Layanan Konsultasi Pajak',
        'hero_highlight' => 'Profesional',
        'hero_description' => 'Pendampingan pajak terukur untuk kebutuhan bisnis yang terus berkembang.',
        'main_services_json' => [
            [
                'id' => '01',
                'icon' => 'fa-solid fa-briefcase',
                'title' => 'Layanan Pajak Korporasi',
                'description' => 'Solusi perpajakan komprehensif untuk perusahaan.',
                'features' => [
                    'Perencanaan pajak tahunan',
                    'Penyusunan SPT Badan',
                ],
            ],
        ],
        'is_published' => true,
    ];

    return ServicesPage::query()->updateOrCreate(
        ['id' => 1],
        array_merge($defaults, $overrides)
    );
}

it('renders published singleton hero and at least one main service title', function (): void {
    $servicesPage = seedServicesPageSingleton([
        'hero_title' => 'Layanan Pajak Modern',
        'hero_highlight' => 'Untuk Bisnis',
        'hero_description' => 'Deskripsi dinamis layanan pajak untuk perusahaan berkembang.',
        'main_services_json' => [
            [
                'id' => '01',
                'icon' => 'fa-solid fa-users',
                'title' => 'Optimalisasi Pajak Korporasi',
                'description' => 'Strategi efisien dan patuh regulasi.',
                'features' => ['Analisis risiko', 'Pendampingan pelaporan'],
            ],
        ],
    ]);

    expect($servicesPage->id)->toBe(1);

    $response = get('/layanan');

    $response->assertOk();
    $response->assertSeeText('Layanan Pajak Modern');
    $response->assertSeeText('Untuk Bisnis');
    $response->assertSeeText('Deskripsi dinamis layanan pajak untuk perusahaan berkembang.');
    $response->assertSeeText('Optimalisasi Pajak Korporasi');
    $response->assertSee('text-3xl font-extrabold leading-tight text-white sm:mb-6 sm:text-4xl md:text-5xl lg:text-6xl', false);
    $response->assertSee('max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base md:text-lg', false);
    $response->assertSee('grid gap-4 sm:gap-6 lg:grid-cols-2 lg:gap-8', false);
    $response->assertSee('service-card min-w-0 rounded-xl bg-white p-4 shadow-sm sm:rounded-2xl sm:p-6 lg:p-8', false);
    $response->assertSee('service-icon flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-700 to-primary-600 text-white sm:h-14 sm:w-14 sm:rounded-2xl lg:h-16 lg:w-16', false);
    $response->assertSee('inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-accent px-6 py-2.5 text-base font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg sm:w-auto sm:px-8 sm:py-4 sm:text-lg', false);
    $response->assertSee('inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl border-2 border-white/30 px-6 py-2.5 text-base font-semibold text-white transition-all hover:bg-white/10 sm:w-auto sm:px-8 sm:py-4 sm:text-lg', false);
});

it('returns 404 when the services singleton is missing', function (): void {
    get('/layanan')->assertNotFound();
});

it('returns 404 when the services singleton exists but is unpublished', function (): void {
    $servicesPage = seedServicesPageSingleton([
        'is_published' => false,
    ]);

    expect($servicesPage->id)->toBe(1)
        ->and($servicesPage->is_published)->toBeFalse();

    get('/layanan')->assertNotFound();
});

it('hides hero badge when hero_badge is null', function (): void {
    $servicesPage = seedServicesPageSingleton([
        'hero_badge' => null,
        'hero_title' => 'Layanan Tanpa Badge',
    ]);

    expect($servicesPage->id)->toBe(1)
        ->and($servicesPage->hero_badge)->toBeNull();

    $response = get('/layanan');

    $response->assertOk();
    $response->assertDontSeeText('Solusi Pajak Strategis');
    $response->assertSeeText('Layanan Tanpa Badge');
});

it('renders hero title without highlight span when hero_highlight is null', function (): void {
    $servicesPage = seedServicesPageSingleton([
        'hero_title' => 'Judul Hero Tanpa Sorotan',
        'hero_highlight' => null,
    ]);

    expect($servicesPage->id)->toBe(1)
        ->and($servicesPage->hero_highlight)->toBeNull();

    $response = get('/layanan');

    $response->assertOk();
    $response->assertSeeText('Judul Hero Tanpa Sorotan');
    expect($response->getContent())->toMatch('/<h1[^>]*>(?:(?!<span).)*Judul Hero Tanpa Sorotan(?:(?!<span).)*<\/h1>/s');
});

it('keeps rendering when main_services_json contains malformed items', function (): void {
    $servicesPage = seedServicesPageSingleton([
        'main_services_json' => [
            [
                'id' => 'malformed-only-id',
            ],
            [
                'id' => '02',
                'icon' => 'fa-solid fa-file-contract',
                'title' => 'Layanan Valid Tetap Tampil',
                'description' => 'Item valid harus tetap dirender meski ada item malformed.',
                'features' => ['Pemeriksaan dokumen', 'Pendampingan klarifikasi'],
            ],
        ],
    ]);

    expect($servicesPage->id)->toBe(1);

    $response = get('/layanan');

    $response->assertOk();
    $response->assertSeeText('Layanan Valid Tetap Tampil');
});

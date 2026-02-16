<?php

use App\Models\AboutPage;

use function Pest\Laravel\get;

function seedAboutPageSingleton(array $overrides = []): AboutPage
{
    $defaults = [
        'hero_title' => 'Tentang Atiga',
        'hero_subtitle' => 'Profil Atiga Dynamic',
        'intro_text' => 'Atiga mendampingi kebutuhan perpajakan perusahaan secara strategis.',
        'stats_json' => [
            [
                'label' => 'Klien Enterprise',
                'value' => '120',
                'suffix' => '+',
            ],
        ],
        'vision_json' => [
            ['text' => 'Visi Strategis'],
        ],
        'mission_json' => [
            ['text' => 'Misi Strategis'],
        ],
        'core_values_json' => [
            [
                'icon' => 'handshake',
                'title' => 'Kolaborasi',
                'description' => 'Kami membangun kemitraan jangka panjang yang saling menguatkan.',
            ],
        ],
        'cta_title' => 'Mulai dengan Tim Atiga',
        'cta_description' => 'Diskusikan strategi perpajakan yang paling tepat untuk bisnis Anda.',
        'cta_label' => 'Mulai Konsultasi',
        'cta_url' => '/kontak',
        'is_published' => true,
    ];

    return AboutPage::query()->updateOrCreate(
        ['id' => 1],
        array_merge($defaults, $overrides)
    );
}

it('renders the published about singleton content', function (): void {
    $aboutPage = seedAboutPageSingleton([
        'vision_json' => [
            ['text' => 'Visi Strategis'],
            ['text' => ' '],
            ['text' => 'Visi Terukur'],
        ],
    ]);

    expect($aboutPage->id)->toBe(1);

    $response = get('/tentang-kami');

    $response->assertOk();
    $response->assertSeeText('Tentang Atiga');
    $response->assertSeeText('Profil Atiga Dynamic');
    $response->assertSeeText('Klien Enterprise');
    $response->assertSeeText('Visi Strategis');
    $response->assertSeeText('Visi Terukur');
    $response->assertSeeText('Misi Strategis');
    $response->assertSeeText('Mulai Konsultasi');
});

it('returns 404 when the about singleton is missing', function (): void {
    get('/tentang-kami')->assertNotFound();
});

it('returns 404 when the about singleton exists but is unpublished', function (): void {
    $aboutPage = seedAboutPageSingleton([
        'is_published' => false,
    ]);

    expect($aboutPage->id)->toBe(1)
        ->and($aboutPage->is_published)->toBeFalse();

    get('/tentang-kami')->assertNotFound();
});

it('hides the core values section when core_values_json is empty', function (): void {
    $aboutPage = seedAboutPageSingleton([
        'core_values_json' => [],
    ]);

    expect($aboutPage->id)->toBe(1)
        ->and($aboutPage->core_values_json)->toBeEmpty();

    $response = get('/tentang-kami');

    $response->assertOk();
    $response->assertDontSeeText('Nilai-Nilai Kami');
    $response->assertDontSeeText('Prinsip yang Memandu');
});

it('renders core values cards with clamp and wrapping utilities', function (): void {
    seedAboutPageSingleton([
        'core_values_json' => [
            [
                'icon' => 'fa-handshake',
                'title' => str_repeat('A', 80),
                'description' => str_repeat('B', 220),
            ],
        ],
    ]);

    $response = get('/tentang-kami');

    $response->assertOk();
    $response->assertSee('line-clamp-2', false);
    $response->assertSee('line-clamp-4', false);
    $response->assertSee('wrap-break-word', false);
});

it('renders hero heading with responsive classes', function (): void {
    seedAboutPageSingleton();

    $response = get('/tentang-kami');

    $response->assertOk();
    $response->assertSee('text-3xl', false);
    $response->assertSee('sm:text-4xl', false);
    $response->assertSee('md:text-5xl', false);
    $response->assertSee('lg:text-6xl', false);
});

it('renders stats grid and cards with responsive classes', function (): void {
    seedAboutPageSingleton();

    $response = get('/tentang-kami');

    $response->assertOk();
    $response->assertSee('grid-cols-1', false);
    $response->assertSee('sm:grid-cols-2', false);
    $response->assertSee('lg:grid-cols-4', false);
    $response->assertSee('sm:gap-6', false);
    $response->assertSee('sm:p-8', false);
});

it('renders CTA buttons with responsive and touch-target classes', function (): void {
    seedAboutPageSingleton();

    $response = get('/tentang-kami');

    $response->assertOk();
    $response->assertSee('min-h-[44px]', false);
    $response->assertSee('sm:px-8', false);
    $response->assertSee('sm:py-4', false);
    $response->assertSee('sm:text-lg', false);
});

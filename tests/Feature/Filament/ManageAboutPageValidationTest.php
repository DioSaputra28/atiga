<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('validates stats_json items when label is missing', function (): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['stats_json'] = [
        [
            'value' => '10+',
            'suffix' => 'Klien',
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.stats_json.0.label' => ['required'],
        ]);
});

it('validates mission_json items when text is missing', function (): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['mission_json'] = [
        [],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.mission_json.0.text' => ['required'],
        ]);
});

it('validates vision_json items when text is missing', function (): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['vision_json'] = [
        [],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.vision_json.0.text' => ['required'],
        ]);
});

it('shows a friendly validation message when cta_url is not absolute or root-relative', function (string $invalidCtaUrl): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['cta_url'] = $invalidCtaUrl;

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.cta_url',
        ])
        ->assertSee('Gunakan URL yang valid');
})->with([
    'plain string is rejected' => 'konsultasi-sekarang',
    'unsafe scheme is rejected' => 'javascript:alert(1)',
]);

it('allows authenticated users to open the manage about page', function (): void {
    actingAs(createNonAdminUser());

    get('/admin/about-page')->assertOk();
});

it('validates core values cannot exceed 4 items', function (): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['core_values_json'] = [
        [
            'icon' => 'fa-handshake',
            'title' => 'Kolaborasi',
            'description' => 'Bersama klien sebagai mitra.',
        ],
        [
            'icon' => 'fa-shield-halved',
            'title' => 'Keamanan',
            'description' => 'Menjaga data dan kepatuhan.',
        ],
        [
            'icon' => 'fa-users',
            'title' => 'Kerja Tim',
            'description' => 'Sinergi internal yang kuat.',
        ],
        [
            'icon' => 'fa-chart-line',
            'title' => 'Pertumbuhan',
            'description' => 'Fokus pada dampak berkelanjutan.',
        ],
        [
            'icon' => 'fa-lightbulb',
            'title' => 'Inovasi',
            'description' => 'Solusi adaptif untuk perubahan regulasi.',
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.core_values_json' => ['max'],
        ]);
});

it('validates core value title maximum length with friendly message', function (): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['core_values_json'] = [
        [
            'icon' => 'fa-handshake',
            'title' => str_repeat('A', 81),
            'description' => 'Kolaborasi untuk hasil terbaik.',
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.core_values_json.0.title' => ['max'],
        ])
        ->assertSee('Judul nilai inti maksimal 80 karakter.');
});

it('validates core value description maximum length with friendly message', function (): void {
    actingAs(createAboutPageAdmin());

    $data = validAboutPageData();
    $data['core_values_json'] = [
        [
            'icon' => 'fa-handshake',
            'title' => 'Kolaborasi',
            'description' => str_repeat('A', 221),
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageAboutPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.core_values_json.0.description' => ['max'],
        ])
        ->assertSee('Deskripsi nilai inti maksimal 220 karakter.');
});

function createAboutPageAdmin(): User
{
    return User::factory()->create([
        'email' => 'admin@konsultanpajak.com',
    ]);
}

function createNonAdminUser(): User
{
    return User::factory()->create([
        'email' => 'staff@example.test',
    ]);
}

function validAboutPageData(): array
{
    return [
        'hero_title' => 'Tentang Atiga',
        'hero_subtitle' => 'Konsultan pajak bisnis',
        'intro_text' => 'Kami membantu bisnis bertumbuh.',
        'stats_json' => [
            [
                'label' => 'Klien',
                'value' => '10+',
                'suffix' => null,
            ],
        ],
        'vision_json' => [
            [
                'text' => 'Menjadi mitra utama kepatuhan pajak.',
            ],
        ],
        'mission_json' => [
            [
                'text' => 'Memberikan konsultasi yang akurat.',
            ],
        ],
        'core_values_json' => [],
        'cta_title' => 'Diskusikan kebutuhan pajak Anda',
        'cta_description' => 'Jadwalkan sesi konsultasi sekarang.',
        'cta_label' => 'Mulai Konsultasi',
        'cta_url' => '/kontak',
        'is_published' => true,
    ];
}

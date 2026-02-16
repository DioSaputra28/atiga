<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('validates main services items when title is missing', function (): void {
    actingAs(createServicesPageAdmin());

    $data = validServicesPageData();
    $data['main_services_json'] = [
        [
            'id' => '01',
            'icon' => 'fa-solid fa-briefcase',
            'description' => 'Deskripsi layanan tanpa judul.',
            'features' => [
                'Fitur A',
            ],
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageServicesPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.main_services_json.0.title' => ['required'],
        ]);
});

it('validates main services items when description is missing', function (): void {
    actingAs(createServicesPageAdmin());

    $data = validServicesPageData();
    $data['main_services_json'] = [
        [
            'id' => '01',
            'icon' => 'fa-solid fa-briefcase',
            'title' => 'Layanan Tanpa Deskripsi',
            'features' => [
                'Fitur A',
            ],
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageServicesPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.main_services_json.0.description' => ['required'],
        ]);
});

it('validates main services features items when value is missing', function (): void {
    actingAs(createServicesPageAdmin());

    $data = validServicesPageData();
    $data['main_services_json'] = [
        [
            'id' => '01',
            'icon' => 'fa-solid fa-briefcase',
            'title' => 'Layanan Dengan Fitur Kosong',
            'description' => 'Deskripsi layanan dengan fitur kosong.',
            'features' => [
                '',
            ],
        ],
    ];

    Livewire::test('App\\Filament\\Pages\\ManageServicesPage')
        ->set('data', $data)
        ->call('save')
        ->assertHasErrors([
            'data.main_services_json.0.features.0' => ['required'],
        ]);
});

it('allows admin user to open the manage services page', function (): void {
    $user = createServicesPageAdmin();

    actingAs($user, 'web');

    get('/admin/services-page')->assertOk();
});

it('allows authenticated user to open the manage services page', function (): void {
    $user = createServicesPageNonAdminUser();

    actingAs($user);

    get('/admin/services-page')->assertOk();
});

function createServicesPageAdmin(): User
{
    return User::query()->firstOrCreate(
        ['email' => 'admin@konsultanpajak.com'],
        [
            'name' => 'Admin Konsultan',
            'password' => bcrypt('password'),
        ]
    );
}

function createServicesPageNonAdminUser(): User
{
    return User::factory()->create([
        'email' => 'staff@example.test',
    ]);
}

function validServicesPageData(): array
{
    return [
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
}

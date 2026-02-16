<?php

use App\Models\Activity;

use function Pest\Laravel\get;

it('renders activities index with mobile-first responsive classes', function (): void {
    Activity::factory()->featured()->create([
        'title' => 'Aktivitas Responsif 320px',
        'slug' => 'aktivitas-responsif-320px',
        'description' => 'Dokumentasi kegiatan dengan pembaruan tata letak mobile-first agar konten tetap rapi pada layar sempit.',
        'location' => 'Gedung Serbaguna Kota Administrasi Jakarta Barat Dengan Nama Lokasi Sangat Panjang Untuk Uji Bungkus Teks',
    ]);

    Activity::factory()->create([
        'title' => 'Aktivitas Pendamping',
        'slug' => 'aktivitas-pendamping',
        'description' => 'Kegiatan tambahan untuk memastikan grid dan kartu merender lebih dari satu item.',
    ]);

    $response = get('/aktifitas');

    $response->assertOk();
    $response->assertSee('Arsip Kegiatan', false);
    $response->assertSeeText('Aktivitas Responsif 320px');
    $response->assertSee('class="relative mx-auto max-w-7xl px-3 py-12 sm:px-4 sm:py-16 md:py-20 lg:py-24"', false);
    $response->assertSee('class="mb-6 text-3xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl"', false);
    $response->assertSee('class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4 lg:gap-6"', false);
    $response->assertSee('class="rounded-xl bg-white p-4 text-center shadow-sm transition-all hover:shadow-md sm:rounded-2xl sm:p-6 lg:p-7"', false);
    $response->assertSee('class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 xl:grid-cols-3"', false);
    $response->assertSee('class="activity-card h-full min-w-0 overflow-hidden rounded-xl bg-slate-50 shadow-sm sm:rounded-2xl"', false);
    $response->assertSee('class="relative h-44 overflow-hidden sm:h-52"', false);
    $response->assertSee('class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-bold leading-4 text-primary-700 sm:px-3 sm:text-xs"', false);
    $response->assertSee('class="flex h-full min-h-[230px] min-w-0 flex-col p-4 sm:min-h-[250px] sm:p-6"', false);
    $response->assertSee('class="mb-3 line-clamp-2 min-h-[52px] break-words text-lg font-bold text-primary-700 transition group-hover:text-secondary-500 sm:min-h-[56px] sm:text-xl"', false);
    $response->assertSee('class="mb-4 line-clamp-3 min-h-[60px] break-words text-sm leading-relaxed text-slate-600 sm:min-h-[66px]"', false);
    $response->assertSee('class="min-h-[70px] min-w-0 space-y-2 text-sm text-slate-500"', false);
    $response->assertSee('class="min-w-0 break-words"', false);
});

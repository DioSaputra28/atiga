<?php

use App\Models\Activity;
use App\Models\ActivityImage;

use function Pest\Laravel\get;

it('renders activity show with 320px-safe responsive classes', function (): void {
    $activity = Activity::factory()->create([
        'title' => 'Aktivitas Responsif Detail',
        'slug' => 'aktivitas-responsif-detail',
        'description' => 'Deskripsi kegiatan dengan konten cukup panjang untuk memastikan elemen detail tetap rapi pada layar sempit.',
        'location' => 'Gedung Serbaguna Kota Administrasi Jakarta Barat Dengan Nama Lokasi Sangat Panjang Untuk Uji Bungkus Teks',
    ]);

    ActivityImage::factory()->create([
        'activity_id' => $activity->id,
        'image_path' => 'https://example.test/images/aktivitas-responsif-detail.jpg',
        'caption' => 'Dokumentasi kegiatan responsif',
        'sort_order' => 1,
    ]);

    $response = get('/aktifitas/'.$activity->slug);

    $response->assertOk();
    $response->assertSeeText('Aktivitas Responsif Detail');
    $response->assertSee('class="relative mx-auto max-w-7xl px-3 py-12 sm:px-4 sm:py-16 md:py-20"', false);
    $response->assertSee('class="mb-5 flex flex-wrap items-center gap-x-2 gap-y-1.5 text-xs text-white/70 sm:mb-6 sm:text-sm"', false);
    $response->assertSee('class="max-w-4xl break-words text-2xl font-extrabold leading-tight text-white sm:text-3xl md:text-5xl"', false);
    $response->assertSee('class="bg-slate-50 py-10 sm:py-12 md:py-16"', false);
    $response->assertSee('class="mx-auto grid max-w-7xl grid-cols-1 gap-4 px-3 sm:gap-6 sm:px-4 lg:grid-cols-3 lg:gap-8"', false);
    $response->assertSee('class="min-w-0 rounded-2xl bg-white p-4 shadow-sm sm:p-6 lg:col-span-1"', false);
    $response->assertSee('class="inline-flex min-w-0 items-start gap-2 break-words"', false);
    $response->assertSee('class="min-w-0 rounded-2xl bg-white p-4 shadow-sm sm:p-6 lg:col-span-2"', false);
    $response->assertSee('class="prose prose-slate max-w-none break-words text-sm text-slate-700 sm:text-base"', false);
    $response->assertSee('class="bg-white py-10 sm:py-12 md:py-16"', false);
    $response->assertSee('class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3"', false);
    $response->assertSee('class="h-48 w-full object-cover sm:h-56 md:h-64"', false);
});

@extends('web.layouts.app')

@section('title', $activity->title.' - Aktifitas Atiga')

@section('content')
<section class="relative overflow-hidden bg-primary-700">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-16 md:py-20">
        <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-white/70">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="transition hover:text-accent">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('activities.index') }}" class="transition hover:text-accent">Aktifitas</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-accent">Detail</span>
        </nav>

        <h1 class="max-w-4xl text-3xl font-extrabold leading-tight text-white md:text-5xl">
            {{ $activity->title }}
        </h1>
    </div>

    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 80V40C240 0 480 0 720 20C960 40 1200 60 1440 40V80H0Z" fill="#f8fafc" />
        </svg>
    </div>
</section>

<section class="bg-slate-50 py-16">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm lg:col-span-1">
            <h2 class="mb-5 text-lg font-bold text-primary-700">Informasi Kegiatan</h2>

            <div class="space-y-5 text-sm text-slate-600">
                <div>
                    <p class="mb-1 font-semibold text-primary-700">Waktu Pelaksanaan</p>
                    <p class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-accent"></i>
                        <span>{{ optional($activity->held_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </p>
                </div>

                <div>
                    <p class="mb-1 font-semibold text-primary-700">Deskripsi Lokasi</p>
                    <p class="inline-flex items-start gap-2">
                        <i class="fa-solid fa-location-dot mt-0.5 text-accent"></i>
                        <span>{{ $locationDescription }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="mb-4 text-lg font-bold text-primary-700">Deskripsi Kegiatan</h2>
            <div class="prose prose-slate max-w-none text-slate-700">
                {!! nl2br(e($activity->description)) !!}
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-primary-700 md:text-3xl">Galeri Dokumentasi</h2>
            <p class="mt-2 text-slate-600">Dokumentasi visual kegiatan yang tersimpan pada sistem.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($gallery as $image)
                <figure class="overflow-hidden rounded-xl bg-slate-100 shadow-sm">
                    <img src="{{ $image['url'] }}" alt="{{ $image['caption'] ?: $activity->title }}" class="h-56 w-full object-cover">
                    @if($image['caption'])
                        <figcaption class="border-t border-slate-200 px-4 py-3 text-sm text-slate-600">
                            {{ $image['caption'] }}
                        </figcaption>
                    @endif
                </figure>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center text-slate-500 sm:col-span-2 lg:col-span-3">
                    Belum ada gambar dokumentasi untuk aktivitas ini.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

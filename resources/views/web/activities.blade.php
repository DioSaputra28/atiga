@extends('web.layouts.app')

@section('title', 'Aktifitas - Atiga')

@push('styles')
<style>
    .activity-card {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .activity-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px -12px rgba(6, 46, 63, 0.22);
    }

    .activity-card img {
        transition: transform 0.5s ease;
    }

    .activity-card:hover img {
        transform: scale(1.04);
    }
</style>
@endpush

@section('content')
<section class="relative overflow-hidden bg-primary-700">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-20 md:py-24">
        <nav class="mb-8 flex items-center gap-2 text-sm text-white/70">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="transition hover:text-accent">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-accent">Aktifitas</span>
        </nav>

        <div class="max-w-3xl">
            <span class="mb-4 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-accent">
                Arsip Kegiatan
            </span>
            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white md:text-5xl">
                Dokumentasi <span class="text-accent">Aktifitas Atiga</span>
            </h1>
            <p class="max-w-2xl text-lg leading-relaxed text-white/85">
                Halaman ini merangkum aktivitas yang telah diselenggarakan Atiga, lengkap dengan waktu pelaksanaan,
                deskripsi kegiatan, serta dokumentasi visual.
            </p>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 80V40C240 0 480 0 720 20C960 40 1200 60 1440 40V80H0Z" fill="#f8fafc" />
        </svg>
    </div>
</section>

<section class="bg-slate-50 py-14">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($highlights as $highlight)
                <div class="rounded-2xl bg-white p-7 text-center shadow-sm transition-all hover:shadow-md">
                    <p class="text-4xl font-extrabold text-primary-700">{{ $highlight['number'] }}</p>
                    <p class="mt-2 text-sm font-medium text-slate-500">{{ $highlight['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-10 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Daftar Dokumentasi
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Riwayat <span class="text-accent">Kegiatan</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Pilih salah satu aktivitas untuk melihat detail waktu pelaksanaan, lokasi, dan galeri dokumentasi.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($activities as $activity)
                <article class="activity-card h-full overflow-hidden rounded-2xl bg-slate-50 shadow-sm">
                    <a href="{{ route('activities.show', $activity['slug']) }}" class="block h-full">
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-700/70 to-transparent"></div>
                            <div class="absolute left-4 top-4">
                                <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-primary-700">
                                    {{ $activity['is_featured'] ? 'Unggulan' : 'Aktifitas' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex h-full min-h-[250px] flex-col p-6">
                            <h3 class="mb-3 line-clamp-2 min-h-[56px] text-xl font-bold text-primary-700 transition group-hover:text-secondary-500">
                                {{ $activity['title'] }}
                            </h3>
                            <p class="mb-4 line-clamp-3 min-h-[66px] text-sm leading-relaxed text-slate-600">
                                {{ $activity['excerpt'] }}
                            </p>

                            <div class="min-h-[70px] space-y-2 text-sm text-slate-500">
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-calendar-days mt-0.5 text-accent"></i>
                                    <span>{{ optional($activity['held_at'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot mt-0.5 text-accent"></i>
                                    <span>{{ \Illuminate\Support\Str::limit($activity['location'], 50) }}</span>
                                </div>
                            </div>

                            <div class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-semibold text-secondary-500">
                                Lihat dokumentasi
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                    Belum ada aktivitas yang dapat ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

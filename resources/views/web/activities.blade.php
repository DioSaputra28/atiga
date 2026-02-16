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

    <div class="relative mx-auto max-w-7xl px-3 py-12 sm:px-4 sm:py-16 md:py-20 lg:py-24">
        <nav class="mb-6 flex items-center gap-2 text-xs text-white/70 sm:mb-8 sm:text-sm">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="transition hover:text-accent">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-accent">Aktifitas</span>
        </nav>

        <div class="max-w-3xl min-w-0">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-3 py-1 text-xs font-semibold text-accent sm:mb-4 sm:px-4 sm:text-sm">
                Arsip Kegiatan
            </span>
            <h1 class="mb-6 text-3xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl">
                Dokumentasi <span class="text-accent">Aktifitas Atiga</span>
            </h1>
            <p class="max-w-2xl text-sm leading-relaxed text-white/85 sm:text-base md:text-lg">
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

<section class="bg-slate-50 py-10 sm:py-14">
    <div class="mx-auto max-w-7xl px-3 sm:px-4">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4 lg:gap-6">
            @foreach($highlights as $highlight)
                <div class="rounded-xl bg-white p-4 text-center shadow-sm transition-all hover:shadow-md sm:rounded-2xl sm:p-6 lg:p-7">
                    <p class="break-words text-3xl font-extrabold text-primary-700 sm:text-4xl">{{ $highlight['number'] }}</p>
                    <p class="mt-2 break-words text-xs font-medium text-slate-500 sm:text-sm">{{ $highlight['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-12 sm:py-16 md:py-20">
    <div class="mx-auto max-w-7xl px-3 sm:px-4">
        <div class="mb-8 text-center sm:mb-10">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-3 py-1 text-xs font-semibold text-primary-700 sm:px-4 sm:text-sm">
                Daftar Dokumentasi
            </span>
            <h2 class="text-2xl font-extrabold text-primary-700 sm:text-3xl md:text-4xl">
                Riwayat <span class="text-accent">Kegiatan</span>
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 sm:mt-4 sm:text-base">
                Pilih salah satu aktivitas untuk melihat detail waktu pelaksanaan, lokasi, dan galeri dokumentasi.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($activities as $activity)
                <article class="activity-card h-full min-w-0 overflow-hidden rounded-xl bg-slate-50 shadow-sm sm:rounded-2xl">
                    <a href="{{ route('activities.show', $activity['slug']) }}" class="block h-full">
                        <div class="relative h-44 overflow-hidden sm:h-52">
                            <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-700/70 to-transparent"></div>
                            <div class="absolute left-4 top-4">
                                <span class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-bold leading-4 text-primary-700 sm:px-3 sm:text-xs">
                                    {{ $activity['is_featured'] ? 'Unggulan' : 'Aktifitas' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex h-full min-h-[230px] min-w-0 flex-col p-4 sm:min-h-[250px] sm:p-6">
                            <h3 class="mb-3 line-clamp-2 min-h-[52px] break-words text-lg font-bold text-primary-700 transition group-hover:text-secondary-500 sm:min-h-[56px] sm:text-xl">
                                {{ $activity['title'] }}
                            </h3>
                            <p class="mb-4 line-clamp-3 min-h-[60px] break-words text-sm leading-relaxed text-slate-600 sm:min-h-[66px]">
                                {{ $activity['excerpt'] }}
                            </p>

                            <div class="min-h-[70px] min-w-0 space-y-2 text-sm text-slate-500">
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-calendar-days mt-0.5 shrink-0 text-accent"></i>
                                    <span class="min-w-0 break-words">{{ optional($activity['held_at'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot mt-0.5 shrink-0 text-accent"></i>
                                    <span class="min-w-0 break-words">{{ \Illuminate\Support\Str::limit($activity['location'], 50) }}</span>
                                </div>
                            </div>

                            <div class="mt-auto inline-flex min-h-[44px] items-center gap-2 pt-5 text-sm font-semibold text-secondary-500 sm:pt-6">
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

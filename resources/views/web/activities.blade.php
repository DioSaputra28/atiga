@extends('web.layouts.app')

@section('title', 'Aktifitas - Atiga')

@push('styles')
<style>
    .activity-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .activity-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(6, 46, 63, 0.25);
    }
    .activity-card img {
        transition: transform 0.5s ease;
    }
    .activity-card:hover img {
        transform: scale(1.05);
    }
    .gallery-item {
        transition: all 0.4s ease;
    }
    .gallery-item:hover {
        transform: scale(1.02);
    }
    .gallery-item .overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .overlay {
        opacity: 1;
    }
    .gallery-item .content {
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .content {
        transform: translateY(0);
    }
    .type-chip {
        transition: all 0.3s ease;
    }
    .type-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(216, 174, 108, 0.3);
    }
    .status-badge-upcoming {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .status-badge-completed {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    }
</style>
@endpush

@section('content')
{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-primary-700">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4 py-20 md:py-28">
        {{-- Breadcrumb --}}
        <nav class="mb-8 flex items-center gap-2 text-sm text-white/60">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="hover:text-accent transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-accent">Aktifitas</span>
        </nav>
        
        {{-- Hero Content --}}
        <div class="max-w-3xl">
            <span class="mb-4 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-accent">
                Kegiatan & Acara
            </span>
            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                Ikuti <span class="text-accent">Kegiatan Kami</span>
            </h1>
            <p class="max-w-2xl text-lg text-white/80 leading-relaxed">
                Tingkatkan pengetahuan perpajakan Anda melalui seminar, workshop, webinar, dan pelatihan bersertifikat yang kami selenggarakan.
            </p>
        </div>
    </div>
    
    {{-- Bottom Wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 80V40C240 0 480 0 720 20C960 40 1200 60 1440 40V80H0Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- Highlights Stats --}}
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($highlights as $highlight)
            <div class="group rounded-2xl bg-white p-8 shadow-sm transition-all hover:shadow-lg text-center">
                <p class="text-4xl font-extrabold text-primary-700">{{ $highlight['number'] }}</p>
                <p class="mt-2 text-sm font-medium text-slate-500">{{ $highlight['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Type/Category Chips --}}
<section class="bg-white py-12 border-b border-slate-200">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex flex-col items-center">
            <h2 class="mb-6 text-lg font-semibold text-primary-700">Filter berdasarkan Jenis Kegiatan</h2>
            <div class="flex flex-wrap justify-center gap-3">
                <button class="type-chip rounded-full bg-primary-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md">
                    Semua Kegiatan
                </button>
                @foreach($types as $type)
                <button class="type-chip rounded-full bg-slate-100 px-6 py-2.5 text-sm font-semibold text-primary-700 hover:bg-accent hover:text-primary-700 transition">
                    {{ $type['name'] }}
                    <span class="ml-2 rounded-full bg-white/50 px-2 py-0.5 text-xs">{{ $type['count'] }}</span>
                </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Upcoming Activities --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 flex items-center justify-between">
            <div>
                <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                    Jangan Lewatkan
                </span>
                <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                    Kegiatan <span class="text-accent">Mendatang</span>
                </h2>
            </div>
            <a href="#" class="hidden text-sm font-semibold text-secondary-600 hover:text-primary-700 transition md:inline-flex md:items-center md:gap-2">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid gap-6 lg:grid-cols-2">
            @foreach($upcomingActivities as $activity)
            <div class="activity-card group overflow-hidden rounded-2xl bg-white shadow-sm">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-700/60 to-transparent"></div>
                    
                    {{-- Status Badge --}}
                    <div class="absolute left-4 top-4">
                        <span class="status-badge-upcoming rounded-full px-3 py-1 text-xs font-bold text-white shadow-lg">
                            <i class="fa-solid fa-calendar-check mr-1"></i> Akan Datang
                        </span>
                    </div>
                    
                    {{-- Type Badge --}}
                    <div class="absolute right-4 top-4">
                        <span class="rounded-full bg-accent px-3 py-1 text-xs font-bold text-primary-700 shadow-lg">
                            {{ $activity['type'] }}
                        </span>
                    </div>
                    
                    {{-- Price Badge --}}
                    <div class="absolute bottom-4 right-4">
                        <span class="rounded-lg bg-white px-3 py-1.5 text-sm font-bold text-primary-700 shadow-lg">
                            {{ $activity['price'] }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="mb-3 text-xl font-bold text-primary-700 group-hover:text-secondary-600 transition">
                        {{ $activity['title'] }}
                    </h3>
                    <p class="mb-4 text-sm text-slate-600 line-clamp-2">
                        {{ $activity['description'] }}
                    </p>
                    
                    {{-- Meta Info --}}
                    <div class="mb-4 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-calendar-days text-accent"></i>
                            <span>{{ \Carbon\Carbon::parse($activity['date'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-clock text-accent"></i>
                            <span>{{ $activity['time'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-location-dot text-accent"></i>
                            <span>{{ $activity['location'] }}</span>
                        </div>
                    </div>
                    
                    {{-- Registration Info --}}
                    <div class="mb-4 rounded-lg bg-slate-50 p-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Pendaftaran:</span>
                            <span class="font-semibold {{ $activity['registration_open'] ? 'text-green-600' : 'text-red-500' }}">
                                {{ $activity['registration_open'] ? 'Dibuka' : 'Ditutup' }}
                            </span>
                        </div>
                        @if($activity['registration_open'])
                        <div class="mt-2">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>Kuota: {{ $activity['quota'] }} peserta</span>
                                <span>{{ $activity['registered'] }} terdaftar</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-slate-200">
                                @php
                                    $percentage = min(100, ($activity['registered'] / $activity['quota']) * 100);
                                    $progressWidthClass = match (true) {
                                        $percentage >= 100 => 'w-full',
                                        $percentage >= 90 => 'w-11/12',
                                        $percentage >= 80 => 'w-10/12',
                                        $percentage >= 70 => 'w-9/12',
                                        $percentage >= 60 => 'w-8/12',
                                        $percentage >= 50 => 'w-6/12',
                                        $percentage >= 40 => 'w-5/12',
                                        $percentage >= 30 => 'w-4/12',
                                        $percentage >= 20 => 'w-3/12',
                                        $percentage >= 10 => 'w-2/12',
                                        default => 'w-1/12',
                                    };
                                @endphp
                                <div class="h-2 rounded-full bg-gradient-to-r from-accent to-orange-400 transition-all {{ $progressWidthClass }}"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Speakers Preview --}}
                    @if(!empty($activity['speakers']))
                    <div class="mb-4 flex items-center gap-2">
                        <div class="flex -space-x-2">
                            @foreach(array_slice($activity['speakers'], 0, 3) as $speaker)
                            <img src="{{ $speaker['photo'] }}" alt="{{ $speaker['name'] }}" class="h-8 w-8 rounded-full border-2 border-white object-cover">
                            @endforeach
                        </div>
                        <span class="text-xs text-slate-500">
                            {{ count($activity['speakers']) }} Pembicara
                        </span>
                    </div>
                    @endif
                    
                    {{-- CTA Button --}}
                    @if($activity['registration_open'])
                    <a href="#" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary-700 px-6 py-3 text-sm font-bold text-white transition-all hover:bg-primary-600 hover:shadow-lg">
                        <i class="fa-solid fa-ticket"></i>
                        Daftar Sekarang
                    </a>
                    @else
                    <button disabled class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-300 px-6 py-3 text-sm font-bold text-slate-500 cursor-not-allowed">
                        <i class="fa-solid fa-lock"></i>
                        Pendaftaran Ditutup
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Mobile View All Link --}}
        <div class="mt-8 text-center md:hidden">
            <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-secondary-600 hover:text-primary-700 transition">
                Lihat Semua Kegiatan <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- Past Activities Gallery --}}
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Dokumentasi
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Kegiatan <span class="text-accent">Terlaksana</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Lihat momen-momen berharga dari kegiatan-kegiatan yang telah kami selenggarakan.
            </p>
        </div>
        
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($pastActivities as $activity)
            <div class="gallery-item group relative aspect-[4/3] overflow-hidden rounded-xl cursor-pointer">
                <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}" class="h-full w-full object-cover">
                
                {{-- Overlay --}}
                <div class="overlay absolute inset-0 bg-gradient-to-t from-primary-700/95 via-primary-700/50 to-transparent"></div>
                
                {{-- Status Badge --}}
                <div class="absolute left-4 top-4">
                    <span class="status-badge-completed rounded-full px-3 py-1 text-xs font-bold text-white shadow-lg">
                        <i class="fa-solid fa-check-circle mr-1"></i> Selesai
                    </span>
                </div>
                
                {{-- Content --}}
                <div class="content absolute bottom-0 left-0 right-0 p-5">
                    <span class="inline-block rounded bg-accent px-2 py-0.5 text-xs font-bold text-primary-700 mb-2">
                        {{ $activity['type'] }}
                    </span>
                    <h3 class="text-lg font-bold text-white leading-tight mb-2">
                        {{ $activity['title'] }}
                    </h3>
                    <div class="flex items-center gap-4 text-xs text-white/70">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($activity['date'])->locale('id')->isoFormat('D MMM YYYY') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            {{ Str::limit($activity['location'], 25) }}
                        </span>
                    </div>
                    <div class="mt-3 flex items-center gap-2 text-xs text-white/80">
                        <i class="fa-solid fa-users"></i>
                        <span>{{ $activity['registered'] }} peserta hadir</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-4xl px-4 text-center">
        <div class="rounded-3xl bg-gradient-to-r from-primary-700 to-primary-600 p-10 md:p-16 relative overflow-hidden">
            {{-- Decorative Elements --}}
            <div class="absolute top-0 right-0 h-64 w-64 rounded-full bg-accent/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 rounded-full bg-secondary-500/10 blur-3xl"></div>
            
            <div class="relative">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-accent/20">
                    <i class="fa-solid fa-bell text-2xl text-accent"></i>
                </div>
                <h2 class="text-3xl font-bold text-white md:text-4xl">
                    Jangan Ketinggalan Info Kegiatan
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-white/80">
                    Jadwalkan diskusi dengan tim kami untuk memilih kegiatan yang paling relevan untuk kebutuhan tim Anda.
                </p>
                <div class="mt-8 flex justify-center">
                    <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex items-center gap-2 rounded-xl bg-accent px-8 py-3 font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg">
                        <i class="fa-solid fa-calendar-check"></i>
                        Hubungi Tim Atiga
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

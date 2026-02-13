@extends('web.layouts.app')

@section('title', 'Tentang Kami - Atiga')

@push('styles')
<style>
    .timeline-line {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 100%;
        background: linear-gradient(to bottom, #062E3F 0%, #D8AE6C 50%, #062E3F 100%);
    }
    @media (max-width: 768px) {
        .timeline-line {
            left: 24px;
        }
    }
    .value-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(6, 46, 63, 0.25);
    }
    .team-card img {
        transition: transform 0.5s ease;
    }
    .team-card:hover img {
        transform: scale(1.05);
    }
    .milestone-dot {
        box-shadow: 0 0 0 4px rgba(216, 174, 108, 0.3);
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
            <span class="text-accent">Tentang Kami</span>
        </nav>
        
        {{-- Hero Content --}}
        <div class="max-w-3xl">
            <span class="mb-4 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-accent">
                Profil Perusahaan
            </span>
            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                Membangun Kepercayaan,<br>
                <span class="text-accent">Menciptakan Nilai</span>
            </h1>
            <p class="max-w-2xl text-lg text-white/80 leading-relaxed">
                {{ $companyInfo['name'] }} telah menjadi mitra terpercaya bagi ratusan perusahaan dalam menavigasi kompleksitas perpajakan Indonesia sejak {{ $companyInfo['founded'] }}.
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

{{-- Company Stats --}}
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="group rounded-2xl bg-white p-8 shadow-sm transition-all hover:shadow-lg">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white transition-transform group-hover:scale-110">
                    <i class="fa-solid fa-calendar-days text-2xl"></i>
                </div>
                <p class="text-4xl font-extrabold text-primary-700">{{ $companyInfo['founded'] }}</p>
                <p class="mt-1 text-sm font-medium text-slate-500">Tahun Berdiri</p>
            </div>
            
            <div class="group rounded-2xl bg-white p-8 shadow-sm transition-all hover:shadow-lg">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white transition-transform group-hover:scale-110">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <p class="text-4xl font-extrabold text-primary-700">{{ $companyInfo['employees'] }}</p>
                <p class="mt-1 text-sm font-medium text-slate-500">Tim Profesional</p>
            </div>
            
            <div class="group rounded-2xl bg-white p-8 shadow-sm transition-all hover:shadow-lg">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white transition-transform group-hover:scale-110">
                    <i class="fa-solid fa-handshake text-2xl"></i>
                </div>
                <p class="text-4xl font-extrabold text-primary-700">{{ $companyInfo['clients'] }}</p>
                <p class="mt-1 text-sm font-medium text-slate-500">Klien Aktif</p>
            </div>
            
            <div class="group rounded-2xl bg-white p-8 shadow-sm transition-all hover:shadow-lg">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white transition-transform group-hover:scale-110">
                    <i class="fa-solid fa-location-dot text-2xl"></i>
                </div>
                <p class="text-4xl font-extrabold text-primary-700">{{ $companyInfo['headquarters'] }}</p>
                <p class="mt-1 text-sm font-medium text-slate-500">Kantor Pusat</p>
            </div>
        </div>
    </div>
</section>

{{-- Vision & Mission --}}
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-12 lg:grid-cols-2">
            {{-- Vision --}}
            <div class="relative">
                <div class="absolute -left-4 -top-4 h-24 w-24 rounded-full bg-accent/10"></div>
                <div class="relative rounded-2xl bg-gradient-to-br from-primary-700 to-primary-600 p-8 md:p-10">
                    <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-accent text-primary-700">
                        <i class="fa-solid fa-eye text-3xl"></i>
                    </div>
                    <h2 class="mb-4 text-2xl font-bold text-white">Visi Kami</h2>
                    <p class="text-lg leading-relaxed text-white/90">{{ $vision }}</p>
                </div>
            </div>
            
            {{-- Mission --}}
            <div class="relative">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-secondary-500/20"></div>
                <div class="relative rounded-2xl border border-slate-200 bg-slate-50 p-8 md:p-10">
                    <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-700 text-white">
                        <i class="fa-solid fa-bullseye text-3xl"></i>
                    </div>
                    <h2 class="mb-6 text-2xl font-bold text-primary-700">Misi Kami</h2>
                    <ul class="space-y-4">
                        @foreach($mission as $item)
                        <li class="flex items-start gap-3">
                            <div class="mt-1 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-accent text-primary-700">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                            <span class="text-slate-700 leading-relaxed">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Core Values --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Nilai-Nilai Kami
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Prinsip yang Memandu <span class="text-accent">Setiap Langkah</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Nilai-nilai inti kami menjadi fondasi dalam memberikan layanan terbaik dan membangun hubungan jangka panjang dengan klien.
            </p>
        </div>
        
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($values as $value)
            <div class="value-card rounded-2xl bg-white p-8 shadow-sm">
                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-700 to-primary-600 text-white">
                    <i class="fa-solid {{ $value['icon'] }} text-2xl"></i>
                </div>
                <h3 class="mb-3 text-xl font-bold text-primary-700">{{ $value['title'] }}</h3>
                <p class="text-sm leading-relaxed text-slate-600">{{ $value['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team Section --}}
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Tim Kami
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Dipimpin oleh <span class="text-accent">Profesional Berpengalaman</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Tim kami terdiri dari konsultan pajak bersertifikat dengan pengalaman luas di berbagai sektor industri.
            </p>
        </div>
        
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($team as $member)
            <div class="team-card group overflow-hidden rounded-2xl bg-white shadow-sm transition-all hover:shadow-xl">
                <div class="relative aspect-[3/4] overflow-hidden">
                    <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-700/90 via-primary-700/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-primary-700">{{ $member['name'] }}</h3>
                    <p class="mt-1 text-sm font-semibold text-accent">{{ $member['position'] }}</p>
                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $member['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Milestones Timeline --}}
<section class="relative overflow-hidden bg-primary-700 py-24">
    {{-- Background Decoration --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute left-1/4 top-0 h-64 w-64 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-64 w-64 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4">
        <div class="mb-16 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/30 px-4 py-1 text-sm font-semibold text-accent">
                Perjalanan Kami
            </span>
            <h2 class="text-3xl font-extrabold text-white md:text-4xl">
                Jejak <span class="text-accent">Pencapaian</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-white/70">
                Perjalanan {{ $companyInfo['name'] }} dari pendirian hingga menjadi salah satu konsultan pajak terdepan di Indonesia.
            </p>
        </div>
        
        <div class="relative">
            {{-- Timeline Line --}}
            <div class="timeline-line hidden md:block"></div>
            
            <div class="space-y-12">
                @foreach($milestones as $index => $milestone)
                <div class="relative flex items-center gap-8 md:gap-0 {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                    {{-- Content Side --}}
                    <div class="md:w-1/2 {{ $index % 2 == 0 ? 'md:pr-12 md:text-right' : 'md:pl-12' }}">
                        <div class="rounded-xl bg-white/10 p-6 backdrop-blur-sm {{ $index % 2 == 0 ? 'md:ml-auto' : '' }} max-w-md">
                            <span class="inline-block rounded-lg bg-accent px-3 py-1 text-lg font-bold text-primary-700">
                                {{ $milestone['year'] }}
                            </span>
                            <p class="mt-3 text-white leading-relaxed">{{ $milestone['event'] }}</p>
                        </div>
                    </div>
                    
                    {{-- Center Dot --}}
                    <div class="absolute left-6 top-1/2 z-10 hidden h-5 w-5 -translate-y-1/2 rounded-full bg-accent milestone-dot md:left-1/2 md:-translate-x-1/2 md:flex md:items-center md:justify-center">
                        <div class="h-2.5 w-2.5 rounded-full bg-primary-700"></div>
                    </div>
                    <div class="absolute left-0 top-1/2 z-10 flex h-5 w-5 -translate-y-1/2 items-center justify-center rounded-full bg-accent md:hidden">
                        <div class="h-2.5 w-2.5 rounded-full bg-primary-700"></div>
                    </div>
                    
                    {{-- Empty Side for Balance --}}
                    <div class="hidden md:block md:w-1/2"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-4xl px-4 text-center">
        <div class="rounded-3xl bg-gradient-to-r from-primary-700 to-primary-600 p-10 md:p-16">
            <h2 class="text-3xl font-bold text-white md:text-4xl">
                Siap Mengoptimalkan Kepatuhan Pajak Anda?
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-white/80">
                Hubungi tim kami untuk konsultasi gratis dan temukan solusi perpajakan yang tepat untuk bisnis Anda.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex items-center gap-2 rounded-xl bg-accent px-8 py-4 text-lg font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg">
                    <i class="fa-solid fa-phone"></i>
                    Hubungi Kami
                </a>
                <a href="{{ Route::has('services') ? route('services') : '#' }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 px-8 py-4 text-lg font-semibold text-white transition-all hover:bg-white/10">
                    Lihat Layanan
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

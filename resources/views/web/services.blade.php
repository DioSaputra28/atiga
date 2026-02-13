@extends('web.layouts.app')

@section('title', 'Layanan - Atiga')

@push('styles')
<style>
    .service-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(6, 46, 63, 0.2);
    }
    .service-card:hover .service-icon {
        transform: scale(1.1) rotate(3deg);
    }
    .service-icon {
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .process-step {
        position: relative;
    }
    .process-step::after {
        content: '';
        position: absolute;
        top: 40px;
        right: -50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, #D8AE6C, #062E3F);
    }
    .process-step:last-child::after {
        display: none;
    }
    @media (max-width: 768px) {
        .process-step::after {
            display: none;
        }
    }
    .feature-item {
        transition: all 0.3s ease;
    }
    .service-card:hover .feature-item {
        padding-left: 4px;
    }
    .additional-card {
        transition: all 0.3s ease;
    }
    .additional-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -12px rgba(6, 46, 63, 0.15);
    }
    .step-number {
        background: linear-gradient(135deg, #062E3F 0%, #0B3F46 100%);
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
            <span class="text-accent">Layanan</span>
        </nav>
        
        {{-- Hero Content --}}
        <div class="max-w-3xl">
            <span class="mb-4 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-accent">
                Solusi Perpajakan
            </span>
            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                Layanan Konsultasi<br>
                <span class="text-accent">Pajak Profesional</span>
            </h1>
            <p class="max-w-2xl text-lg text-white/80 leading-relaxed">
                Kami menyediakan layanan perpajakan komprehensif untuk individu dan korporasi, dengan pendekatan yang personal dan solusi yang terukur.
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

{{-- Main Services Grid --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Layanan Utama
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Solusi Pajak untuk <span class="text-accent">Setiap Kebutuhan</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Dari konsultasi personal hingga pendampingan pemeriksaan pajak, kami siap membantu Anda menavigasi kompleksitas perpajakan Indonesia.
            </p>
        </div>
        
        <div class="grid gap-8 lg:grid-cols-2">
            @foreach($mainServices as $service)
            <div class="service-card rounded-2xl bg-white p-8 shadow-sm">
                <div class="mb-6 flex items-start justify-between">
                    <div class="service-icon flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-700 to-primary-600 text-white">
                        <i class="fa-solid {{ $service['icon'] }} text-2xl"></i>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        #0{{ $service['id'] }}
                    </span>
                </div>
                
                <h3 class="mb-3 text-2xl font-bold text-primary-700">{{ $service['title'] }}</h3>
                <p class="mb-6 text-slate-600 leading-relaxed">{{ $service['description'] }}</p>
                
                <div class="border-t border-slate-100 pt-6">
                    <p class="mb-4 text-sm font-semibold text-primary-700">Fitur Layanan:</p>
                    <ul class="space-y-3">
                        @foreach($service['features'] as $feature)
                        <li class="feature-item flex items-start gap-3">
                            <div class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-accent/20">
                                <i class="fa-solid fa-check text-xs text-accent"></i>
                            </div>
                            <span class="text-sm text-slate-600">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Additional Services --}}
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Layanan Tambahan
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Pelayanan <span class="text-accent">Komplementer</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Layanan pendukung untuk memastikan kepatuhan pajak Anda optimal dan efisien.
            </p>
        </div>
        
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($additionalServices as $service)
            <div class="additional-card rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white transition-transform duration-300 hover:scale-110">
                    <i class="fa-solid {{ $service['icon'] }} text-xl"></i>
                </div>
                <h3 class="mb-2 text-lg font-bold text-primary-700">{{ $service['title'] }}</h3>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $service['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Process Steps --}}
<section class="bg-primary-700 py-24 relative overflow-hidden">
    {{-- Background Decoration --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute left-1/4 top-0 h-64 w-64 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-64 w-64 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4">
        <div class="mb-16 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/30 px-4 py-1 text-sm font-semibold text-accent">
                Alur Kerja
            </span>
            <h2 class="text-3xl font-extrabold text-white md:text-4xl">
                Proses <span class="text-accent">Konsultasi</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-white/70">
                Langkah-langkah sistematis kami dalam memberikan solusi perpajakan terbaik untuk Anda.
            </p>
        </div>
        
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($processSteps as $step)
            <div class="process-step relative text-center">
                <div class="step-number mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl text-2xl font-extrabold text-accent shadow-lg">
                    {{ $step['number'] }}
                </div>
                <h3 class="mb-3 text-xl font-bold text-white">{{ $step['title'] }}</h3>
                <p class="text-white/70 leading-relaxed">{{ $step['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-4xl px-4 text-center">
        <div class="rounded-3xl bg-gradient-to-r from-primary-700 to-primary-600 p-10 md:p-16">
            <h2 class="text-3xl font-bold text-white md:text-4xl">
                Butuh Solusi Pajak yang Tepat?
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-white/80">
                Jadwalkan konsultasi gratis dengan tim ahli pajak kami dan temukan strategi terbaik untuk kebutuhan Anda.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex items-center gap-2 rounded-xl bg-accent px-8 py-4 text-lg font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg">
                    <i class="fa-solid fa-calendar-check"></i>
                    Jadwalkan Konsultasi
                </a>
                <a href="{{ Route::has('home') ? route('home') : '/' }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 px-8 py-4 text-lg font-semibold text-white transition-all hover:bg-white/10">
                    Kembali ke Beranda
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

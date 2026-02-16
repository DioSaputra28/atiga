@extends('web.layouts.app')

@section('title', 'Tentang Kami - Atiga')

@push('styles')
<style>

    .value-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(6, 46, 63, 0.25);
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
                {{ $heroLabel }}
            </span>
            <h1 class="mb-6 text-3xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl lg:text-6xl">
                {{ $heroTitle }}<br>
                <span class="text-accent">{{ $heroSubtitle }}</span>
            </h1>
            <p class="max-w-2xl text-lg text-white/80 leading-relaxed">
                {{ $introText }}
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
<section class="bg-slate-50 py-12 sm:py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
            @foreach($stats as $stat)
            <div class="group rounded-2xl bg-white p-6 sm:p-8 shadow-sm transition-all hover:shadow-lg">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white transition-transform group-hover:scale-110">
                    <i class="fa-solid {{ $stat['icon'] }} text-2xl"></i>
                </div>
                <div class="flex w-full flex-wrap items-baseline gap-x-2 gap-y-1 font-extrabold text-primary-700">
                    <span class="min-w-0 break-words text-2xl sm:text-3xl lg:text-3xl">{{ $stat['value'] }}</span>
                    @if(!empty($stat['suffix']))
                        <span class="break-words text-xl sm:text-2xl lg:text-3xl">{{ $stat['suffix'] }}</span>
                    @endif
                </div>
                <p class="mt-1 text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
            </div>
            @endforeach
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
                    <h2 class="mb-4 text-2xl font-bold text-white">{{ $visionLabel }}</h2>
                    @if(! empty($visionItems))
                    <ul class="space-y-4">
                        @foreach($visionItems as $item)
                        <li class="flex items-start gap-3">
                            <div class="mt-1 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-accent text-primary-700">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                            <span class="text-lg leading-relaxed text-white/90">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @elseif(! empty($visionText))
                    <p class="text-lg leading-relaxed text-white/90">{{ $visionText }}</p>
                    @endif
                </div>
            </div>
            
            {{-- Mission --}}
            <div class="relative">
                <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-secondary-500/20"></div>
                <div class="relative rounded-2xl border border-slate-200 bg-slate-50 p-8 md:p-10">
                    <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-700 text-white">
                        <i class="fa-solid fa-bullseye text-3xl"></i>
                    </div>
                    <h2 class="mb-6 text-2xl font-bold text-primary-700">{{ $missionLabel }}</h2>
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
@if(! empty($values))
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
            <div class="value-card h-full rounded-2xl bg-white p-8 shadow-sm">
                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-700 to-primary-600 text-white">
                    <i class="fa-solid {{ $value['icon'] }} text-2xl"></i>
                </div>
                <h3 class="mb-3 min-w-0 line-clamp-2 wrap-break-word break-words text-xl font-bold text-primary-700">{{ $value['title'] }}</h3>
                <p class="min-w-0 line-clamp-4 wrap-break-word break-words text-sm leading-relaxed text-slate-600">{{ $value['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif





{{-- CTA Section --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-4xl px-4 text-center">
        <div class="rounded-3xl bg-gradient-to-r from-primary-700 to-primary-600 p-10 md:p-16">
            <h2 class="text-3xl font-bold text-white md:text-4xl">
                {{ $ctaTitle }}
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-white/80">
                {{ $ctaDescription }}
            </p>
            <div class="mt-6 sm:mt-8 flex flex-col items-center justify-center gap-3 sm:gap-4 sm:flex-row">
                <a href="{{ $ctaUrl }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3 sm:px-8 sm:py-4 text-base sm:text-lg font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg min-h-[44px]">
                    <i class="fa-solid fa-phone"></i>
                    {{ $ctaLabel }}
                </a>
                <a href="{{ Route::has('services') ? route('services') : '#' }}" class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-white/30 px-6 py-3 sm:px-8 sm:py-4 text-base sm:text-lg font-semibold text-white transition-all hover:bg-white/10 min-h-[44px]">
                    Lihat Layanan
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@php
    $companyName = site_company_name('Atiga');
    $companyLogo = site_company_logo();
    $companyLogoUrl = null;

    if (filled($companyLogo)) {
        $companyLogoUrl = str_starts_with($companyLogo, 'http://') || str_starts_with($companyLogo, 'https://')
            ? $companyLogo
            : \Illuminate\Support\Facades\Storage::url($companyLogo);
    }
@endphp

{{-- Top Info Bar --}}
<div class="w-full bg-white border-b border-slate-200">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3">
        <div class="flex items-center gap-3">
            @if ($companyLogoUrl)
                <img src="{{ $companyLogoUrl }}" alt="{{ $companyName }}" class="h-11 w-11 rounded-lg object-cover">
            @else
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary-700 text-white">
                    <i class="fa-solid fa-scale-balanced text-lg"></i>
                </div>
            @endif
            <div>
                <p class="text-xl font-extrabold tracking-tight text-primary-700">{{ $companyName }}</p>
                <p class="text-xs font-medium text-primary-600">Konsultan Pajak & Kepatuhan Bisnis</p>
            </div>
        </div>
        <div class="hidden items-center gap-2 sm:flex">
            <a class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-primary-700 transition hover:bg-secondary-500 hover:text-primary-700"
               href="#" aria-label="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-primary-700 transition hover:bg-secondary-500 hover:text-primary-700"
               href="#" aria-label="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-primary-700 transition hover:bg-secondary-500 hover:text-primary-700"
               href="#" aria-label="LinkedIn">
                <i class="fa-brands fa-linkedin-in"></i>
            </a>
            <a class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-primary-700 transition hover:bg-secondary-500 hover:text-primary-700"
               href="#" aria-label="YouTube">
                <i class="fa-brands fa-youtube"></i>
            </a>
        </div>
    </div>
</div>

@php
$homeRoute = Route::has('home') ? route('home', [], false) : '#';
$aboutRoute = Route::has('about') ? route('about', [], false) : '#';
$servicesRoute = Route::has('services') ? route('services', [], false) : '#';
$contactRoute = Route::has('contact') ? route('contact', [], false) : '#';
$articlesRoute = Route::has('articles.index') ? route('articles.index', [], false) : '#';
$trainingsRoute = Route::has('trainings.index') ? route('trainings.index', [], false) : '#';
$activitiesRoute = Route::has('activities.index') ? route('activities.index', [], false) : '#';
@endphp

{{-- Sticky Main Navigation --}}
<nav class="sticky top-0 z-20 bg-primary-700 shadow-md" id="main-nav">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 text-sm font-semibold text-white">
        {{-- Desktop Navigation --}}
        <div class="hidden items-center gap-6 md:flex">
            <a href="{{ $homeRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('home') ? 'text-secondary-500' : '' }}">
                Beranda
            </a>
            <a href="{{ $aboutRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('about') ? 'text-secondary-500' : '' }}">
                Tentang Kami
            </a>
            <a href="{{ $servicesRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('services') ? 'text-secondary-500' : '' }}">
                Layanan
            </a>
            <a href="{{ $contactRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('contact') ? 'text-secondary-500' : '' }}">
                Kontak
            </a>
            <a href="{{ $articlesRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('articles.*') ? 'text-secondary-500' : '' }}">
                Artikel
            </a>
            <a href="{{ $trainingsRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('trainings.*') ? 'text-secondary-500' : '' }}">
                Training
            </a>
            <a href="{{ $activitiesRoute }}"
               class="transition hover:text-secondary-500 {{ request()->routeIs('activities.*') ? 'text-secondary-500' : '' }}">
                Aktifitas
            </a>
        </div>

        {{-- CTA Button --}}
        <a href="{{ $contactRoute }}"
           class="hidden rounded-md border border-secondary-500 px-3 py-1.5 text-xs font-semibold text-secondary-500 transition hover:bg-secondary-500 hover:text-primary-700 md:block">
            Konsultasi Gratis
        </a>

        {{-- Mobile Menu Button --}}
        <button type="button" id="mobile-menu-toggle"
                class="inline-flex items-center justify-center rounded-md p-2 text-white hover:text-secondary-500 focus:outline-none md:hidden"
                aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation menu">
            <i class="fa-solid fa-bars text-xl" id="menu-icon-open"></i>
            <i class="fa-solid fa-xmark text-xl hidden" id="menu-icon-close"></i>
        </button>
    </div>

    {{-- Mobile Navigation Menu --}}
    <div class="hidden md:hidden" id="mobile-menu">
        <div class="border-t border-primary-600 bg-primary-700 px-4 py-3">
            <div class="flex flex-col space-y-3">
                <a href="{{ $homeRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-house mr-2 w-5"></i> Beranda
                </a>
                <a href="{{ $aboutRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('about') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-circle-info mr-2 w-5"></i> Tentang Kami
                </a>
                <a href="{{ $servicesRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('services') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-briefcase mr-2 w-5"></i> Layanan
                </a>
                <a href="{{ $contactRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('contact') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-envelope mr-2 w-5"></i> Kontak
                </a>
                <a href="{{ $articlesRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('articles.*') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-newspaper mr-2 w-5"></i> Artikel
                </a>
                <a href="{{ $trainingsRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('trainings.*') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-graduation-cap mr-2 w-5"></i> Training
                </a>
                <a href="{{ $activitiesRoute }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('activities.*') ? 'bg-primary-600 text-secondary-500' : 'text-white hover:bg-primary-600 hover:text-secondary-500' }}">
                    <i class="fa-solid fa-calendar-days mr-2 w-5"></i> Aktifitas
                </a>
                <a href="{{ $contactRoute }}"
                   class="mt-2 rounded-md border border-secondary-500 px-3 py-2 text-center text-xs font-semibold text-secondary-500 transition hover:bg-secondary-500 hover:text-primary-700">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        if (toggleBtn && mobileMenu) {
            toggleBtn.addEventListener('click', function() {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';

                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');

                if (iconOpen && iconClose) {
                    iconOpen.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                }
            });
        }
    });
</script>
@endpush

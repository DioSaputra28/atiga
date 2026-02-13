@extends('web.layouts.app')

@section('title', 'Beranda - Atiga')

@section('content')
    {{-- Hero Section --}}
    <section class="mx-auto max-w-7xl px-4 pt-6">
        <div id="slider" class="relative mx-auto h-[320px] w-full overflow-hidden rounded-2xl bg-primary-600 shadow-lg md:h-[360px]">
            @foreach($heroSlides as $index => $slide)
                <div class="slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-700/95 via-primary-700/45 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-neutral">
                        <span class="inline-flex rounded-full bg-accent px-3 py-1 text-xs font-bold uppercase tracking-wide text-primary-700">
                            Banner Promosi
                        </span>
                        <h1 class="mt-3 text-2xl font-bold leading-tight md:text-4xl">{{ $slide['title'] }}</h1>
                        <p class="mt-2 max-w-3xl text-sm text-white/80 md:text-base">{{ $slide['subtitle'] }}</p>
                        <a href="{{ $slide['cta_link'] }}" class="mt-4 inline-block rounded-md bg-accent px-6 py-2 text-sm font-semibold text-primary-700 transition hover:bg-accent/90">
                            {{ $slide['cta_text'] }}
                        </a>
                    </div>
                </div>
            @endforeach

            <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-neutral/85 px-3 py-2 text-primary-700 shadow transition hover:bg-neutral" aria-label="Slide sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-neutral/85 px-3 py-2 text-primary-700 shadow transition hover:bg-neutral" aria-label="Slide berikutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </section>

    {{-- Headline Articles Split Section --}}
    <section class="mx-auto max-w-7xl px-4 py-8">
        @php
            $headlineArticle = $articles[0] ?? null;
            $supportingArticles = array_slice($articles, 1, 2);
        @endphp

        @if($headlineArticle)
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="relative overflow-hidden rounded-2xl lg:col-span-2">
                    <img src="{{ $headlineArticle['image'] }}" alt="{{ $headlineArticle['title'] }}" class="h-[420px] w-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-700/95 via-primary-700/45 to-primary-700/10"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white md:p-8">
                        <span class="inline-flex rounded-full bg-accent px-4 py-1 text-xs font-bold uppercase tracking-wide text-primary-700">
                            {{ $headlineArticle['category'] }}
                        </span>
                        <h2 class="mt-4 max-w-3xl text-3xl font-extrabold leading-tight md:text-5xl">
                            {{ $headlineArticle['title'] }}
                        </h2>
                        <div class="mt-4 text-sm text-white/80">
                            <span><i class="fa-regular fa-calendar mr-1"></i>{{ $headlineArticle['published_at'] }}</span>
                            <span class="ml-3"><i class="fa-regular fa-user mr-1"></i>{{ $headlineArticle['author'] }}</span>
                        </div>
                        <a href="{{ \Illuminate\Support\Facades\Route::has('articles.show') ? route('articles.show', $headlineArticle['slug']) : '#' }}" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-accent px-5 py-2.5 text-sm font-bold text-primary-700 transition hover:bg-accent/90">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>

                <div class="grid gap-4">
                    @foreach($supportingArticles as $supportArticle)
                        <article class="group relative overflow-hidden rounded-2xl">
                            <img src="{{ $supportArticle['image'] }}" alt="{{ $supportArticle['title'] }}" class="h-[202px] w-full object-cover transition duration-300 group-hover:scale-105" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-700/95 via-primary-700/40 to-primary-700/10"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                <span class="inline-flex rounded-full bg-accent px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-primary-700">
                                    {{ $supportArticle['category'] }}
                                </span>
                                <h3 class="mt-3 text-2xl font-bold leading-snug">
                                    {{ $supportArticle['title'] }}
                                </h3>
                                <a href="{{ \Illuminate\Support\Facades\Route::has('articles.show') ? route('articles.show', $supportArticle['slug']) : '#' }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-accent transition hover:text-white">
                                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    {{-- Featured Cards Section --}}
    <section class="mx-auto max-w-7xl px-4 py-12">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($featuredCards as $card)
                <div class="rounded-xl bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary-700/10">
                        <i class="fa-solid {{ $card['icon'] }} text-xl text-primary-700"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-primary-700">{{ $card['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $card['description'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Main Content + Sidebar --}}
    <section class="mx-auto max-w-7xl px-4 pb-12">
        <div class="grid gap-8 lg:grid-cols-3">
            {{-- Main Content --}}
            <div class="space-y-8 lg:col-span-2">
                {{-- Articles List --}}
                <div class="space-y-6">
                    @foreach($articles as $article)
                        <article class="flex flex-col gap-4 rounded-xl bg-white p-4 shadow-sm transition hover:shadow-md sm:flex-row">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-36 w-full rounded-lg object-cover sm:w-48" />
                            <div class="flex flex-col justify-center">
                                <span class="inline-block w-fit rounded bg-primary-700/10 px-3 py-1 text-xs font-semibold text-primary-700">{{ $article['category'] }}</span>
                                <h4 class="mt-2 text-xl font-semibold text-primary-700">{{ $article['title'] }}</h4>
                                <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $article['excerpt'] }}</p>
                                <div class="mt-3 flex items-center gap-3 text-xs text-slate-500">
                                    <span><i class="fa-regular fa-calendar mr-1"></i>{{ $article['published_at'] }}</span>
                                    <span><i class="fa-regular fa-user mr-1"></i>{{ $article['author'] }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Regulations Section --}}
                <section class="rounded-xl bg-white p-6 shadow-sm">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-700 text-white">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary-700">Regulasi Pajak Terbaru</h3>
                    </div>
                    <div class="space-y-3" id="tax-accordion">
                        @foreach($regulations as $index => $regulation)
                            <div class="accordion-item overflow-hidden rounded-lg border border-slate-200">
                                <button class="accordion-trigger flex w-full items-center justify-between bg-slate-50 px-4 py-3 text-left font-semibold text-primary-700 transition hover:bg-slate-100" aria-expanded="false" aria-controls="accordion-{{ $index }}">
                                    <span class="flex items-center gap-3">
                                        <i class="fa-solid fa-file-lines text-accent"></i>
                                        {{ $regulation['code'] }}: {{ $regulation['title'] }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down transition-transform duration-200"></i>
                                </button>
                                <div id="accordion-{{ $index }}" class="accordion-content hidden bg-white px-4 py-4 text-sm text-slate-600">
                                    <p>Regulasi terbit tanggal {{ $regulation['date'] }}. Klik untuk membaca detail lengkap peraturan ini.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                {{-- Recommended Articles --}}
                <div class="rounded-xl bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center gap-2 border-b border-slate-200 pb-3">
                        <i class="fa-solid fa-star text-accent"></i>
                        <h5 class="text-lg font-bold text-primary-700">Rekomendasi Artikel</h5>
                    </div>
                    <div class="space-y-4">
                        @foreach($recommendedArticles as $recArticle)
                            <a href="{{ \Illuminate\Support\Facades\Route::has('articles.show') ? route('articles.show', $recArticle['slug']) : '#' }}" class="group block">
                                <div class="flex gap-3">
                                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-primary-700/10">
                                        <i class="fa-solid fa-newspaper text-primary-700"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-sm font-semibold text-primary-700 transition group-hover:text-secondary-600 line-clamp-2">{{ $recArticle['title'] }}</h6>
                                        <p class="mt-1 text-xs text-slate-500">{{ $recArticle['category'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Contact CTA --}}
                <div class="rounded-xl bg-gradient-to-br from-primary-700 to-primary-600 p-5 text-white">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white/20">
                        <i class="fa-solid fa-phone-volume text-xl"></i>
                    </div>
                    <h5 class="text-lg font-bold">Butuh Konsultasi?</h5>
                    <p class="mt-2 text-sm text-white/80">Tim ahli pajak kami siap membantu permasalahan perpajakan Anda.</p>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : '#' }}" class="mt-4 block w-full rounded-lg bg-accent py-2 text-center text-sm font-semibold text-primary-700 transition hover:bg-accent/90">
                        Hubungi Kami
                    </a>
                </div>
            </aside>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section class="mx-auto max-w-7xl px-4 pb-16">
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-700 text-white">
                    <i class="fa-solid fa-images"></i>
                </div>
                <h3 class="text-2xl font-bold text-primary-700">Galeri Kegiatan</h3>
            </div>
            <a href="{{ \Illuminate\Support\Facades\Route::has('activities.index') ? route('activities.index') : '#' }}" class="text-sm font-semibold text-secondary-600 transition hover:text-primary-700">
                Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($galleryItems as $item)
                <div class="group relative aspect-square overflow-hidden rounded-xl">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-110" />
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-700/80 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                    <div class="absolute bottom-0 left-0 right-0 translate-y-full p-4 transition duration-300 group-hover:translate-y-0">
                        <p class="text-sm font-semibold text-white">{{ $item['title'] }}</p>
                        <p class="text-xs text-white/70">{{ $item['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Hero Slider
    const slides = document.querySelectorAll('.slide');
    const nextBtn = document.getElementById('nextSlide');
    const prevBtn = document.getElementById('prevSlide');
    let activeIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-0', i !== index);
            slide.classList.toggle('opacity-100', i === index);
        });
    }

    function nextSlide() {
        activeIndex = (activeIndex + 1) % slides.length;
        showSlide(activeIndex);
    }

    function prevSlide() {
        activeIndex = (activeIndex - 1 + slides.length) % slides.length;
        showSlide(activeIndex);
    }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    // Auto-advance every 6 seconds
    setInterval(nextSlide, 6000);
    
    // Initialize
    showSlide(activeIndex);

    // Tax Regulations Accordion
    const accordionTriggers = document.querySelectorAll('.accordion-trigger');
    accordionTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            const content = document.getElementById(this.getAttribute('aria-controls'));
            const icon = this.querySelector('.fa-chevron-down');
            
            this.setAttribute('aria-expanded', !isExpanded);
            
            if (isExpanded) {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            } else {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
</script>
@endpush

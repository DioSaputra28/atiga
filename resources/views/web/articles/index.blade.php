@extends('web.layouts.app')

@section('title', 'Artikel & Insight - Atiga')

@push('styles')
<style>
    .article-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -12px rgba(6, 46, 63, 0.2);
    }
    .article-card:hover .article-image {
        transform: scale(1.05);
    }
    .article-image {
        transition: transform 0.5s ease;
    }
    .featured-card {
        transition: all 0.4s ease;
    }
    .featured-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px -12px rgba(6, 46, 63, 0.3);
    }
    .featured-card:hover .featured-image {
        transform: scale(1.08);
    }
    .featured-image {
        transition: transform 0.6s ease;
    }
    .category-item {
        transition: all 0.2s ease;
    }
    .category-item:hover {
        background-color: #f1f5f9;
        padding-left: 0.75rem;
    }
    .tag-pill {
        transition: all 0.2s ease;
    }
    .tag-pill:hover {
        background-color: #062E3F;
        color: #D8AE6C;
    }
</style>
@endpush

@section('content')
{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-700 to-primary-600">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-3 py-12 sm:px-4 sm:py-16 md:py-24">
        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-1.5 text-xs text-white/60 sm:mb-8 sm:gap-2 sm:text-sm">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="hover:text-accent transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-accent">Artikel & Insight</span>
        </nav>
        
        {{-- Hero Content --}}
        <div class="max-w-3xl">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-3 py-1 text-xs font-semibold text-accent sm:mb-4 sm:px-4 sm:text-sm">
                <i class="fa-solid fa-newspaper mr-2"></i>Update Terkini
            </span>
            <h1 class="mb-4 text-3xl font-extrabold leading-tight text-white sm:mb-6 sm:text-4xl md:text-5xl lg:text-6xl">
                Artikel & <span class="text-accent">Insight</span>
            </h1>
            <p class="max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base md:text-lg">
                Temukan artikel, analisis, dan insight terbaru seputar perpajakan di Indonesia. Dapatkan pemahaman mendalam tentang regulasi, strategi tax planning, dan tips kepatuhan pajak.
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

{{-- Main Content --}}
<section class="bg-slate-50 py-10 sm:py-12 md:py-16">
    <div class="mx-auto max-w-7xl px-3 sm:px-4">
        <div class="grid gap-6 lg:gap-8 lg:grid-cols-3">
            {{-- Main Content Area --}}
            <div class="space-y-6 lg:col-span-2 sm:space-y-8">
                {{-- Featured Article --}}
                @if(isset($featuredArticle))
                <div class="featured-card group relative overflow-hidden rounded-xl bg-white shadow-lg sm:rounded-2xl">
                    <div class="relative aspect-[4/3] overflow-hidden sm:aspect-[21/9] md:aspect-[21/8]">
                        <img src="{{ $featuredArticle['image'] }}" alt="{{ $featuredArticle['title'] }}" class="featured-image h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-700 via-primary-700/60 to-transparent"></div>
                        
                        {{-- Featured Badge --}}
                        <div class="absolute left-3 top-3 sm:left-6 sm:top-6">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-accent px-3 py-1 text-xs font-bold text-primary-700 sm:gap-2 sm:px-4 sm:py-1.5 sm:text-sm">
                                <i class="fa-solid fa-star"></i> Artikel Unggulan
                            </span>
                        </div>
                        
                        {{-- Featured Content --}}
                        <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 md:p-8">
                            <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-white/80 sm:mb-3 sm:gap-3 sm:text-sm">
                                <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white">
                                    {{ $featuredArticle['category'] }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($featuredArticle['published_at'])->translatedFormat('d F Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $featuredArticle['read_time'] }}
                                </span>
                            </div>
                            <h2 class="mb-2 text-xl font-bold text-white sm:mb-3 sm:text-2xl md:text-3xl">
                                {{ $featuredArticle['title'] }}
                            </h2>
                            <p class="mb-3 text-sm leading-relaxed text-white/80 line-clamp-2 sm:mb-4 sm:text-base md:line-clamp-none">
                                {{ $featuredArticle['excerpt'] }}
                            </p>
                            <a href="{{ Route::has('articles.show') ? route('articles.show', $featuredArticle['slug']) : '#' }}" class="inline-flex min-h-[44px] items-center gap-2 rounded-lg bg-accent px-4 py-2.5 text-sm font-bold text-primary-700 transition hover:bg-accent/90 sm:px-5">
                                Baca Selengkapnya
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Section Header --}}
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-700 text-white sm:h-10 sm:w-10 sm:rounded-xl">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h2 class="text-lg font-bold text-primary-700 sm:text-xl md:text-2xl">Semua Artikel</h2>
                    </div>
                    <span class="text-xs text-slate-500 sm:text-sm">{{ $articles->total() }} artikel tersedia</span>
                </div>

                {{-- Articles Grid --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">
                    @foreach($articles as $article)
                    <article class="article-card group min-w-0 overflow-hidden rounded-xl bg-white shadow-sm sm:rounded-2xl">
                        {{-- Image --}}
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="article-image h-full w-full object-cover">
                            <div class="absolute left-4 top-4">
                                <span class="rounded-full bg-primary-700 px-3 py-1 text-xs font-semibold text-white">
                                    {{ $article['category'] }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Content --}}
                        <div class="p-4 sm:p-5">
                            <div class="mb-3 flex flex-wrap items-center gap-2 text-xs text-slate-500 sm:gap-3">
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($article['published_at'])->translatedFormat('d F Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $article['read_time'] }}
                                </span>
                            </div>
                            
                            <h3 class="mb-2 text-base font-bold leading-snug text-primary-700 line-clamp-2 transition group-hover:text-secondary-600 sm:text-lg">
                                {{ $article['title'] }}
                            </h3>

                            <p class="mb-3 text-sm leading-6 text-slate-600 line-clamp-2 sm:mb-4">
                                {{ $article['excerpt'] }}
                            </p>

                            {{-- Author & Link --}}
                            <div class="flex flex-col gap-2 border-t border-slate-100 pt-3 sm:flex-row sm:items-center sm:justify-between sm:pt-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $article['author']['photo'] }}" alt="{{ $article['author']['name'] }}" class="h-8 w-8 rounded-full object-cover">
                                    <span class="text-xs font-medium text-slate-600">{{ $article['author']['name'] }}</span>
                                </div>
                                <a href="{{ Route::has('articles.show') ? route('articles.show', $article['slug']) : '#' }}" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-accent transition hover:text-primary-700">
                                    Baca <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination Placeholder --}}
                <div class="pt-4">
                    {{ $articles->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-8">
                {{-- Search Box --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-primary-700">
                        <i class="fa-solid fa-magnifying-glass mr-2 text-accent"></i>Cari Artikel
                    </h3>
                    <form action="{{ Route::has('articles.index') ? route('articles.index') : '/artikel' }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Ketik kata kunci..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                        @if(filled($filters['category']))
                            <input type="hidden" name="category" value="{{ $filters['category'] }}">
                        @endif
                        @if(filled($filters['tag']))
                            <input type="hidden" name="tag" value="{{ $filters['tag'] }}">
                        @endif
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-accent p-2 text-primary-700 transition hover:bg-accent/80">
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </button>
                    </form>

                    @if(filled($filters['search']) || filled($filters['category']) || filled($filters['tag']))
                        <div class="mt-3 text-center">
                            <a href="{{ Route::has('articles.index') ? route('articles.index') : '/artikel' }}" class="inline-flex items-center gap-2 text-sm font-medium text-red-500 hover:text-red-600 transition">
                                <i class="fa-solid fa-xmark"></i> Reset Filter
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Categories --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-primary-700">
                        <i class="fa-solid fa-folder-open mr-2 text-accent"></i>Kategori
                    </h3>
                    <ul class="space-y-1">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ Route::has('articles.index') ? route('articles.index', array_filter(['search' => $filters['search'], 'category' => $category['slug'], 'tag' => $filters['tag']])) : '#' }}" class="category-item flex items-center justify-between rounded-lg px-3 py-2.5 text-sm {{ $filters['category'] === $category['slug'] ? 'bg-primary-700/5 text-primary-700' : 'text-slate-600' }}">
                                <span class="font-medium">{{ $category['name'] }}</span>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">{{ $category['count'] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Popular Tags --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-primary-700">
                        <i class="fa-solid fa-tags mr-2 text-accent"></i>Tag Populer
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags as $tag)
                        <a href="{{ Route::has('articles.index') ? route('articles.index', array_filter(['search' => $filters['search'], 'category' => $filters['category'], 'tag' => $tag['slug']])) : '#' }}" class="tag-pill rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium {{ $filters['tag'] === $tag['slug'] ? 'border-primary-700 text-primary-700' : 'text-slate-600' }}">
                            #{{ $tag['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Insight CTA --}}
                <div class="rounded-2xl bg-gradient-to-br from-primary-700 to-primary-600 p-6 text-white">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/20">
                        <i class="fa-solid fa-lightbulb text-xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold">Butuh Insight Khusus?</h3>
                    <p class="mb-4 text-sm text-white/80">
                        Tim Atiga siap membantu Anda memahami dampak regulasi terbaru untuk bisnis Anda.
                    </p>
                    <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-accent py-2.5 text-sm font-bold text-primary-700 transition hover:bg-accent/90">
                        <i class="fa-solid fa-phone"></i>
                        Konsultasi Gratis
                    </a>
                </div>

                {{-- Contact CTA --}}
                <div class="rounded-2xl border-2 border-primary-700/10 bg-primary-700/5 p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-700 text-white">
                        <i class="fa-solid fa-headset text-xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-primary-700">Butuh Konsultasi?</h3>
                    <p class="mb-4 text-sm text-slate-600">
                        Tim ahli pajak kami siap membantu permasalahan perpajakan Anda.
                    </p>
                    <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary-700 py-2.5 text-sm font-bold text-white transition hover:bg-primary-600">
                        <i class="fa-solid fa-phone"></i>
                        Hubungi Kami
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

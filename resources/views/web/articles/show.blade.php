@extends('web.layouts.app')

@section('title', $article['title'].' - Atiga')

@push('styles')
<style>
    .article-rich-content > * + * {
        margin-top: 1rem;
    }

    .article-rich-content :is(h1, h2, h3, h4, h5, h6) {
        color: #062E3F;
        font-weight: 700;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .article-rich-content p {
        line-height: 1.8;
        color: #334155;
    }

    .article-rich-content strong,
    .article-rich-content b {
        font-weight: 700;
    }

    .article-rich-content em,
    .article-rich-content i {
        font-style: italic;
    }

    .article-rich-content ul,
    .article-rich-content ol {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .article-rich-content ul {
        list-style-type: disc;
    }

    .article-rich-content ul ul {
        list-style-type: circle;
    }

    .article-rich-content ol {
        list-style-type: decimal;
    }

    .article-rich-content ol ol {
        list-style-type: lower-alpha;
    }

    .article-rich-content li {
        margin: 0.35rem 0;
        color: #334155;
    }

    .article-rich-content blockquote {
        margin: 1rem 0;
        border-left: 4px solid #D8AE6C;
        padding: 0.5rem 0 0.5rem 1rem;
        color: #475569;
        font-style: italic;
        background-color: #f8fafc;
    }

    .article-rich-content a {
        color: #2E7A94;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
</style>
@endpush

@section('content')
<section class="bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4">
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="transition hover:text-primary-700">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ Route::has('articles.index') ? route('articles.index') : '#' }}" class="transition hover:text-primary-700">Artikel</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-primary-700">Detail Artikel</span>
        </nav>

        <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
            <div class="relative h-72 md:h-96">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-primary-700/90 via-primary-700/40 to-transparent"></div>
                <div class="absolute left-6 top-6">
                    <span class="rounded-full bg-accent px-4 py-1.5 text-xs font-bold text-primary-700">{{ $article['category'] }}</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                    <h1 class="mb-3 max-w-4xl text-2xl font-extrabold text-white md:text-4xl">{{ $article['title'] }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-xs text-white/80 md:text-sm">
                        <span class="inline-flex items-center gap-2"><i class="fa-regular fa-user"></i>{{ $article['author']['name'] }}</span>
                        <span class="inline-flex items-center gap-2"><i class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($article['published_at'])->translatedFormat('d F Y') }}</span>
                        <span class="inline-flex items-center gap-2"><i class="fa-regular fa-eye"></i>{{ number_format($article['views'] ?? ($article['id'] * 321)) }} dilihat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-12">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 lg:grid-cols-3">
        <article class="lg:col-span-2">
            <div class="article-rich-content max-w-none text-slate-700">
                @forelse($article['content_blocks'] as $block)
                    @if($block['type'] === 'text')
                        <div>{!! $block['content'] !!}</div>
                    @elseif($block['type'] === 'image')
                        <figure>
                            <img src="{{ $block['src'] }}" alt="{{ $block['alt'] }}" class="w-full rounded-xl object-cover">
                            @if(filled($block['caption']))
                                <figcaption>{{ $block['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @elseif($block['type'] === 'youtube')
                        <div class="aspect-video overflow-hidden rounded-xl bg-slate-100">
                            <iframe
                                src="{{ $block['url'] }}"
                                title="{{ $block['title'] }}"
                                class="h-full w-full"
                                loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                            ></iframe>
                        </div>
                    @endif
                @empty
                    <p>Konten artikel belum tersedia.</p>
                @endforelse
            </div>

            @if(!empty($article['tags']))
                <div class="mt-8 border-t border-slate-200 pt-6">
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">Tag</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($article['tags'] as $tag)
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">#{{ $tag['name'] }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(! empty($shareLinks))
                <div class="mt-8 border-t border-slate-200 pt-6">
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">Bagikan</h3>
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach($shareLinks as $share)
                            <a href="{{ $share['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 hover:text-primary-700">
                                <i class="{{ $share['icon'] }}"></i>
                                <span>{{ $share['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-8">
                <a href="{{ Route::has('articles.index') ? route('articles.index') : '#' }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-primary-600">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Daftar Artikel
                </a>
            </div>
        </article>

        <aside class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <h3 class="mb-4 text-lg font-bold text-primary-700">Penulis</h3>
                <div class="flex items-start gap-3">
                    <img src="{{ $article['author']['photo'] }}" alt="{{ $article['author']['name'] }}" class="h-14 w-14 rounded-full object-cover">
                    <div>
                        <p class="font-semibold text-primary-700">{{ $article['author']['name'] }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $article['author']['bio'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h3 class="mb-4 text-lg font-bold text-primary-700">Artikel Terkait</h3>
                <div class="space-y-4">
                    @forelse($relatedArticles as $related)
                        <a href="{{ Route::has('articles.show') ? route('articles.show', $related['slug']) : '#' }}" class="group block">
                            <p class="text-sm font-semibold text-primary-700 transition group-hover:text-secondary-600">{{ $related['title'] }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($related['published_at'])->translatedFormat('d M Y') }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada artikel terkait untuk kategori ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl bg-primary-700 p-6 text-white">
                <h3 class="mb-2 text-lg font-bold">Perlu Konsultasi Pajak?</h3>
                <p class="mb-4 text-sm text-white/80">Diskusikan kebutuhan bisnis Anda bersama tim Atiga.</p>
                <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex items-center gap-2 rounded-xl bg-accent px-4 py-2 text-sm font-bold text-primary-700 hover:bg-accent/90">
                    <i class="fa-solid fa-phone"></i>
                    Hubungi Kami
                </a>
            </div>
        </aside>
    </div>
</section>
@endsection

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Banner;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $resolveMediaUrl = static function (?string $path): string {
            if (blank($path)) {
                return '';
            }

            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }

            return Storage::url($path);
        };

        $heroSlides = Banner::query()
            ->active()
            ->running()
            ->ofType(Banner::TYPE_HERO)
            ->ordered()
            ->get()
            ->map(function (Banner $banner) use ($resolveMediaUrl): array {
                return [
                    'id' => $banner->id,
                    'image' => $resolveMediaUrl($banner->image_path),
                    'title' => $banner->title,
                    'subtitle' => $banner->alt_text ?? 'Informasi terbaru dan penawaran layanan terbaik untuk kebutuhan perpajakan Anda.',
                    'cta_text' => 'Lihat Detail',
                    'cta_link' => $banner->link_url ?? '#',
                ];
            })
            ->filter(fn (array $slide): bool => filled($slide['image']))
            ->values()
            ->all();

        if ($heroSlides === []) {
            $heroSlides = [[
                'id' => 0,
                'image' => 'https://images.unsplash.com/photo-1560472355-536de3962603?w=1920&q=80',
                'title' => 'Konsultan Pajak Tepercaya untuk Bisnis Anda',
                'subtitle' => 'Pendampingan profesional untuk kepatuhan, perencanaan, dan optimasi perpajakan perusahaan.',
                'cta_text' => 'Hubungi Kami',
                'cta_link' => '/kontak',
            ]];
        }

        $highlightedArticles = Article::query()
            ->with(['category', 'user'])
            ->published()
            ->highlighted()
            ->latestPublished()
            ->limit(3)
            ->get();

        $headlineArticles = $highlightedArticles;

        if ($headlineArticles->count() < 3) {
            $headlineArticles = $headlineArticles
                ->concat(
                    Article::query()
                        ->with(['category', 'user'])
                        ->published()
                        ->where('is_highlighted', false)
                        ->whereNotIn('id', $headlineArticles->pluck('id'))
                        ->latestPublished()
                        ->limit(3 - $headlineArticles->count())
                        ->get()
                )
                ->values();
        }

        $headlineArticleIds = $headlineArticles->pluck('id');

        $articles = $headlineArticles
            ->map(function (Article $article) use ($resolveMediaUrl): array {
                return [
                    'id' => $article->id,
                    'slug' => $article->slug,
                    'title' => $article->title,
                    'excerpt' => $article->excerpt ?? Str::limit(strip_tags((string) $article->title), 140),
                    'image' => filled($article->thumbnail)
                        ? $resolveMediaUrl($article->thumbnail)
                        : 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&q=80',
                    'category' => $article->category?->name ?? 'Umum',
                    'published_at' => optional($article->published_at)?->format('d M Y') ?? '-',
                    'author' => $article->user?->name ?? 'Tim Redaksi',
                ];
            })
            ->all();

        $mainArticles = Article::query()
            ->with(['category', 'user'])
            ->published()
            ->whereNotIn('id', $headlineArticleIds)
            ->latestPublished()
            ->limit(6)
            ->get()
            ->map(function (Article $article) use ($resolveMediaUrl): array {
                return [
                    'id' => $article->id,
                    'slug' => $article->slug,
                    'title' => $article->title,
                    'excerpt' => $article->excerpt ?? Str::limit(strip_tags((string) $article->title), 140),
                    'image' => filled($article->thumbnail)
                        ? $resolveMediaUrl($article->thumbnail)
                        : 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&q=80',
                    'category' => $article->category?->name ?? 'Umum',
                    'published_at' => optional($article->published_at)?->format('d M Y') ?? '-',
                    'author' => $article->user?->name ?? 'Tim Redaksi',
                ];
            })
            ->all();

        $featuredArticleModels = Article::query()
            ->with('category')
            ->published()
            ->highlighted()
            ->whereNotIn('id', $headlineArticleIds)
            ->latestPublished()
            ->limit(5)
            ->get();

        if ($featuredArticleModels->count() < 5) {
            $featuredArticleModels = $featuredArticleModels
                ->concat(
                    Article::query()
                        ->with('category')
                        ->published()
                        ->where('is_highlighted', false)
                        ->whereNotIn('id', $headlineArticleIds->merge($featuredArticleModels->pluck('id'))->unique()->values())
                        ->latestPublished()
                        ->limit(5 - $featuredArticleModels->count())
                        ->get()
                )
                ->values();
        }

        $featuredArticleIds = $featuredArticleModels->pluck('id');

        $featuredCards = $featuredArticleModels
            ->map(function (Article $article): array {
                return [
                    'icon' => 'fa-newspaper',
                    'title' => $article->title,
                    'description' => $article->excerpt ?? Str::limit(strip_tags((string) $article->title), 100),
                    'category' => $article->category?->name ?? 'Umum',
                    'slug' => $article->slug,
                ];
            })
            ->all();

        $recommendedArticles = Article::query()
            ->with('category')
            ->published()
            ->whereNotIn('id', $headlineArticleIds->merge($featuredArticleIds)->unique()->values())
            ->orderByDesc('view_count')
            ->latestPublished()
            ->limit(4)
            ->get()
            ->map(function (Article $article): array {
                return [
                    'id' => $article->id,
                    'slug' => $article->slug,
                    'title' => $article->title,
                    'category' => $article->category?->name ?? 'Umum',
                    'published_at' => optional($article->published_at)?->format('d M Y') ?? '-',
                ];
            })
            ->all();

        $regulations = [
            [
                'code' => 'PMK-9/2025',
                'title' => 'Peraturan Menteri Keuangan tentang Tata Cara Pemungutan Pajak',
                'date' => '2025-01-15',
            ],
            [
                'code' => 'SE-12/2025',
                'title' => 'Surat Edaran Dirjen Pajak terkait SPT Tahunan',
                'date' => '2025-01-20',
            ],
            [
                'code' => 'UU-HPP',
                'title' => 'Undang-Undang Harmonisasi Peraturan Perpajakan',
                'date' => '2024-12-28',
            ],
            [
                'code' => 'PER-23/2024',
                'title' => 'Peraturan Direktur Jenderal Pajak tentang e-Faktur',
                'date' => '2024-12-10',
            ],
        ];

        $galleryItems = Activity::query()
            ->with('images')
            ->latest()
            ->limit(4)
            ->get()
            ->map(function (Activity $activity) use ($resolveMediaUrl): array {
                $firstImagePath = $activity->images->first()?->image_path;

                return [
                    'id' => $activity->id,
                    'image' => filled($firstImagePath)
                        ? $resolveMediaUrl($firstImagePath)
                        : 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80',
                    'title' => $activity->title,
                    'description' => Str::limit(strip_tags($activity->description), 90),
                ];
            })
            ->all();

        $youtubeCards = collect([
            site_youtube_video_url_1(),
            site_youtube_video_url_2(),
            site_youtube_video_url_3(),
            site_youtube_video_url_4(),
        ])
            ->filter(fn (?string $url): bool => filled($url) && filter_var($url, FILTER_VALIDATE_URL) !== false)
            ->values()
            ->map(function (string $url, int $index): ?array {
                $videoId = null;
                $parsed = parse_url($url);
                $fallbackTitle = 'Video YouTube '.($index + 1);

                if (! is_array($parsed)) {
                    return null;
                }

                $host = Str::lower((string) ($parsed['host'] ?? ''));

                if (str_contains($host, 'youtu.be')) {
                    $videoId = ltrim((string) ($parsed['path'] ?? ''), '/');
                }

                if ($videoId === null && str_contains($host, 'youtube.com')) {
                    parse_str((string) ($parsed['query'] ?? ''), $query);
                    $videoId = $query['v'] ?? null;
                }

                if (blank($videoId) || ! preg_match('/^[A-Za-z0-9_-]{11}$/', (string) $videoId)) {
                    return null;
                }

                $title = Cache::remember(
                    'home.youtube-title.'.md5($url),
                    now()->addHours(12),
                    static function () use ($url, $fallbackTitle): string {
                        try {
                            $youtubeResponse = Http::timeout(6)
                                ->acceptJson()
                                ->get('https://www.youtube.com/oembed', [
                                    'url' => $url,
                                    'format' => 'json',
                                ]);

                            if ($youtubeResponse->successful()) {
                                $youtubeTitle = $youtubeResponse->json('title');

                                if (filled($youtubeTitle)) {
                                    return (string) $youtubeTitle;
                                }
                            }

                            $noEmbedResponse = Http::timeout(6)
                                ->acceptJson()
                                ->get('https://noembed.com/embed', [
                                    'url' => $url,
                                ]);

                            if ($noEmbedResponse->successful()) {
                                $noEmbedTitle = $noEmbedResponse->json('title');

                                if (filled($noEmbedTitle)) {
                                    return (string) $noEmbedTitle;
                                }
                            }
                        } catch (\Throwable) {
                        }

                        return $fallbackTitle;
                    }
                );

                return [
                    'title' => $title,
                    'url' => $url,
                    'thumbnail' => 'https://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg',
                ];
            })
            ->filter()
            ->values()
            ->all();

        if (view()->exists('web.home')) {
            return view('web.home', compact(
                'heroSlides',
                'featuredCards',
                'articles',
                'mainArticles',
                'recommendedArticles',
                'regulations',
                'galleryItems',
                'youtubeCards'
            ));
        }

        return view('welcome');
    }
}

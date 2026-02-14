<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'search' => trim((string) $request->string('search')->toString()),
            'category' => trim((string) $request->string('category')->toString()),
            'tag' => trim((string) $request->string('tag')->toString()),
        ];

        $articleQuery = Article::query()
            ->with(['category', 'user', 'tags'])
            ->published()
            ->latestPublished();

        if (filled($filters['search'])) {
            $articleQuery->where(function (Builder $query) use ($filters): void {
                $query->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('excerpt', 'like', '%'.$filters['search'].'%');
            });
        }

        if (filled($filters['category'])) {
            $articleQuery->whereHas('category', function (Builder $query) use ($filters): void {
                $query->where('slug', $filters['category'])
                    ->orWhere('name', $filters['category']);
            });
        }

        if (filled($filters['tag'])) {
            $articleQuery->whereHas('tags', function (Builder $query) use ($filters): void {
                $query->where('slug', $filters['tag'])
                    ->orWhere('name', $filters['tag']);
            });
        }

        $featuredModel = (clone $articleQuery)
            ->highlighted()
            ->first();

        if ($featuredModel === null) {
            $featuredModel = (clone $articleQuery)->first();
        }

        $articles = (clone $articleQuery)
            ->paginate(6)
            ->through(fn (Article $article): array => $this->transformArticleCard($article))
            ->withQueryString();

        $featuredArticle = $featuredModel !== null
            ? $this->transformArticleCard($featuredModel)
            : null;

        $categories = Category::query()
            ->select(['id', 'name', 'slug'])
            ->whereHas('articles', function (Builder $query): void {
                $query->published();
            })
            ->withCount([
                'articles as published_articles_count' => function (Builder $query): void {
                    $query->published();
                },
            ])
            ->orderBy('name')
            ->get()
            ->map(function (Category $category): array {
                return [
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'count' => (int) $category->published_articles_count,
                ];
            })
            ->all();

        $popularTags = Tag::query()
            ->select(['tags.id', 'tags.name', 'tags.slug'])
            ->whereHas('articles', function (Builder $query): void {
                $query->published();
            })
            ->withSum([
                'articles as total_views' => function (Builder $query): void {
                    $query->published();
                },
            ], 'view_count')
            ->orderByDesc('total_views')
            ->orderBy('name')
            ->limit(12)
            ->get()
            ->map(function (Tag $tag): array {
                return [
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'total_views' => (int) ($tag->total_views ?? 0),
                ];
            })
            ->all();

        return view('web.articles.index', compact(
            'articles',
            'categories',
            'popularTags',
            'featuredArticle',
            'filters'
        ));
    }

    public function show(string $slug): View
    {
        $articleModel = Article::query()
            ->with(['category', 'user', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $articleModel->incrementViewCount();
        $articleModel->refresh()->load(['category', 'user', 'tags']);

        $relatedArticles = Article::query()
            ->with('category')
            ->published()
            ->whereKeyNot($articleModel->id)
            ->when(
                $articleModel->category_id !== null,
                fn (Builder $query): Builder => $query->where('category_id', $articleModel->category_id)
            )
            ->latestPublished()
            ->limit(3)
            ->get()
            ->map(fn (Article $article): array => $this->transformArticleCard($article))
            ->all();

        $article = $this->transformArticleDetail($articleModel);
        $shareLinks = $this->buildShareLinks($article);

        return view('web.articles.show', compact(
            'article',
            'shareLinks',
            'relatedArticles'
        ));
    }

    private function transformArticleCard(Article $article): array
    {
        return [
            'id' => $article->id,
            'slug' => $article->slug,
            'title' => $article->title,
            'excerpt' => $article->excerpt ?? Str::limit(strip_tags((string) $article->title), 140),
            'image' => filled($article->thumbnail)
                ? $this->resolveMediaUrl($article->thumbnail)
                : 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1200&q=80',
            'category' => $article->category?->name ?? 'Umum',
            'published_at' => $article->published_at,
            'read_time' => $this->estimateReadTime($article->getContentBlocks()),
            'author' => [
                'name' => $article->user?->name ?? 'Tim Redaksi',
                'photo' => 'https://ui-avatars.com/api/?name='.urlencode($article->user?->name ?? 'Tim Redaksi').'&background=062e3f&color=d8ae6c',
                'bio' => 'Penulis artikel Atiga.',
            ],
            'views' => (int) $article->view_count,
            'tags' => $article->tags
                ->map(fn (Tag $tag): array => ['name' => $tag->name, 'slug' => $tag->slug])
                ->all(),
        ];
    }

    private function transformArticleDetail(Article $article): array
    {
        $transformed = $this->transformArticleCard($article);
        $transformed['content_blocks'] = $this->transformContentBlocks($article->getContentBlocks());

        return $transformed;
    }

    private function transformContentBlocks(array $blocks): array
    {
        $transformedBlocks = [];

        foreach ($blocks as $block) {
            $type = (string) ($block['type'] ?? '');

            if ($type === 'text') {
                $rawContent = (string) $this->getBlockValue($block, 'content');
                $plainText = trim(strip_tags($rawContent));

                if ($plainText !== '') {
                    $transformedBlocks[] = [
                        'type' => 'text',
                        'content' => $rawContent,
                    ];
                }

                continue;
            }

            if ($type === 'image') {
                $source = trim((string) $this->getBlockValue($block, 'src'));

                if ($source !== '') {
                    $transformedBlocks[] = [
                        'type' => 'image',
                        'src' => $this->resolveMediaUrl($source),
                        'alt' => trim(strip_tags((string) $this->getBlockValue($block, 'alt'))) ?: 'Gambar artikel',
                        'caption' => trim(strip_tags((string) $this->getBlockValue($block, 'caption'))),
                    ];
                }

                continue;
            }

            if ($type === 'youtube') {
                $url = trim((string) $this->getBlockValue($block, 'url'));
                $embedUrl = $this->toYoutubeEmbedUrl($url);

                if ($embedUrl !== null) {
                    $transformedBlocks[] = [
                        'type' => 'youtube',
                        'url' => $embedUrl,
                        'title' => trim(strip_tags((string) $this->getBlockValue($block, 'title'))) ?: 'Video YouTube',
                    ];
                }
            }
        }

        return $transformedBlocks;
    }

    private function getBlockValue(array $block, string $key): mixed
    {
        if (array_key_exists($key, $block)) {
            return $block[$key];
        }

        $data = $block['data'] ?? [];

        if (! is_array($data)) {
            return null;
        }

        return $data[$key] ?? null;
    }

    private function toYoutubeEmbedUrl(string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $parsed = parse_url($url);

        if (! is_array($parsed)) {
            return null;
        }

        $host = Str::lower((string) ($parsed['host'] ?? ''));
        $videoId = null;

        if (str_contains($host, 'youtu.be')) {
            $videoId = ltrim((string) ($parsed['path'] ?? ''), '/');
        }

        if ($videoId === null && str_contains($host, 'youtube.com')) {
            parse_str((string) ($parsed['query'] ?? ''), $query);
            $videoId = $query['v'] ?? null;

            if ($videoId === null && str_contains((string) ($parsed['path'] ?? ''), '/embed/')) {
                $videoId = Str::after((string) $parsed['path'], '/embed/');
            }
        }

        if (! is_string($videoId) || ! preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)) {
            return null;
        }

        return 'https://www.youtube.com/embed/'.$videoId;
    }

    private function estimateReadTime(array $blocks): string
    {
        $wordCount = collect($blocks)
            ->filter(fn (array $block): bool => (string) ($block['type'] ?? '') === 'text')
            ->map(function (array $block): string {
                return trim(strip_tags((string) $this->getBlockValue($block, 'content')));
            })
            ->implode(' ');

        $minutes = max(1, (int) ceil(str_word_count($wordCount) / 200));

        return $minutes.' menit';
    }

    private function resolveMediaUrl(?string $path): string
    {
        if (blank($path)) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::url($path);
    }

    private function buildShareLinks(array $article): array
    {
        $articleUrl = route('articles.show', $article['slug']);
        $encodedArticleUrl = rawurlencode($articleUrl);
        $encodedTitle = rawurlencode((string) $article['title']);

        $links = [];

        if (filled(site_social_facebook(''))) {
            $links[] = [
                'label' => 'Facebook',
                'icon' => 'fa-brands fa-facebook-f',
                'url' => 'https://www.facebook.com/sharer/sharer.php?u='.$encodedArticleUrl,
            ];
        }

        if (filled(site_social_whatsapp(''))) {
            $links[] = [
                'label' => 'WhatsApp',
                'icon' => 'fa-brands fa-whatsapp',
                'url' => 'https://api.whatsapp.com/send?text='.$encodedTitle.'%20'.$encodedArticleUrl,
            ];
        }

        if (filled(site_social_instagram(''))) {
            $links[] = [
                'label' => 'Instagram',
                'icon' => 'fa-brands fa-instagram',
                'url' => site_social_instagram(''),
            ];
        }

        if (filled(site_social_threads(''))) {
            $links[] = [
                'label' => 'Threads',
                'icon' => 'fa-brands fa-threads',
                'url' => site_social_threads(''),
            ];
        }

        if (filled(site_social_tiktok(''))) {
            $links[] = [
                'label' => 'TikTok',
                'icon' => 'fa-brands fa-tiktok',
                'url' => site_social_tiktok(''),
            ];
        }

        if (filled(site_social_youtube(''))) {
            $links[] = [
                'label' => 'YouTube',
                'icon' => 'fa-brands fa-youtube',
                'url' => site_social_youtube(''),
            ];
        }

        return $links;
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $fallbackImage = 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1200&q=80';

        $activities = Activity::query()
            ->with(['images' => static fn ($query) => $query->orderBy('sort_order')])
            ->latest()
            ->get()
            ->map(fn (Activity $activity): array => [
                'title' => $activity->title,
                'slug' => $activity->slug,
                'description' => $activity->description,
                'excerpt' => Str::limit($activity->description, 170),
                'held_at' => $activity->held_at,
                'location' => $activity->location ?: 'Lokasi kegiatan tidak dicantumkan.',
                'is_featured' => $activity->is_featured,
                'image' => $this->resolveImageUrl(
                    $activity->images->first()?->image_path,
                    $fallbackImage,
                ),
                'image_count' => $activity->images->count(),
            ])
            ->all();

        $highlights = [
            [
                'number' => (string) count($activities),
                'label' => 'Dokumentasi Kegiatan',
            ],
            [
                'number' => (string) count(array_filter($activities, static fn (array $activity): bool => $activity['is_featured'])),
                'label' => 'Kegiatan Unggulan',
            ],
            [
                'number' => (string) count(array_filter($activities, static fn (array $activity): bool => $activity['image_count'] > 0)),
                'label' => 'Kegiatan Bergaleri',
            ],
            [
                'number' => (string) (Activity::query()->max('held_at') ? Carbon::parse(Activity::query()->max('held_at'))->format('Y') : '-'),
                'label' => 'Tahun Dokumentasi Terbaru',
            ],
        ];

        return view('web.activities', compact('activities', 'highlights'));
    }

    public function show(string $slug): View
    {
        $activity = Activity::query()
            ->with(['images' => static fn ($query) => $query->orderBy('sort_order')])
            ->where('slug', $slug)
            ->firstOrFail();

        $gallery = $activity->images
            ->map(fn ($image): array => [
                'url' => $this->resolveImageUrl($image->image_path),
                'caption' => $image->caption,
            ])
            ->all();

        $locationDescription = $activity->location ?: 'Lokasi kegiatan tidak dicantumkan pada dokumentasi ini.';

        return view('web.activities.show', compact('activity', 'gallery', 'locationDescription'));
    }

    private function resolveImageUrl(?string $imagePath, ?string $fallback = null): string
    {
        if (! $imagePath) {
            return $fallback ?? '';
        }

        if (Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        if (Storage::disk('public')->exists($imagePath)) {
            return asset('storage/'.ltrim($imagePath, '/'));
        }

        if (Storage::disk('local')->exists($imagePath)) {
            Storage::disk('public')->put($imagePath, Storage::disk('local')->get($imagePath));

            return asset('storage/'.ltrim($imagePath, '/'));
        }

        return $fallback ?? '';
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrainingController extends Controller
{
    public function index(): View
    {
        $visibleStatuses = [
            Training::STATUS_UPCOMING,
            Training::STATUS_ONGOING,
        ];

        $trainings = Training::query()
            ->whereIn('status', $visibleStatuses)
            ->upcomingFirst()
            ->get()
            ->map(fn (Training $training): array => $this->mapTrainingForCard($training))
            ->values()
            ->all();

        $trainingCollection = collect($trainings);

        $stats = [
            [
                'icon' => 'fa-graduation-cap',
                'number' => $trainingCollection->count(),
                'label' => 'Program Training',
            ],
            [
                'icon' => 'fa-calendar-days',
                'number' => $trainingCollection->where('status', Training::STATUS_UPCOMING)->count(),
                'label' => 'Status Upcoming',
            ],
            [
                'icon' => 'fa-circle-play',
                'number' => $trainingCollection->where('status', Training::STATUS_ONGOING)->count(),
                'label' => 'Status Ongoing',
            ],
            [
                'icon' => 'fa-star',
                'number' => $trainingCollection->where('is_featured', true)->count(),
                'label' => 'Training Unggulan',
            ],
        ];

        $testimonials = [
            [
                'name' => 'Andi Wijaya',
                'company' => 'PT. Sukses Abadi',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80',
                'content' => 'Pelatihan Brevet Pajak di sini sangat praktis dan mudah dipahami. Instrukturnya berpengalaman dan materinya up-to-date.',
                'rating' => 5,
            ],
            [
                'name' => 'Maya Kusuma',
                'company' => 'Staff Pajak - Startup XYZ',
                'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80',
                'content' => 'Workshop Tax Planning sangat membantu saya memahami cara mengoptimalkan pajak perusahaan secara legal. Highly recommended!',
                'rating' => 5,
            ],
            [
                'name' => 'Budi Santoso',
                'company' => 'Pemilik UMKM',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80',
                'content' => 'Akhirnya saya mengerti kewajiban pajak untuk UMKM. Penjelasannya sederhana dan langsung praktik. Terima kasih!',
                'rating' => 5,
            ],
        ];

        return view('web.trainings', compact(
            'trainings',
            'stats',
            'testimonials'
        ));
    }

    public function show(string $slug): View
    {
        $training = Training::query()
            ->whereIn('status', [
                Training::STATUS_UPCOMING,
                Training::STATUS_ONGOING,
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $trainingDetail = [
            'title' => $training->title,
            'slug' => $training->slug,
            'description' => $training->description,
            'image' => $this->resolveMediaUrl($training->thumbnail, 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200&q=80'),
            'status' => $training->status,
            'price' => $training->formatted_price,
            'location' => filled($training->location) ? $training->location : 'Online / Offline',
            'instructor' => $training->instructor_name ?? 'Tim Atiga',
            'duration' => $training->start_date && $training->end_date
                ? $training->duration_in_days.' Hari'
                : '-',
            'schedule' => $training->start_date && $training->end_date
                ? $training->start_date->format('d M Y H:i').' - '.$training->end_date->format('d M Y H:i')
                : 'Jadwal menyusul',
            'registration_link' => filled($training->registration_link) ? $training->registration_link : null,
        ];

        return view('web.trainings.show', compact('trainingDetail'));
    }

    private function mapTrainingForCard(Training $training): array
    {
        $image = $this->resolveMediaUrl($training->thumbnail, 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&q=80');
        $location = $training->location !== '' ? $training->location : null;
        $excerpt = str($training->description)->limit(120, '...')->value();
        $duration = $training->start_date && $training->end_date
            ? $training->duration_in_days.' Hari'
            : '-';
        $schedule = $training->start_date && $training->end_date
            ? $training->start_date->format('d M Y').' - '.$training->end_date->format('d M Y')
            : 'Jadwal menyusul';

        return [
            'id' => $training->id,
            'slug' => $training->slug,
            'title' => $training->title,
            'description' => $excerpt !== '' ? $excerpt : 'Program pelatihan perpajakan.',
            'image' => $image,
            'duration' => $duration,
            'schedule' => $schedule,
            'price' => $training->formatted_price,
            'format' => $location ?? 'Online / Offline',
            'instructor' => $training->instructor_name ?? 'Tim Atiga',
            'status' => $training->status,
            'registration_link' => filled($training->registration_link) ? $training->registration_link : null,
            'is_featured' => $training->is_featured,
        ];
    }

    private function resolveMediaUrl(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::disk('public')->exists($path)
            ? asset('storage/'.ltrim($path, '/'))
            : $fallback;
    }
}

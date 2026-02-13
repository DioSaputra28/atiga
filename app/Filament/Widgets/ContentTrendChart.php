<?php

namespace App\Filament\Widgets;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Training;
use Filament\Widgets\ChartWidget;

class ContentTrendChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'Tren Konten 6 Bulan';

    protected ?string $description = 'Perbandingan pertumbuhan artikel, kegiatan, dan training.';

    protected ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        $labels = [];
        $articleData = [];
        $activityData = [];
        $trainingData = [];

        for ($i = 5; $i >= 0; $i--) {
            $startOfMonth = now()->subMonths($i)->startOfMonth();
            $endOfMonth = now()->subMonths($i)->endOfMonth();

            $labels[] = $startOfMonth->translatedFormat('M Y');
            $articleData[] = Article::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $activityData[] = Activity::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $trainingData[] = Training::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Artikel',
                    'data' => $articleData,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
                ],
                [
                    'label' => 'Kegiatan',
                    'data' => $activityData,
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.15)',
                ],
                [
                    'label' => 'Training',
                    'data' => $trainingData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.15)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

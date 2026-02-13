<?php

namespace App\Filament\Widgets;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Training;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Ringkasan Admin';

    protected ?string $description = 'Metrik penting untuk memantau konten dan operasional.';

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $totalArticles = Article::query()->count();
        $publishedArticles = Article::query()->where('is_published', true)->count();
        $draftArticles = $totalArticles - $publishedArticles;
        $featuredActivities = Activity::query()->where('is_featured', true)->count();
        $upcomingTrainings = Training::query()->where('status', Training::STATUS_UPCOMING)->count();
        $activeBanners = Banner::query()->where('is_active', true)->count();

        return [
            Stat::make('Total Artikel', number_format($totalArticles))
                ->description("{$publishedArticles} publish / {$draftArticles} draft")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Kegiatan Unggulan', number_format($featuredActivities))
                ->description('Kegiatan yang ditampilkan di halaman utama')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
            Stat::make('Training Upcoming', number_format($upcomingTrainings))
                ->description('Sesi training yang akan datang')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
            Stat::make('Banner Aktif', number_format($activeBanners))
                ->description('Banner yang aktif ditayangkan')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('info'),
        ];
    }
}

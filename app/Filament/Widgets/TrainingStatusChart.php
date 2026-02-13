<?php

namespace App\Filament\Widgets;

use App\Models\Training;
use Filament\Widgets\ChartWidget;

class TrainingStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected string $color = 'success';

    protected ?string $heading = 'Distribusi Status Training';

    protected ?string $description = 'Pantau sebaran status training saat ini.';

    protected ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Status Training',
                    'data' => [
                        Training::query()->where('status', Training::STATUS_UPCOMING)->count(),
                        Training::query()->where('status', Training::STATUS_ONGOING)->count(),
                        Training::query()->where('status', Training::STATUS_COMPLETED)->count(),
                        Training::query()->where('status', Training::STATUS_CANCELLED)->count(),
                    ],
                    'backgroundColor' => ['#3b82f6', '#22c55e', '#6b7280', '#ef4444'],
                ],
            ],
            'labels' => ['Upcoming', 'Ongoing', 'Completed', 'Cancelled'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

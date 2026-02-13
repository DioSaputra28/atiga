<?php

namespace App\Filament\Widgets;

use App\Models\Training;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingTrainingsTable extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Training Terdekat')
            ->description('Daftar training upcoming yang perlu dipantau admin.')
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Training::STATUS_UPCOMING => 'info',
                        Training::STATUS_ONGOING => 'success',
                        Training::STATUS_COMPLETED => 'gray',
                        Training::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultPaginationPageOption(5);
    }

    protected function getTableQuery(): Builder
    {
        return Training::query()
            ->where('status', Training::STATUS_UPCOMING)
            ->orderBy('start_date')
            ->limit(10);
    }
}

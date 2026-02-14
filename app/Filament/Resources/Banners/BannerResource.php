<?php

namespace App\Filament\Resources\Banners;

use App\Filament\Resources\Banners\Pages\ManageBanners;
use App\Models\Banner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string|UnitEnum|null $navigationGroup = 'Marketing';

    protected static ?string $recordTitleAttribute = 'Banner Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Banner')
                    ->description('Data utama dan media banner')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->helperText('Masukkan judul banner yang deskriptif dan mudah diidentifikasi'),
                        Select::make('type')
                            ->required()
                            ->default('hero')
                            ->options([
                                Banner::TYPE_HERO => 'Hero',
                                Banner::TYPE_SIDEBAR => 'Sidebar',
                                Banner::TYPE_POPUP => 'Popup',
                                Banner::TYPE_FOOTER => 'Footer',
                            ])
                            ->helperText('Tipe banner, contoh: hero, sidebar, footer, popup'),
                        FileUpload::make('image_path')
                            ->image()
                            ->disk('public')
                            ->directory('banners')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Unggah gambar banner dalam format JPG, PNG, atau WebP. Disarankan ukuran 1200x400px'),
                        TextInput::make('link_url')
                            ->url()
                            ->helperText('URL tujuan ketika banner diklik (opsional)'),
                        TextInput::make('alt_text')
                            ->helperText('Teks alternatif untuk aksesibilitas dan SEO. Deskripsikan isi gambar'),
                    ])
                    ->columns(2),
                Section::make('Pengaturan Tampil')
                    ->description('Atur urutan, status aktif, dan jadwal tayang banner')
                    ->schema([
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan banner. Angka lebih kecil muncul lebih dulu'),
                        Toggle::make('is_active')
                            ->required()
                            ->helperText('Aktifkan untuk menampilkan banner di halaman website'),
                        DateTimePicker::make('starts_at')
                            ->helperText('Tanggal dan waktu mulai menampilkan banner (opsional)'),
                        DateTimePicker::make('ends_at')
                            ->afterOrEqual('starts_at')
                            ->validationMessages([
                                'after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
                            ])
                            ->helperText('Tanggal dan waktu berakhir penampilan banner (opsional)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Banner Management')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                ImageColumn::make('image_path'),
                TextColumn::make('link_url')
                    ->searchable(),
                TextColumn::make('alt_text')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active'),
                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('click_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('view_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBanners::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

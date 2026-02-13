<?php

namespace App\Filament\Resources\Trainings\Schemas;

use App\Models\Training;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make('Informasi Utama')
                        ->description('Data dasar training')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->helperText('Masukkan judul training')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
                                    if ($get('slug') !== null && $get('slug') !== '' && $get('slug') !== Str::slug($old)) {
                                        return;
                                    }

                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Slug training sudah digunakan. Silakan gunakan slug lain.',
                                ])
                                ->helperText('Slug URL training (otomatis dari judul, bisa diubah manual)'),
                            Select::make('status')
                                ->required()
                                ->default(Training::STATUS_UPCOMING)
                                ->options([
                                    Training::STATUS_UPCOMING => 'Upcoming',
                                    Training::STATUS_ONGOING => 'Ongoing',
                                    Training::STATUS_COMPLETED => 'Completed',
                                    Training::STATUS_CANCELLED => 'Cancelled',
                                ])
                                ->helperText('Status publikasi training'),
                            Toggle::make('is_featured')
                                ->required()
                                ->default(false)
                                ->helperText('Tandai training sebagai unggulan'),
                        ])
                        ->columns(2),
                    Section::make('Jadwal Dan Lokasi')
                        ->description('Informasi waktu dan lokasi pelaksanaan')
                        ->schema([
                            DateTimePicker::make('start_date')
                                ->required()
                                ->seconds(false)
                                ->helperText('Tanggal dan waktu mulai training'),
                            DateTimePicker::make('end_date')
                                ->required()
                                ->seconds(false)
                                ->afterOrEqual('start_date')
                                ->validationMessages([
                                    'after_or_equal' => 'Waktu selesai harus sama atau setelah waktu mulai.',
                                ])
                                ->helperText('Tanggal dan waktu selesai training'),
                            TextInput::make('location')
                                ->required()
                                ->maxLength(255)
                                ->helperText('Lokasi pelaksanaan training'),
                            TextInput::make('registration_link')
                                ->url()
                                ->maxLength(255)
                                ->helperText('Link pendaftaran training (opsional)'),
                        ])
                        ->columns(2),
                ]),
                Group::make([
                    Section::make('Deskripsi Dan Pengajar')
                        ->description('Konten informasi training')
                        ->schema([
                            Textarea::make('description')
                                ->required()
                                ->columnSpanFull()
                                ->helperText('Deskripsi lengkap training'),
                            TextInput::make('instructor_name')
                                ->maxLength(255)
                                ->helperText('Nama pengajar training (opsional)'),
                        ])
                        ->columns(1),
                    Section::make('Biaya Dan Kuota')
                        ->description('Atur harga dan kapasitas peserta')
                        ->schema([
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->default(0)
                                ->prefix('Rp')
                                ->helperText('Masukkan biaya training. Isi 0 jika gratis'),
                            TextInput::make('capacity')
                                ->numeric()
                                ->minValue(1)
                                ->helperText('Kuota peserta (opsional). Minimal 1 jika diisi'),
                        ])
                        ->columns(2),
                    Section::make('Thumbnail')
                        ->description('Gambar utama training')
                        ->schema([
                            FileUpload::make('thumbnail')
                                ->image()
                                ->disk('public')
                                ->directory('trainings/thumbnails')
                                ->helperText('Unggah thumbnail training (JPG, PNG, WebP)'),
                        ]),
                ]),
            ])
            ->columns([
                'default' => 1,
                'xl' => 2,
            ]);
    }
}

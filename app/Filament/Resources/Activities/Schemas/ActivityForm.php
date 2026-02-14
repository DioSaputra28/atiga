<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make('Informasi Kegiatan')
                        ->description('Data utama kegiatan')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->helperText('Masukkan judul kegiatan')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
                                    $currentSlug = $get('slug');

                                    if ($currentSlug !== null && $currentSlug !== Str::slug($old)) {
                                        return;
                                    }

                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Slug kegiatan sudah digunakan. Silakan gunakan slug lain.',
                                ])
                                ->helperText('Slug URL untuk kegiatan (diisi otomatis dari judul)'),
                            DatePicker::make('held_at')
                                ->required()
                                ->helperText('Tanggal pelaksanaan kegiatan'),
                            TextInput::make('location')
                                ->helperText('Lokasi atau tempat pelaksanaan kegiatan'),
                        ])
                        ->columns(2),
                    Section::make('Deskripsi')
                        ->description('Ringkasan dan informasi detail kegiatan')
                        ->schema([
                            Textarea::make('description')
                                ->required()
                                ->helperText('Deskripsi lengkap tentang kegiatan')
                                ->columnSpanFull(),
                        ]),
                    Section::make('Visibilitas')
                        ->description('Pengaturan penampilan kegiatan')
                        ->schema([
                            Toggle::make('is_featured')
                                ->required()
                                ->helperText('Tampilkan kegiatan ini di halaman utama?'),
                        ]),
                ]),
                Group::make([
                    Section::make('Dokumentasi Kegiatan')
                        ->description('Kelola foto kegiatan beserta urutannya')
                        ->schema([
                            Repeater::make('images')
                                ->relationship()
                                ->helperText('Tambahkan foto dokumentasi kegiatan. Bisa lebih dari satu gambar.')
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->image()
                                        ->disk('public')
                                        ->directory('activities')
                                        ->visibility('public')
                                        ->required()
                                        ->columnSpanFull()
                                        ->helperText('Unggah gambar dokumentasi kegiatan'),
                                    TextInput::make('caption')
                                        ->helperText('Keterangan singkat untuk gambar (opsional)'),
                                    TextInput::make('sort_order')
                                        ->numeric()
                                        ->default(0)
                                        ->required()
                                        ->helperText('Urutan tampil gambar (angka kecil ditampilkan lebih dulu)'),
                                ])
                                ->orderColumn('sort_order')
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->cloneable()
                                ->defaultItems(1)
                                ->addActionLabel('Tambah Gambar')
                                ->columnSpanFull()
                                ->columns(2),
                        ]),
                ]),
            ])
            ->columns([
                'default' => 1,
                'xl' => 2,
            ]);
    }
}

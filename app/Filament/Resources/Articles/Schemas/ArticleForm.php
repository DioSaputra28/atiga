<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make('Informasi Utama')
                        ->description('Data dasar artikel untuk identitas dan penulis')
                        ->schema([
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->helperText('Pilih kategori artikel'),
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->required()
                                ->helperText('Pilih penulis artikel'),
                            TextInput::make('title')
                                ->required()
                                ->helperText('Judul artikel yang akan ditampilkan')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
                                    if ($get('slug') !== null && $get('slug') !== '' && $get('slug') !== Str::slug($old)) {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Slug sudah digunakan. Silakan gunakan slug lain.',
                                ])
                                ->helperText('URL slug untuk artikel (auto-generate dari judul)'),
                            Textarea::make('excerpt')
                                ->columnSpanFull()
                                ->helperText('Ringkasan singkat artikel'),
                        ])
                        ->columns(2),
                    Section::make('Publikasi')
                        ->description('Kontrol visibilitas dan informasi penayangan artikel')
                        ->schema([
                            Toggle::make('is_highlighted')
                                ->required()
                                ->helperText('Tandai sebagai artikel unggulan'),
                            Toggle::make('is_published')
                                ->required()
                                ->helperText('Tandai untuk mempublikasikan artikel'),
                            DateTimePicker::make('published_at')
                                ->helperText('Tanggal dan waktu publikasi artikel'),
                        ])
                        ->columns(2),
                ]),
                Group::make([
                    Section::make('Konten Dan Media')
                        ->description('Isi utama artikel dan thumbnail')
                        ->schema([
                            Builder::make('content')
                                ->label('Blok Konten')
                                ->required()
                                ->helperText('Tambahkan blok konten artikel. Pilih jenis blok: teks, gambar, atau link YouTube.')
                                ->addActionLabel('Tambah Blok Konten')
                                ->blocks([
                                    Block::make('text')
                                        ->label('Teks')
                                        ->icon('heroicon-m-document-text')
                                        ->schema([
                                            RichEditor::make('content')
                                                ->label('Konten Teks')
                                                ->required()
                                                ->helperText('Tulis isi teks artikel untuk blok ini'),
                                        ])
                                        ->columns(1),
                                    Block::make('image')
                                        ->label('Gambar')
                                        ->icon('heroicon-m-photo')
                                        ->schema([
                                            FileUpload::make('src')
                                                ->label('Gambar Konten')
                                                ->image()
                                                ->disk('public')
                                                ->directory('articles/content')
                                                ->visibility('public')
                                                ->required()
                                                ->helperText('Unggah gambar untuk konten artikel'),
                                        ])
                                        ->columns(1),
                                    Block::make('youtube')
                                        ->label('YouTube')
                                        ->icon('heroicon-m-play-circle')
                                        ->schema([
                                            TextInput::make('url')
                                                ->label('Link YouTube')
                                                ->required()
                                                ->url()
                                                ->rule('regex:/^(https?:\\/\\/)?(www\\.)?(youtube\\.com\\/watch\\?v=|youtu\\.be\\/).+/i')
                                                ->helperText('Masukkan link YouTube, contoh: https://www.youtube.com/watch?v=xxxx')
                                                ->validationMessages([
                                                    'required' => 'Link YouTube wajib diisi untuk blok YouTube.',
                                                    'url' => 'Link YouTube harus berupa URL yang valid.',
                                                    'regex' => 'Link harus berasal dari YouTube (youtube.com atau youtu.be).',
                                                ]),
                                        ])
                                        ->columns(1),
                                ])
                                ->collapsible()
                                ->columnSpanFull(),
                            FileUpload::make('thumbnail')
                                ->image()
                                ->required()
                                ->disk('public')
                                ->directory('articles/thumbnails')
                                ->visibility('public')
                                ->helperText('Unggah gambar thumbnail artikel (JPG, PNG, WebP)')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ]),
            ])
            ->columns([
                'default' => 1,
                'xl' => 2,
            ]);
    }
}

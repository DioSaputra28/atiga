<?php

namespace App\Filament\Pages;

use App\Settings\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class Setting extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string $settings = SiteSetting::class;

    protected array $previousImagePaths = [];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make('Identitas Perusahaan')
                        ->description('Pengaturan identitas brand yang akan dipakai di website.')
                        ->schema([
                            TextInput::make('company_name')
                                ->label('Nama Perusahaan')
                                ->required()
                                ->maxLength(120)
                                ->helperText('Nama brand/perusahaan yang tampil di website.'),
                            FileUpload::make('company_logo')
                                ->label('Logo Perusahaan')
                                ->image()
                                ->disk('public')
                                ->directory('settings/logo')
                                ->visibility('public')
                                ->maxSize(2048)
                                ->helperText('Upload logo utama (JPG, PNG, WebP). Maksimal 2MB.'),
                            FileUpload::make('company_favicon')
                                ->label('Favicon Website')
                                ->disk('public')
                                ->directory('settings/favicon')
                                ->visibility('public')
                                ->acceptedFileTypes([
                                    'image/png',
                                    'image/svg+xml',
                                    'image/x-icon',
                                    'image/vnd.microsoft.icon',
                                ])
                                ->maxSize(1024)
                                ->helperText('Ikon kecil browser tab (PNG/SVG/ICO). Maksimal 1MB.'),
                        ])
                        ->columns(2),

                    Section::make('Konten YouTube')
                        ->description('Data channel dan video YouTube yang akan ditampilkan di halaman home.')
                        ->schema([
                            TextInput::make('youtube_channel_name')
                                ->label('Nama Akun YouTube')
                                ->maxLength(120)
                                ->helperText('Nama channel YouTube yang ditampilkan pada section video.'),
                            TextInput::make('youtube_video_url_1')
                                ->label('Link Video YouTube #1')
                                ->url()
                                ->rules(['nullable', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i'])
                                ->validationMessages([
                                    'regex' => 'Masukkan URL YouTube yang valid (youtube.com atau youtu.be).',
                                ])
                                ->helperText('Video pertama untuk section YouTube di homepage.'),
                            TextInput::make('youtube_video_url_2')
                                ->label('Link Video YouTube #2')
                                ->url()
                                ->rules(['nullable', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i'])
                                ->validationMessages([
                                    'regex' => 'Masukkan URL YouTube yang valid (youtube.com atau youtu.be).',
                                ])
                                ->helperText('Video kedua untuk section YouTube di homepage.'),
                            TextInput::make('youtube_video_url_3')
                                ->label('Link Video YouTube #3')
                                ->url()
                                ->rules(['nullable', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i'])
                                ->validationMessages([
                                    'regex' => 'Masukkan URL YouTube yang valid (youtube.com atau youtu.be).',
                                ])
                                ->helperText('Video ketiga untuk section YouTube di homepage.'),
                            TextInput::make('youtube_video_url_4')
                                ->label('Link Video YouTube #4')
                                ->url()
                                ->rules(['nullable', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i'])
                                ->validationMessages([
                                    'regex' => 'Masukkan URL YouTube yang valid (youtube.com atau youtu.be).',
                                ])
                                ->helperText('Video keempat untuk section YouTube di homepage.'),
                        ])
                        ->columns(2),
                ]),

                Group::make([
                    Section::make('Sosial Media')
                        ->description('Link sosial media resmi perusahaan.')
                        ->schema([
                            TextInput::make('social_whatsapp')
                                ->label('WhatsApp')
                                ->url()
                                ->helperText('Contoh: https://wa.me/6281234567890'),
                            TextInput::make('social_tiktok')
                                ->label('TikTok')
                                ->url()
                                ->helperText('Link profil TikTok perusahaan.'),
                            TextInput::make('social_facebook')
                                ->label('Facebook')
                                ->url()
                                ->helperText('Link halaman Facebook perusahaan.'),
                            TextInput::make('social_instagram')
                                ->label('Instagram')
                                ->url()
                                ->helperText('Link profil Instagram perusahaan.'),
                            TextInput::make('social_threads')
                                ->label('Threads')
                                ->url()
                                ->helperText('Link akun Threads perusahaan.'),
                            TextInput::make('social_youtube')
                                ->label('YouTube')
                                ->url()
                                ->helperText('Link channel YouTube perusahaan.'),
                        ])
                        ->columns(2),

                    Section::make('Kontak Perusahaan')
                        ->description('Informasi kontak yang ditampilkan di website (footer/halaman kontak).')
                        ->schema([
                            TextInput::make('phone_number')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->maxLength(30)
                                ->helperText('Nomor telepon utama perusahaan.'),
                            TextInput::make('company_email')
                                ->label('Email Perusahaan')
                                ->email()
                                ->maxLength(120)
                                ->helperText('Email resmi untuk kontak pelanggan.'),
                            TextInput::make('company_location')
                                ->label('Lokasi Perusahaan')
                                ->maxLength(255)
                                ->helperText('Alamat kantor/perusahaan yang ditampilkan di website.'),
                            TextInput::make('operational_hours')
                                ->label('Jam Operasional')
                                ->maxLength(120)
                                ->helperText('Contoh: Senin - Jumat, 08:00 - 17:00 WIB.'),
                        ])
                        ->columns(2),
                ]),
            ])
            ->columns([
                'default' => 1,
                'xl' => 2,
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->previousImagePaths = [
            'company_logo' => $data['company_logo'] ?? null,
            'company_favicon' => $data['company_favicon'] ?? null,
        ];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach (['company_logo', 'company_favicon'] as $field) {
            $oldPath = $this->previousImagePaths[$field] ?? null;
            $newPath = $data[$field] ?? null;

            if ($oldPath === null || $oldPath === $newPath) {
                continue;
            }

            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return $data;
    }
}

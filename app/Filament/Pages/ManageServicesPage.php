<?php

namespace App\Filament\Pages;

use App\Models\ServicesPage;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Validator;
use UnitEnum;

class ManageServicesPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Management Layanan';

    protected static ?string $slug = 'services-page';

    protected string $view = 'filament.pages.manage-services-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray() ?? [
            'hero_badge' => null,
            'hero_title' => null,
            'hero_highlight' => null,
            'hero_description' => null,
            'main_services_json' => [],
            'is_published' => false,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Hero Layanan')
                            ->description('Konten utama di bagian atas halaman layanan.')
                            ->schema([
                                TextInput::make('hero_badge')
                                    ->label('Badge Hero')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Contoh: Solusi Pajak Strategis.')
                                    ->validationMessages([
                                        'required' => 'Badge hero wajib diisi agar pengunjung langsung paham fokus layanan.',
                                    ]),
                                TextInput::make('hero_title')
                                    ->label('Judul Hero')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Tuliskan judul utama layanan yang paling mudah dipahami.')
                                    ->validationMessages([
                                        'required' => 'Judul hero wajib diisi.',
                                    ]),
                                TextInput::make('hero_highlight')
                                    ->label('Highlight Hero')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Gunakan 1-3 kata penekanan, misalnya Profesional atau Terpercaya.')
                                    ->validationMessages([
                                        'required' => 'Highlight hero wajib diisi agar pesan utama lebih menonjol.',
                                    ]),
                                Textarea::make('hero_description')
                                    ->label('Deskripsi Hero')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->helperText('Jelaskan manfaat layanan secara ringkas dan ramah untuk calon klien.')
                                    ->validationMessages([
                                        'required' => 'Deskripsi hero wajib diisi.',
                                    ]),
                            ]),
                        Section::make('Layanan Utama')
                            ->description('Daftar layanan yang akan ditampilkan di halaman publik.')
                            ->schema([
                                Repeater::make('main_services_json')
                                    ->label('Item Layanan Utama')
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah Layanan Utama')
                                    ->schema([
                                        Select::make('icon')
                                            ->label('Icon Layanan')
                                            ->required()
                                            ->options([
                                                'fa-solid fa-briefcase' => 'Briefcase - layanan bisnis',
                                                'fa-solid fa-file-invoice-dollar' => 'Invoice - pajak & pelaporan',
                                                'fa-solid fa-scale-balanced' => 'Scale - sengketa & keberatan',
                                                'fa-solid fa-building' => 'Building - pajak korporasi',
                                                'fa-solid fa-user-tie' => 'User Tie - konsultasi profesional',
                                                'fa-solid fa-users' => 'Users - pendampingan tim',
                                                'fa-solid fa-chart-line' => 'Chart - strategi & optimasi',
                                                'fa-solid fa-file-contract' => 'Contract - review dokumen',
                                                'fa-solid fa-shield-halved' => 'Shield - kepatuhan & proteksi',
                                                'fa-solid fa-magnifying-glass-chart' => 'Audit - analisis mendalam',
                                            ])
                                            ->searchable()
                                            ->native(false)
                                            ->helperText('Pilih ikon. Teks setelah dash menjelaskan arti ikonnya.')
                                            ->validationMessages([
                                                'required' => 'Icon layanan wajib diisi.',
                                            ]),
                                        TextInput::make('title')
                                            ->label('Judul Layanan')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Masukkan judul layanan yang jelas dan mudah dipahami.')
                                            ->validationMessages([
                                                'required' => 'Judul layanan wajib diisi.',
                                            ]),
                                        Textarea::make('description')
                                            ->label('Deskripsi Layanan')
                                            ->required()
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->helperText('Jelaskan cakupan layanan secara singkat.')
                                            ->validationMessages([
                                                'required' => 'Deskripsi layanan wajib diisi.',
                                            ]),
                                        Repeater::make('features')
                                            ->label('Fitur Layanan')
                                            ->simple(
                                                TextInput::make('feature')
                                                    ->label('Fitur')
                                                    ->required()
                                                    ->validationMessages([
                                                        'required' => 'Setiap fitur layanan wajib diisi.',
                                                    ])
                                            )
                                            ->defaultItems(0)
                                            ->addActionLabel('Tambah Fitur')
                                            ->helperText('Isi poin-poin fitur yang didapatkan klien.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                                Toggle::make('is_published')
                                    ->label('Publikasikan halaman layanan')
                                    ->default(false),
                            ])
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data')
            ->record($this->getRecord());
    }

    public function save(): void
    {
        $normalizedData = $this->data ?? [];

        $normalizedData['main_services_json'] = collect($normalizedData['main_services_json'] ?? [])
            ->map(function (mixed $service): mixed {
                if (! is_array($service)) {
                    return $service;
                }

                unset($service['id']);

                $service['features'] = collect($service['features'] ?? [])
                    ->map(fn (mixed $feature): mixed => is_array($feature) ? ($feature['feature'] ?? null) : $feature)
                    ->all();

                return $service;
            })
            ->all();

        Validator::make(['data' => $normalizedData], [
            'data.main_services_json.*.title' => ['required'],
            'data.main_services_json.*.description' => ['required'],
            'data.main_services_json.*.features.*' => ['required'],
        ], [
            'data.main_services_json.*.title.required' => 'Judul layanan wajib diisi.',
            'data.main_services_json.*.description.required' => 'Deskripsi layanan wajib diisi.',
            'data.main_services_json.*.features.*.required' => 'Setiap fitur layanan wajib diisi.',
        ])->validate();

        $data = $this->form->getState();

        $existingRecord = ServicesPage::query()->find(1);

        ServicesPage::query()->updateOrCreate(['id' => 1], $data);

        Notification::make()
            ->success()
            ->title($existingRecord === null
                ? 'Halaman layanan berhasil dibuat.'
                : 'Perubahan halaman layanan berhasil disimpan.')
            ->send();
    }

    protected function getRecord(): ?ServicesPage
    {
        return ServicesPage::query()->find(1);
    }
}

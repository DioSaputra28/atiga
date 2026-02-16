<?php

namespace App\Filament\Pages;

use App\Models\AboutPage;
use BackedEnum;
use Closure;
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
use UnitEnum;

class ManageAboutPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $slug = 'about-page';

    protected string $view = 'filament.pages.manage-about-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray() ?? [
            'stats_json' => [],
            'vision_json' => [],
            'mission_json' => [],
            'core_values_json' => [],
            'is_published' => false,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Hero')
                            ->schema([
                                TextInput::make('hero_title')
                                    ->label('Judul Hero')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('hero_subtitle')
                                    ->label('Subjudul Hero')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('intro_text')
                                    ->label('Teks Intro')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ]),
                        Section::make('Visi & Misi')
                            ->schema([
                                Repeater::make('vision_json')
                                    ->label('Visi')
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Poin Visi')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Teks visi wajib diisi.',
                                            ]),
                                    ])
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah Poin Visi')
                                    ->columnSpanFull(),
                                Repeater::make('mission_json')
                                    ->label('Misi')
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Poin Misi')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Teks misi wajib diisi.',
                                            ]),
                                    ])
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah Poin Misi')
                                    ->columnSpanFull(),
                            ]),
                        Section::make('Statistik')
                            ->schema([
                                Repeater::make('stats_json')
                                    ->label('Data Statistik')
                                    ->helperText('Maksimal 4 statistik')
                                    ->schema([
                                        TextInput::make('label')
                                            ->label('Label')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Label statistik wajib diisi.',
                                            ]),
                                        TextInput::make('value')
                                            ->label('Nilai')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Nilai statistik wajib diisi.',
                                            ]),
                                        TextInput::make('suffix')
                                            ->label('Suffix')
                                            ->maxLength(100),
                                    ])
                                    ->defaultItems(0)
                                    ->maxItems(4)
                                    ->addActionLabel('Tambah Statistik')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                        Section::make('Core Values')
                            ->schema([
                                Repeater::make('core_values_json')
                                    ->label('Nilai Inti')
                                    ->helperText('Maksimal 4 nilai inti.')
                                    ->schema([
                                        Select::make('icon')
                                            ->label('Icon')
                                            ->required()
                                            ->options([
                                                'fa-handshake' => 'Handshake (Kejujuran)',
                                                'fa-shield-halved' => 'Shield (Keamanan)',
                                                'fa-users' => 'Users (Kolaborasi)',
                                                'fa-chart-line' => 'Chart (Pertumbuhan)',
                                                'fa-rocket' => 'Rocket (Inovasi)',
                                                'fa-lightbulb' => 'Lightbulb (Ide Kreatif)',
                                                'fa-heart' => 'Heart (Dedikasi)',
                                                'fa-star' => 'Star (Keunggulan)',
                                                'fa-award' => 'Award (Pengakuan)',
                                                'fa-trophy' => 'Trophy (Prestasi)',
                                                'fa-hand-holding-heart' => 'Hand Holding Heart (Pelayanan)',
                                                'fa-scale-balanced' => 'Scale (Keadilan)',
                                                'fa-briefcase' => 'Briefcase (Profesionalisme)',
                                                'fa-graduation-cap' => 'Graduation (Pembelajaran)',
                                                'fa-chalkboard-user' => 'Chalkboard (Pendampingan)',
                                                'fa-book-open' => 'Book (Pengetahuan)',
                                                'fa-check-circle' => 'Check Circle (Kualitas)',
                                                'fa-circle-check' => 'Circle Check (Komitmen)',
                                                'fa-flag' => 'Flag (Visi)',
                                                'fa-bullseye' => 'Bullseye (Fokus)',
                                                'fa-compass' => 'Compass (Navigasi)',
                                                'fa-gem' => 'Gem (Nilai Berharga)',
                                                'fa-hand-sparkles' => 'Hand Sparkles (Kebersihan)',
                                                'fa-seedling' => 'Seedling (Pertumbuhan Berkelanjutan)',
                                                'fa-people-group' => 'People Group (Teamwork)',
                                            ])
                                            ->validationMessages([
                                                'required' => 'Icon wajib diisi.',
                                            ]),
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(80)
                                            ->validationMessages([
                                                'required' => 'Judul nilai inti wajib diisi.',
                                                'max' => 'Judul nilai inti maksimal 80 karakter.',
                                            ]),
                                        Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->maxLength(220)
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->validationMessages([
                                                'required' => 'Deskripsi nilai inti wajib diisi.',
                                                'max' => 'Deskripsi nilai inti maksimal 220 karakter.',
                                            ]),
                                    ])
                                    ->defaultItems(0)
                                    ->maxItems(4)
                                    ->addActionLabel('Tambah Nilai Inti')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                        Section::make('Call To Action')
                            ->schema([
                                TextInput::make('cta_title')
                                    ->label('Judul CTA')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('cta_description')
                                    ->label('Deskripsi CTA')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('cta_label')
                                    ->label('Label Tombol CTA')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('cta_url')
                                    ->label('URL CTA')
                                    ->required()
                                    ->maxLength(255)
                                    ->rules([
                                        fn (): Closure => function (string $attribute, mixed $value, Closure $fail): void {
                                            $label = str_contains($attribute, 'cta_url') ? 'URL CTA' : 'URL';

                                            if (! is_string($value) || $value === '') {
                                                return;
                                            }

                                            if (str_starts_with($value, '//') || str_starts_with(strtolower($value), 'javascript:')) {
                                                $fail("Gunakan URL yang valid untuk {$label}: gunakan http://, https://, atau path yang diawali /.");

                                                return;
                                            }

                                            if (preg_match('/^https?:\/\/[^\s]+$/i', $value) === 1) {
                                                return;
                                            }

                                            if (preg_match('/^\/(?!\/)[^\s]*$/', $value) === 1) {
                                                return;
                                            }

                                            $fail("Gunakan URL yang valid untuk {$label}: gunakan http://, https://, atau path yang diawali /.");
                                        },
                                    ])
                                    ->validationMessages([
                                        'required' => 'URL CTA wajib diisi.',
                                    ])
                                    ->helperText('Gunakan URL absolut (http/https) atau path relatif root, contoh: /kontak.'),
                                Toggle::make('is_published')
                                    ->label('Publikasikan halaman About')
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
        $data = $this->form->getState();

        $record = $this->getRecord() ?? new AboutPage;
        $record->id = 1;
        $record->fill($data);
        $record->save();

        Notification::make()
            ->success()
            ->title('Perubahan halaman About berhasil disimpan.')
            ->send();
    }

    protected function getRecord(): ?AboutPage
    {
        return AboutPage::query()->find(1);
    }
}

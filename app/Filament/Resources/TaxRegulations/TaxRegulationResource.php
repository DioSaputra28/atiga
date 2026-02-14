<?php

namespace App\Filament\Resources\TaxRegulations;

use App\Filament\Resources\TaxRegulations\Pages\ManageTaxRegulations;
use App\Models\TaxRegulation;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class TaxRegulationResource extends Resource
{
    protected static ?string $model = TaxRegulation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $recordTitleAttribute = 'Tax Regulation Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Judul regulasi wajib diisi.',
                        'max' => 'Judul regulasi maksimal 255 karakter.',
                    ])
                    ->helperText('Masukkan judul regulasi pajak yang jelas dan ringkas.'),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'Deskripsi regulasi wajib diisi.',
                    ])
                    ->helperText('Tambahkan ringkasan isi regulasi agar mudah dipahami pengguna.'),
                FileUpload::make('document_path')
                    ->label('Dokumen PDF')
                    ->disk('public')
                    ->directory('tax-regulations')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->downloadable()
                    ->openable()
                    ->validationMessages([
                        'mimetypes' => 'Dokumen harus berupa file PDF.',
                        'max' => 'Ukuran dokumen maksimal 10 MB.',
                    ])
                    ->helperText('Unggah dokumen regulasi dalam format PDF (maksimal 10 MB).'),
                TextInput::make('document_name')
                    ->maxLength(255)
                    ->validationMessages([
                        'max' => 'Nama dokumen maksimal 255 karakter.',
                    ])
                    ->helperText('Nama dokumen yang ditampilkan ke pengguna (opsional).'),
                TextInput::make('youtube_url')
                    ->label('YouTube URL')
                    ->url()
                    ->maxLength(255)
                    ->validationMessages([
                        'url' => 'Masukkan URL YouTube yang valid.',
                        'max' => 'URL YouTube maksimal 255 karakter.',
                    ])
                    ->helperText('Tautan video penjelasan regulasi (opsional).'),
                Toggle::make('is_published')
                    ->required()
                    ->default(false)
                    ->helperText('Aktifkan untuk menayangkan regulasi di halaman publik.'),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->beforeOrEqual('now')
                    ->validationMessages([
                        'before_or_equal' => 'Tanggal publikasi tidak boleh melebihi waktu saat ini.',
                    ])
                    ->helperText('Isi jika regulasi sudah dipublikasikan. Tidak boleh lebih dari waktu saat ini.'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->validationMessages([
                        'required' => 'Urutan tampil wajib diisi.',
                        'numeric' => 'Urutan tampil harus berupa angka.',
                        'min' => 'Urutan tampil minimal 0.',
                    ])
                    ->helperText('Angka lebih kecil akan ditampilkan lebih dahulu.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Tax Regulation Management')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('document_name')
                    ->searchable(),
                TextColumn::make('youtube_url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_published'),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTaxRegulations::route('/'),
        ];
    }
}

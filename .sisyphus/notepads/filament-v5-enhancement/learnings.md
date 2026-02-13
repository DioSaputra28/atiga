## ActivityObserver Implementation

**Date:** 2025-02-13

**Task:** Created ActivityObserver for image cleanup on activity deletion

**Pattern:**
- Use `deleted()` method to handle post-deletion cleanup
- Iterate relationship safely: `foreach ($activity->images as $image)`
- Check non-empty path before deletion: `if (! empty($image->image_path))`
- Use `Storage::disk(public)->delete()` for file cleanup

**Model Relationship:**
- Activity hasMany ActivityImage via `images()` relationship
- ActivityImage has `image_path` field storing file path

**Key Implementation Details:**
- Added null/empty checks before attempting deletion
- Observer covers all deletion entry points (direct delete, force delete, etc.)
- File cleanup happens after model deletion (deleted event)


## ArticleObserver Implementation

**Date:** 2025-02-13

**Task:** Created ArticleObserver for thumbnail lifecycle cleanup

**Pattern:**
- `updating()` method: Delete old thumbnail when replaced
  - Gate with `isDirty('thumbnail')` to detect changes
  - Use `getOriginal('thumbnail')` to retrieve old path
  - Check non-empty before deletion
- `deleted()` method: Delete current thumbnail on model deletion
  - Access current `thumbnail` property directly
  - Check non-empty before deletion

**Model Field:**
- Article has `thumbnail` field storing file path

**Key Implementation Details:**
- Uses `Storage::disk('public')` for all operations
- Gracefully handles null/empty paths with explicit checks
- Follows Laravel Observer conventions for event handling
- PHPDoc blocks for public method documentation


## ArticleObserver Implementation

**Date:** 2025-02-13

**Task:** Created ArticleObserver for thumbnail lifecycle cleanup

**Pattern:**
- `updating()` method: Delete old thumbnail when replaced
  - Gate with `isDirty('thumbnail')` to detect changes
  - Use `getOriginal('thumbnail')` to retrieve old path
  - Check non-empty before deletion
- `deleted()` method: Delete current thumbnail on model deletion
  - Access current `thumbnail` property directly
  - Check non-empty before deletion

**Model Field:**
- Article has `thumbnail` field storing file path

**Key Implementation Details:**
- Uses `Storage::disk('public')` for all operations
- Gracefully handles null/empty paths with explicit checks
- Follows Laravel Observer conventions for event handling
- PHPDoc blocks for public method documentation


## BannerObserver Implementation

**Date:** 2025-02-13

**Task:** Created BannerObserver for image lifecycle cleanup

**Pattern:**
- Use `updating()` method to handle image path changes
- Use `deleted()` method to handle post-deletion cleanup
- Guard with `isDirty('image_path')` to only act on actual changes
- Get original value with `getOriginal('image_path')` before it's overwritten
- Get current value with `getAttribute('image_path')` in deleted event
- Use `Storage::disk('public')` for file operations

**Key Implementation Details:**
```php
// In updating - delete old image when path changes
if ($banner->isDirty('image_path')) {
    $oldPath = $banner->getOriginal('image_path');
    if ($oldPath !== null && Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->delete($oldPath);
    }
}

// In deleted - delete current image
$path = $banner->getAttribute('image_path');
if ($path !== null && Storage::disk('public')->exists($path)) {
    Storage::disk('public')->delete($path);
}
```

**Notes:**
- Observer not yet registered in EventServiceProvider (separate task)
- Follows Filament v5 responsibility model for cleanup
- Defensive null and existence checks prevent errors


## Task 4: Register Observers in AppServiceProvider - 2026-02-13 10:57

**Changes Made:**
- Added imports for Article, Activity, Banner models
- Added imports for ArticleObserver, ActivityObserver, BannerObserver
- Registered all three observers in boot() method

**Implementation:**
- Used Model::observe(Observer::class) pattern per Laravel convention
- Maintained existing configureDefaults() call
- Imports ordered alphabetically by namespace

**Verification:**
- php -l app/Providers/AppServiceProvider.php: PASSED (no syntax errors)
- Note: LSP shows 'undefined type' errors for observers - EXPECTED since observer classes are created in parallel Wave 1 tasks 1-3

**Files Modified:**
- app/Providers/AppServiceProvider.php



## ArticleObserver Fix (Verification)

**Date:** 2025-02-13

**Fix:** Added explicit Storage::disk(public)->exists() checks before deletion

**Changes:**
- updating(): Now checks ! empty(oldThumbnail) AND Storage::disk(public)->exists(oldThumbnail)
- deleted(): Now checks ! empty(article->thumbnail) AND Storage::disk(public)->exists(article->thumbnail)

**Verification:** php -l app/Observers/ArticleObserver.php passes



## BannerResource Form Helper Text - 2025-02-13

**Task:** Added Indonesian helper text to all Banner form fields

**Fields Modified:**
- `title`: "Masukkan judul banner yang deskriptif dan mudah diidentifikasi"
- `type`: "Tipe banner, contoh: hero, sidebar, footer, popup"
- `image_path`: "Unggah gambar banner dalam format JPG, PNG, atau WebP. Disarankan ukuran 1200x400px"
- `link_url`: "URL tujuan ketika banner diklik (opsional)"
- `alt_text`: "Teks alternatif untuk aksesibilitas dan SEO. Deskripsikan isi gambar"
- `sort_order`: "Urutan tampilan banner. Angka lebih kecil muncul lebih dulu"
- `is_active`: "Aktifkan untuk menampilkan banner di halaman website"
- `starts_at`: "Tanggal dan waktu mulai menampilkan banner (opsional)"
- `ends_at`: "Tanggal dan waktu berakhir penampilan banner (opsional)"
- `click_count`: "Jumlah klik pada banner. Biasanya diisi otomatis oleh sistem"
- `view_count`: "Jumlah tampilan banner. Biasanya diisi otomatis oleh sistem"

**Implementation Pattern:**
- Use `->helperText()` method after field configuration
- Keep helper text practical and context-specific
- Indonesian language for admin panel consistency
- Preserve all existing validation and defaults

**Verification:** php -l app/Filament/Resources/Banners/BannerResource.php passes

**Files Modified:**
- app/Filament/Resources/Banners/BannerResource.php (form() method only)

## ActivityForm Slug Auto-Generation & Helper Text

**Date:** 2025-02-13

**Task:** Updated ActivityForm with guarded slug auto-generation and Indonesian helper text

**Pattern:**
- Use `live(onBlur: true)` to trigger slug generation when title loses focus
- Use `afterStateUpdated` callback with `Get` and `Set` for state management
- Guard pattern: Only overwrite slug if current value matches slug of old title
  - If user manually edited slug, preserve their custom value
  - If slug was auto-generated from old title, update with new title

**Implementation:**
```php
TextInput::make('title')
    ->live(onBlur: true)
    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
        $currentSlug = $get('slug');

        if ($currentSlug !== null && $currentSlug !== Str::slug($old)) {
            return; // Slug was manually edited, preserve it
        }

        $set('slug', Str::slug($state));
    })
```

**Helper Text Added (Indonesian):**
- title: "Masukkan judul kegiatan"
- slug: "Slug URL untuk kegiatan (diisi otomatis dari judul)"
- description: "Deskripsi lengkap tentang kegiatan"
- held_at: "Tanggal pelaksanaan kegiatan"
- location: "Lokasi atau tempat pelaksanaan kegiatan"
- is_featured: "Tampilkan kegiatan ini di halaman utama?"

**Key Implementation Details:**
- Uses `Filament\Forms\Get`, `Filament\Forms\Set` for reactive state
- Uses `Illuminate\Support\Str::slug()` for slug generation
- Preserves field order unchanged
- All validation rules remain unchanged
- Helper text in Indonesian for consistency with application locale


## Task 8: CategoryResource Form Update - Slug & Helper Text - 2025-02-13

**Changes Made:**
- Added imports: `Filament\Forms\Get`, `Filament\Forms\Set`, `Illuminate\Support\Str`
- Added slug auto-generation from name with manual override guard
- Added Indonesian helper text for all form fields

**Slug Generation Pattern:**
```php
TextInput::make('name')
    ->live(onBlur: true)
    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old) {
        // Guard: Don't overwrite if slug was manually edited
        if ($old !== null && $get('slug') !== Str::slug($old)) {
            return;
        }
        $set('slug', Str::slug($state));
    }),
```

**Guard Logic:**
- Only auto-generates slug when name is first entered (old === null)
- Or when slug matches what would have been auto-generated from old name
- If user manually edited slug (slug !== Str::slug(old)), preserves manual value

**Helper Text Added:**
- name: 'Nama kategori yang akan ditampilkan'
- slug: 'Slug unik untuk URL (otomatis dibuat dari nama, bisa diubah manual)'
- description: 'Deskripsi singkat tentang kategori ini'
- is_active: 'Aktifkan untuk menampilkan kategori di frontend'
- sort_order: 'Urutan tampilan kategori (angka lebih kecil = lebih awal)'

**Verification:**
- php -l app/Filament/Resources/Categories/CategoryResource.php: PASSED

**Files Modified:**
- app/Filament/Resources/Categories/CategoryResource.php


## Task 9: TagResource Form Update - Slug & Helper Text - 2025-02-13

**Changes Made:**
- Added imports: `Filament\Forms\Get`, `Filament\Forms\Set`, `Illuminate\Support\Str`
- Added slug auto-generation from name with manual override guard
- Added Indonesian helper text for form fields

**Slug Generation Pattern:**
```php
TextInput::make('name')
    ->required()
    ->helperText('Nama tag untuk mengidentifikasi konten')
    ->live(onBlur: true)
    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
        if (($get('slug') ?? '') !== Str::slug($old ?? '')) {
            return;
        }
        $set('slug', Str::slug($state ?? ''));
    }),
```

**Guard Logic:**
- Only auto-generates slug if current slug equals slug of old name
- If user manually edited slug, preserves their custom value
- Uses null coalescing to handle empty states gracefully

**Helper Text Added:**
- name: 'Nama tag untuk mengidentifikasi konten'
- slug: 'URL-friendly identifier (auto-generated dari nama)'

**Verification:**
- php -l app/Filament/Resources/Tags/TagResource.php: PASSED

**Files Modified:**
- app/Filament/Resources/Tags/TagResource.php


## Task 5: ArticleForm Slug Auto-generation & Helper Text - 2025-02-13

**Date:** 2025-02-13

**Task:** Add slug auto-generation from title and Indonesian helper texts

**Slug Auto-generation Pattern (Filament v5):**
```php
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

TextInput::make('title')
    ->live(onBlur: true)
    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
        // Guard: preserve manual slug edits
        if ($get('slug') !== null && $get('slug') !== '' && $get('slug') !== Str::slug($old)) {
            return;
        }
        $set('slug', Str::slug($state));
    }),
```

**Key Implementation Details:**
- Uses `live(onBlur: true)` to trigger only when user leaves title field
- Uses `Get` and `Set` utilities from `Filament\Schemas\Components\Utilities`
- Guard condition checks if slug was manually edited (not equal to auto-generated from old title)
- All helper texts in Indonesian language
- Helper texts added to ALL fields: category_id, user_id, title, slug, excerpt, content, thumbnail, is_highlighted, is_published, published_at, view_count

**Helper Texts Added:**
- category_id: "Pilih kategori artikel"
- user_id: "Pilih penulis artikel"
- title: "Judul artikel yang akan ditampilkan"
- slug: "URL slug untuk artikel (auto-generate dari judul)"
- excerpt: "Ringkasan singkat artikel"
- content: "Konten lengkap artikel"
- thumbnail: "URL gambar thumbnail artikel"
- is_highlighted: "Tandai sebagai artikel unggulan"
- is_published: "Tandai untuk mempublikasikan artikel"
- published_at: "Tanggal dan waktu publikasi artikel"
- view_count: "Jumlah tampilan artikel"

**Verification:**
- php -l app/Filament/Resources/Articles/Schemas/ArticleForm.php: PASSED

**Files Modified:**
- app/Filament/Resources/Articles/Schemas/ArticleForm.php


## Task 14: TagResource Table Check - SKIPPED - 2025-02-13

**Task:** Update TagResource Table - Check & Skip if No Booleans

**Inspection Result:** SKIPPED - No boolean columns present

**Columns Found in table() method:**
- `name` (TextColumn) - searchable
- `slug` (TextColumn) - searchable
- `deleted_at` (TextColumn) - dateTime, sortable, toggleable hidden by default
- `created_at` (TextColumn) - dateTime, sortable, toggleable hidden by default
- `updated_at` (TextColumn) - dateTime, sortable, toggleable hidden by default

**Conclusion:**
No IconColumn entries found. All columns are TextColumn types with no boolean representation. No conversion to ToggleColumn required.

**Files Modified:**
- None (no changes needed)


## Task 10: ArticlesTable ToggleColumn Update - 2025-02-13

**Task:** Update ArticlesTable - Convert IconColumn booleans to ToggleColumn

**Changes Made:**
- Replaced `IconColumn` import with `ToggleColumn` import
- Converted `is_highlighted` from IconColumn to ToggleColumn
- Converted `is_published` from IconColumn to ToggleColumn
- Removed `->boolean()` calls (not needed for ToggleColumn)

**Before:**
```php
use Filament\Tables\Columns\IconColumn;
...
IconColumn::make('is_highlighted')
    ->boolean(),
IconColumn::make('is_published')
    ->boolean(),
```

**After:**
```php
use Filament\Tables\Columns\ToggleColumn;
...
ToggleColumn::make('is_highlighted'),
ToggleColumn::make('is_published'),
```

**Implementation Notes:**
- ToggleColumn provides an interactive toggle switch in table rows
- Unlike IconColumn, ToggleColumn does not require `->boolean()` modifier
- Column order preserved exactly
- All other columns (TextColumn entries) unchanged
- Non-boolean columns left untouched

**Verification:**
- php -l app/Filament/Resources/Articles/Tables/ArticlesTable.php: PASSED

**Files Modified:**
- app/Filament/Resources/Articles/Tables/ArticlesTable.php


## Task 9 Fix: TagResource Get/Set Import Path Update - 2025-02-13

**Fix:** Changed Get/Set imports from `Filament\Forms` to `Filament\Schemas\Components\Utilities`

**Changes:**
- `Filament\Forms\Get` → `Filament\Schemas\Components\Utilities\Get`
- `Filament\Forms\Set` → `Filament\Schemas\Components\Utilities\Set`

**Verification:**
- php -l app/Filament/Resources/Tags/TagResource.php: PASSED

**Note:** This aligns with Filament v5 schema component utilities location for reactive state management.


## ActivityForm Fix: Filament v5 Schema Utility Imports

**Date:** 2025-02-13

**Fix:** Changed Get/Set imports from `Filament\Forms\Get/Set` to `Filament\Schemas\Components\Utilities\Get/Set`

**Issue:** QA reported slug auto-population not working. Root cause was using wrong namespace for Get/Set utilities in Filament v5 schema-based forms.

**Correct Imports:**
```php
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
```

**Note:** When working with Filament v5 extracted form schemas (ActivityForm pattern), use the schema utilities namespace, not the forms namespace.


## Task 8 Fix: Filament v5 Schema Utilities Import Path - 2025-02-13

**Fix Applied:**
Changed imports from old Forms namespace to new Schemas namespace:
- OLD: `Filament\Forms\Get` and `Filament\Forms\Set`
- NEW: `Filament\Schemas\Components\Utilities\Get` and `Set`

**Callback Signature Fix:**
Changed parameter order in afterStateUpdated callback:
- OLD: `(Get $get, Set $set, ?string $state, ?string $old)`
- NEW: `(Get $get, Set $set, ?string $old, ?string $state)`

**Filament v5 Pattern for Slug Generation:**
```php
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

TextInput::make('name')
    ->live(onBlur: true)
    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
        if ($old !== null && $get('slug') !== Str::slug($old)) {
            return;
        }
        $set('slug', Str::slug($state));
    }),
```

**Verification:**
- php -l app/Filament/Resources/Categories/CategoryResource.php: PASSED

**Files Modified:**
- app/Filament/Resources/Categories/CategoryResource.php

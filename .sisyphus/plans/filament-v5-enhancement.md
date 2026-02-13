# Filament v5 Resource Enhancement Plan

## TL;DR

> **Enhance existing Filament v5 resources with modern UX patterns:** Toggle columns for booleans, auto-generated slugs, helper text for all inputs, and automatic image cleanup on deletion/replacement.
>
> **Deliverables:**
> - 4 Resources enhanced (Articles, Activities, Banners, Categories, Tags)
> - 1 Model Observer per image-having resource
> - Consistent UX across all admin panels
>
> **Estimated Effort:** Medium (3-4 hours execution)
> **Parallel Execution:** YES - Wave 1 (Observers), Wave 2 (Forms), Wave 3 (Tables)
> **Critical Path:** Articles → Activities → Banners → Categories → Tags

---

## Context

### Original Request
User wants to enhance existing Filament v5 resources with 4 specific improvements:
1. Boolean columns in tables should become toggle columns (not just icons)
2. Slug fields should auto-generate from title/name fields
3. All form inputs should have helper text explaining their purpose
4. Images should auto-delete from storage when replaced or record is deleted

### Current State Analysis
**Existing Resources:**
- `Articles` - Uses extracted Form (`ArticleForm`) and Table (`ArticlesTable`) classes
- `Activities` - Uses extracted Form (`ActivityForm`) and Table (`ActivitiesTable`) classes  
- `Banners` - Inline form/table in `BannerResource`
- `Categories` - Inline form/table (pattern likely similar to Banners)
- `Tags` - Inline form/table (pattern likely similar to Banners)
- `Users` - Default Filament resource, skip enhancement

**Code Patterns Found:**
- Extracted Form/Table classes: `Resources/{Resource}/Schemas/{Resource}Form.php` and `Resources/{Resource}/Tables/{Resources}Table.php`
- Inline forms: Directly in `Resource::form()` method
- Current boolean columns use `IconColumn::make('field')->boolean()`

### Metis Review Findings
**Identified Gaps (addressed in this plan):**
- ✅ Image replacement strategy: Delete old when new uploaded (via Model Observer)
- ✅ Scope boundaries: Defined which resources get which enhancements
- ✅ Acceptance criteria: Agent-executable verification commands included
- ✅ Edge cases: Duplicate slug handling, bulk delete image cleanup

**Architecture Decision:**
- Use **Model Observer Pattern** for image deletion (Filament v5 recommended approach)
- Works for UI, API, bulk actions, and tinker
- Handles both record deletion AND image replacement

---

## Work Objectives

### Core Objective
Enhance 5 Filament v5 resources (Articles, Activities, Banners, Categories, Tags) with consistent UX improvements: toggle columns, auto-generated slugs, helper text, and automatic image cleanup.

### Concrete Deliverables
| Deliverable | Location | Description |
|-------------|----------|-------------|
| ArticleObserver | `app/Observers/ArticleObserver.php` | Handle thumbnail cleanup |
| ActivityObserver | `app/Observers/ActivityObserver.php` | Handle activity_images cleanup |
| BannerObserver | `app/Observers/BannerObserver.php` | Handle image_path cleanup |
| Updated ArticleForm | `app/Filament/Resources/Articles/Schemas/ArticleForm.php` | Slug auto-gen + helper text |
| Updated ArticlesTable | `app/Filament/Resources/Articles/Tables/ArticlesTable.php` | ToggleColumn for booleans |
| Updated ActivityForm | `app/Filament/Resources/Activities/Schemas/ActivityForm.php` | Slug auto-gen + helper text |
| Updated ActivitiesTable | `app/Filament/Resources/Activities/Tables/ActivitiesTable.php` | ToggleColumn for booleans |
| Updated BannerResource | `app/Filament/Resources/Banners/BannerResource.php` | All enhancements inline |
| Updated CategoryResource | `app/Filament/Resources/Categories/CategoryResource.php` | All enhancements inline |
| Updated TagResource | `app/Filament/Resources/Tags/TagResource.php` | All enhancements inline |
| AppServiceProvider | `app/Providers/AppServiceProvider.php` | Register observers |

### Definition of Done
- [x] All boolean columns in tables use `ToggleColumn` (not `IconColumn`)
- [x] Slug fields auto-generate from title/name using `afterStateUpdated()`
- [x] Every form field has descriptive `helperText()`
- [x] Model observers delete old images on replacement and record deletion
- [x] All changes follow existing code patterns (extracted vs inline)
- [x] No existing functionality is broken
- [x] All resources render without errors in Filament admin panel

### Must Have
- Toggle columns for: `articles.is_highlighted`, `articles.is_published`, `activities.is_featured`, `banners.is_active`, `categories.is_active`
- Slug auto-generation for: Articles (from title), Activities (from title), Categories (from name), Tags (from name)
- Helper text for ALL form fields in enhanced resources
- Image cleanup for: Article thumbnail, Activity images, Banner image_path

### Must NOT Have (Guardrails from Metis Review)
- ❌ **Don't modify validation rules** - Only enhance presentation, not validation
- ❌ **Don't change field ordering** - Keep existing field order
- ❌ **Don't reorder columns** - Keep existing column order in tables
- ❌ **Don't add i18n/translations** - Hardcoded helper text in Indonesian
- ❌ **Don't create new Form/Table classes** - Work within existing structure
- ❌ **Don't modify database schema** - No migrations needed
- ❌ **Don't handle non-image files** - Only images (jpg, png, gif, webp, svg)
- ❌ **Don't enable inline editing** - ToggleColumn is visual indicator only
- ❌ **Don't modify Users resource** - Skip default user management
- ❌ **Don't add SEO features beyond basic slug** - No meta tags, structured data, etc.

---

## Verification Strategy

### Test Decision
- **Infrastructure exists:** YES (Pest 4 installed)
- **Automated tests:** Tests-after (feature tests for verification)
- **Framework:** Pest 4

### Agent-Executed QA Scenarios (MANDATORY)

**Scenario 1: Toggle columns display correctly**
```
Tool: Playwright (playwright skill)
Preconditions: Dev server running, admin logged in
Steps:
  1. Navigate to: http://localhost:8000/admin/articles
  2. Wait for: table to load (timeout: 10s)
  3. Assert: Column 'is_published' shows toggle switch (not icon)
  4. Assert: Column 'is_highlighted' shows toggle switch (not icon)
  5. Navigate to: http://localhost:8000/admin/activities
  6. Assert: Column 'is_featured' shows toggle switch
  7. Navigate to: http://localhost:8000/admin/banners
  8. Assert: Column 'is_active' shows toggle switch
Expected Result: All boolean columns show toggle switches
Evidence: Screenshot .sisyphus/evidence/toggle-columns.png
```

**Scenario 2: Slug auto-generates from title**
```
Tool: Playwright (playwright skill)
Preconditions: Dev server running, admin logged in
Steps:
  1. Navigate to: http://localhost:8000/admin/articles/create
  2. Wait for: form to load (timeout: 5s)
  3. Fill: input[name="title"] → "Panduan Pajak Tahunan"
  4. Blur: input[name="title"] (click elsewhere or Tab)
  5. Wait for: 500ms (debounce)
  6. Assert: input[name="slug"] value equals "panduan-pajak-tahunan"
  7. Clear: input[name="title"]
  8. Fill: input[name="title"] → "Tips & Trik E-Filing"
  9. Blur: input[name="title"]
  10. Assert: input[name="slug"] value equals "tips-trik-e-filing"
Expected Result: Slug auto-generates from title with proper formatting
Evidence: Screenshot .sisyphus/evidence/slug-generation.png
```

**Scenario 3: Helper text visible on form fields**
```
Tool: Playwright (playwright skill)
Preconditions: Dev server running, admin logged in
Steps:
  1. Navigate to: http://localhost:8000/admin/articles/create
  2. Wait for: form to load (timeout: 5s)
  3. Assert: At least 3 fields have visible helper text (.fi-fo-field-wrp-helper-text)
  4. Navigate to: http://localhost:8000/admin/banners/create
  5. Assert: At least 3 fields have visible helper text
  6. Navigate to: http://localhost:8000/admin/categories/create
  7. Assert: At least 2 fields have visible helper text
Expected Result: Helper text visible on multiple form fields per resource
Evidence: Screenshot .sisyphus/evidence/helper-text.png
```

**Scenario 4: Image deleted when record deleted**
```
Tool: Bash (artisan tinker)
Preconditions: Fresh database with seeders run
Steps:
  1. php artisan tinker --execute="
    use App\Models\Article;
    use Illuminate\Support\Facades\Storage;
    
    // Create article with fake image path
    \$article = Article::factory()->create([
        'thumbnail' => 'articles/test-image-123.jpg'
    ]);
    
    // Create dummy file
    Storage::disk('public')->put('articles/test-image-123.jpg', 'dummy');
    
    // Verify file exists
    \$existsBefore = Storage::disk('public')->exists('articles/test-image-123.jpg');
    
    // Delete article
    \$article->delete();
    
    // Verify file deleted
    \$existsAfter = Storage::disk('public')->exists('articles/test-image-123.jpg');
    
    echo \"Before: \" . (\$existsBefore ? 'EXISTS' : 'MISSING') . \"\n\";
    echo \"After: \" . (\$existsAfter ? 'EXISTS' : 'MISSING') . \"\n\";
    echo \"Test: \" . (\$existsBefore && !\$existsAfter ? 'PASSED' : 'FAILED') . \"\n\";
  "
Expected Result: Output shows "Before: EXISTS", "After: MISSING", "Test: PASSED"
Evidence: Terminal output captured
```

**Scenario 5: Old image deleted when replaced**
```
Tool: Bash (artisan tinker)
Preconditions: Fresh database with seeders run
Steps:
  1. php artisan tinker --execute="
    use App\Models\Banner;
    use Illuminate\Support\Facades\Storage;
    
    // Create banner with image
    \$banner = Banner::factory()->create([
        'image_path' => 'banners/old-banner.jpg'
    ]);
    
    // Create dummy files
    Storage::disk('public')->put('banners/old-banner.jpg', 'old');
    Storage::disk('public')->put('banners/new-banner.jpg', 'new');
    
    // Update with new image
    \$banner->update(['image_path' => 'banners/new-banner.jpg']);
    
    // Check results
    \$oldExists = Storage::disk('public')->exists('banners/old-banner.jpg');
    \$newExists = Storage::disk('public')->exists('banners/new-banner.jpg');
    
    echo \"Old image: \" . (\$oldExists ? 'EXISTS' : 'DELETED') . \"\n\";
    echo \"New image: \" . (\$newExists ? 'EXISTS' : 'MISSING') . \"\n\";
    echo \"Test: \" . (!\$oldExists && \$newExists ? 'PASSED' : 'FAILED') . \"\n\";
  "
Expected Result: Old image deleted, new image exists
Evidence: Terminal output captured
```

---

## Execution Strategy

### Parallel Execution Waves

```
Wave 1 (Start Immediately - Independent):
├── Task 1: Create ArticleObserver
├── Task 2: Create ActivityObserver
├── Task 3: Create BannerObserver
└── Task 4: Register observers in AppServiceProvider

Wave 2 (After Wave 1 - Form Enhancements):
├── Task 5: Update ArticleForm (slug + helper text)
├── Task 6: Update ActivityForm (slug + helper text)
├── Task 7: Update BannerResource form (helper text)
├── Task 8: Update CategoryResource form (slug + helper text)
└── Task 9: Update TagResource form (slug + helper text)

Wave 3 (After Wave 2 - Table Enhancements):
├── Task 10: Update ArticlesTable (toggle columns)
├── Task 11: Update ActivitiesTable (toggle columns)
├── Task 12: Update BannerResource table (toggle columns)
├── Task 13: Update CategoryResource table (toggle columns)
└── Task 14: Update TagResource table (if has boolean columns)

Critical Path: Task 1-4 → Task 5-9 → Task 10-14
Parallel Speedup: ~30% faster than sequential
```

### Dependency Matrix

| Task | Depends On | Blocks | Can Parallelize With |
|------|------------|--------|---------------------|
| 1 (ArticleObserver) | None | 5, 10 | 2, 3, 4 |
| 2 (ActivityObserver) | None | 6, 11 | 1, 3, 4 |
| 3 (BannerObserver) | None | 7, 12 | 1, 2, 4 |
| 4 (Register Observers) | None | All observers | 1, 2, 3 |
| 5 (ArticleForm) | 1 | 10 | 6, 7, 8, 9 |
| 6 (ActivityForm) | 2 | 11 | 5, 7, 8, 9 |
| 7 (BannerResource form) | 3 | 12 | 5, 6, 8, 9 |
| 8 (CategoryResource form) | None | 13 | 5, 6, 7, 9 |
| 9 (TagResource form) | None | 14 | 5, 6, 7, 8 |
| 10 (ArticlesTable) | 5 | None | 11, 12, 13, 14 |
| 11 (ActivitiesTable) | 6 | None | 10, 12, 13, 14 |
| 12 (BannerResource table) | 7 | None | 10, 11, 13, 14 |
| 13 (CategoryResource table) | 8 | None | 10, 11, 12, 14 |
| 14 (TagResource table) | 9 | None | 10, 11, 12, 13 |

### Agent Dispatch Summary

| Wave | Tasks | Recommended Agents | Skills |
|------|-------|-------------------|--------|
| 1 | 1-4 | quick / unspecified-low | PHP, Laravel basics |
| 2 | 5-9 | quick / visual-engineering | livewire-development |
| 3 | 10-14 | quick / visual-engineering | livewire-development |

---

## TODOs

- [x] **1. Create ArticleObserver**

  **What to do:**
  Create model observer for Article that handles image cleanup on thumbnail replacement and record deletion.
  
  **Implementation:**
  - Create `app/Observers/ArticleObserver.php`
  - Implement `updating()` method: Check if `thumbnail` is dirty, delete old file if exists
  - Implement `deleted()` method: Delete thumbnail file if exists
  - Use `Storage::disk('public')->delete()` for file deletion
  - Check file exists before attempting delete to avoid errors
  
  **Must NOT do:**
  - Don't handle soft deletes differently (delete on both soft and force delete)
  - Don't delete if new value is same as old value
  - Don't use `Storage::delete()` without specifying disk
  
  **Recommended Agent Profile:**
  - **Category:** `quick` - Simple observer pattern implementation
  - **Skills:** None required - basic Laravel observer knowledge
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 1)
  - **Parallel Group:** Wave 1 with Tasks 2, 3, 4
  - **Blocks:** Task 5 (ArticleForm), Task 10 (ArticlesTable)
  - **Blocked By:** None (can start immediately)
  
  **References:**
  - `app/Models/Article.php` - Check $fillable fields, especially 'thumbnail'
  - Filament v5 docs: "It is the responsibility of the developer to delete these files... observing a model event"
  - Laravel Observer docs: https://laravel.com/docs/12.x/eloquent#observers
  
  **Acceptance Criteria:**
  - [ ] File `app/Observers/ArticleObserver.php` exists
  - [ ] Class has `updating(Article $article)` method that deletes old thumbnail when changed
  - [ ] Class has `deleted(Article $article)` method that deletes thumbnail
  - [ ] Uses `Storage::disk('public')` for all file operations
  - [ ] Checks `isDirty('thumbnail')` before processing
  - [ ] Checks `getOriginal('thumbnail')` exists before deleting
  - [ ] Handles case where file might not exist gracefully
  
  **Agent-Executed QA Scenario:**
  ```
  Scenario: Article observer deletes images correctly
    Tool: Bash (artisan tinker)
    Preconditions: None
    Steps:
      1. php artisan tinker --execute="use App\Models\Article; use Illuminate\Support\Facades\Storage; \$a = Article::factory()->create(['thumbnail' => 't.jpg']); Storage::disk('public')->put('t.jpg', 'x'); echo 'Created';"
      2. php artisan tinker --execute="use App\Models\Article; use Illuminate\Support\Facades\Storage; \$a = Article::first(); Storage::disk('public')->put('t2.jpg', 'y'); \$a->update(['thumbnail' => 't2.jpg']); echo Storage::disk('public')->exists('t.jpg') ? 'OLD_EXISTS' : 'OLD_DELETED';"
    Expected Result: Output shows "OLD_DELETED"
    Evidence: Terminal output captured
  ```
  
  **Commit:** YES
  - Message: `feat(observers): add ArticleObserver for thumbnail cleanup`
  - Files: `app/Observers/ArticleObserver.php`
  - Pre-commit: `php artisan inspect` or `pint`

---

- [x] **2. Create ActivityObserver**

  **What to do:**
  Create model observer for Activity that handles image cleanup. Activities have `activity_images` relationship (one-to-many), so this needs special handling.
  
  **Implementation:**
  - Create `app/Observers/ActivityObserver.php`
  - Implement `deleted()` method: Load all activity_images, delete each file, then delete records
  - Note: Activity model has ActivityImage relationship - cascade delete images when activity deleted
  - The activity_images table has `image_path` column - delete these files
  
  **Must NOT do:**
  - Don't delete ActivityImage records without deleting files first
  - Don't use `ActivityImage::where('activity_id', $activity->id)->delete()` - this skips file deletion
  - Must iterate and delete files individually before deleting DB records
  
  **Recommended Agent Profile:**
  - **Category:** `quick` - Observer with relationship handling
  - **Skills:** None required
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 1)
  - **Parallel Group:** Wave 1 with Tasks 1, 3, 4
  - **Blocks:** Task 6 (ActivityForm), Task 11 (ActivitiesTable)
  - **Blocked By:** None (can start immediately)
  
  **References:**
  - `app/Models/Activity.php` - Check `images()` relationship
  - `app/Models/ActivityImage.php` - Check $fillable fields
  
  **Acceptance Criteria:**
  - [ ] File `app/Observers/ActivityObserver.php` exists
  - [ ] Class has `deleted(Activity $activity)` method
  - [ ] Method loads `$activity->images` relationship
  - [ ] Iterates through each image and deletes file with `Storage::disk('public')->delete($image->image_path)`
  - [ ] Deletes images in DB after files are deleted (or use cascade)
  
  **Commit:** YES
  - Message: `feat(observers): add ActivityObserver for activity_images cleanup`
  - Files: `app/Observers/ActivityObserver.php`

---

- [x] **3. Create BannerObserver**

  **What to do:**
  Create model observer for Banner that handles image_path cleanup on update and delete.
  
  **Implementation:**
  - Create `app/Observers/BannerObserver.php`
  - Similar pattern to ArticleObserver
  - Field name: `image_path` (not `thumbnail`)
  
  **Recommended Agent Profile:**
  - **Category:** `quick`
  - **Skills:** None
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 1)
  - **Blocks:** Task 7 (BannerResource form), Task 12 (BannerResource table)
  - **Blocked By:** None
  
  **References:**
  - `app/Filament/Resources/Banners/BannerResource.php` - See existing form fields, confirms `image_path` field
  
  **Acceptance Criteria:**
  - [ ] File `app/Observers/BannerObserver.php` exists
  - [ ] Has `updating()` and `deleted()` methods
  - [ ] Handles `image_path` field cleanup
  
  **Commit:** YES
  - Message: `feat(observers): add BannerObserver for image cleanup`
  - Files: `app/Observers/BannerObserver.php`

---

- [x] **4. Register Observers in AppServiceProvider**

  **What to do:**
  Register all three observers in `AppServiceProvider::boot()` method.
  
  **Implementation:**
  - Edit `app/Providers/AppServiceProvider.php`
  - Add to `boot()` method:
    ```php
    use App\Models\Article;
    use App\Models\Activity;
    use App\Models\Banner;
    use App\Observers\ArticleObserver;
    use App\Observers\ActivityObserver;
    use App\Observers\BannerObserver;
    
    public function boot(): void
    {
        Article::observe(ArticleObserver::class);
        Activity::observe(ActivityObserver::class);
        Banner::observe(BannerObserver::class);
    }
    ```
  
  **Recommended Agent Profile:**
  - **Category:** `quick`
  - **Skills:** None
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 1)
  - **Blocks:** All observer-related functionality (Tasks 5, 6, 7, 10, 11, 12)
  - **Blocked By:** None (can register even before observers fully implemented)
  
  **References:**
  - `app/Providers/AppServiceProvider.php` - Current content
  - Laravel docs: Observer registration
  
  **Acceptance Criteria:**
  - [ ] `AppServiceProvider::boot()` contains `Article::observe()` call
  - [ ] Contains `Activity::observe()` call
  - [ ] Contains `Banner::observe()` call
  - [ ] All three observer classes are imported at top of file
  
  **Agent-Executed QA Scenario:**
  ```
  Scenario: Observers are registered
    Tool: Bash (grep)
    Preconditions: Task 1, 2, 3 completed
    Steps:
      1. grep -n "Article::observe" app/Providers/AppServiceProvider.php
      2. grep -n "Activity::observe" app/Providers/AppServiceProvider.php
      3. grep -n "Banner::observe" app/Providers/AppServiceProvider.php
    Expected Result: All three commands return matching lines with line numbers
    Evidence: Terminal output
  ```
  
  **Commit:** YES
  - Message: `chore(providers): register model observers in AppServiceProvider`
  - Files: `app/Providers/AppServiceProvider.php`

---

- [x] **5. Update ArticleForm - Slug Auto-generation & Helper Text**

  **What to do:**
  Enhance ArticleForm with: (1) Auto-generated slug from title, (2) Helper text on all fields.
  
  **Implementation:**
  - Edit `app/Filament/Resources/Articles/Schemas/ArticleForm.php`
  - **Slug Generation:**
    ```php
    use Filament\Schemas\Components\Utilities\Set;
    use Filament\Schemas\Components\Utilities\Get;
    use Illuminate\Support\Str;
    
    TextInput::make('title')
        ->required()
        ->live(onBlur: true)
        ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
            if (($get('slug') ?? '') !== Str::slug($old)) {
                return;
            }
            $set('slug', Str::slug($state));
        })
        ->helperText('Judul artikel yang akan ditampilkan di halaman depan.'),
    
    TextInput::make('slug')
        ->required()
        ->helperText('URL-friendly version dari judul. Otomatis terisi dari judul, namun dapat diubah manual.'),
    ```
  - **Helper Text for ALL fields:**
    - `category_id`: "Pilih kategori untuk mengelompokkan artikel ini."
    - `user_id`: "Penulis artikel ini."
    - `excerpt`: "Ringkasan singkat artikel yang akan ditampilkan di list."
    - `content`: "Konten utama artikel dalam format JSON blocks."
    - `thumbnail`: "Gambar thumbnail untuk artikel. Ukuran ideal: 800x600px."
    - `is_highlighted`: "Tandai jika artikel ini perlu ditampilkan secara prominent."
    - `is_published`: "Status publikasi artikel."
    - `published_at`: "Tanggal dan waktu publikasi."
    - `view_count`: "Jumlah view (otomatis terisi)."
  
  **Must NOT do:**
  - Don't change field order
  - Don't modify validation rules
  - Don't add helper text to view_count (it's automatic)
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
    - Required for understanding reactive form patterns
    - `live(onBlur: true)` and `afterStateUpdated()` are Livewire patterns
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 2)
  - **Parallel Group:** Wave 2 with Tasks 6, 7, 8, 9
  - **Blocks:** Task 10 (ArticlesTable) - but can also run in parallel
  - **Blocked By:** Task 1 (ArticleObserver) - depends on image handling
  
  **References:**
  - Current: `app/Filament/Resources/Articles/Schemas/ArticleForm.php`
  - Filament v5 docs: "Generating a slug from a title" section
  - Code pattern:
    ```php
    TextInput::make('title')
        ->live(onBlur: true)
        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
    ```
  - Helper text: `->helperText('Description here')`
  
  **Acceptance Criteria:**
  - [ ] `title` field has `live(onBlur: true)` modifier
  - [ ] `title` field has `afterStateUpdated()` callback with slug generation logic
  - [ ] Uses `Get`, `Set`, and `Str::slug()` utilities
  - [ ] Includes protection for manual slug edits (check against $old)
  - [ ] ALL form fields (except view_count) have `helperText()`
  - [ ] Helper text is in Indonesian language
  - [ ] No field ordering changed
  
  **Agent-Executed QA Scenario:**
  ```
  Scenario: ArticleForm has slug auto-generation and helper text
    Tool: Playwright (playwright skill)
    Preconditions: Dev server running
    Steps:
      1. Navigate to: http://localhost:8000/admin/articles/create
      2. Fill: input[name="title"] → "Test Artikel Pajak"
      3. Press: Tab (blur title field)
      4. Wait: 500ms
      5. Assert: input[name="slug"] value is "test-artikel-pajak"
      6. Assert: At least 5 elements with class .fi-fo-field-wrp-helper-text exist
    Expected Result: Slug auto-generated, helper text visible
    Evidence: Screenshot .sisyphus/evidence/article-form-enhanced.png
  ```
  
  **Commit:** YES
  - Message: `feat(articles): add slug auto-generation and helper text to ArticleForm`
  - Files: `app/Filament/Resources/Articles/Schemas/ArticleForm.php`

---

- [x] **6. Update ActivityForm - Slug Auto-generation & Helper Text**

  **What to do:**
  Similar to Task 5, but for ActivityForm. Activity has: title, slug, description, held_at, location, is_featured.
  
  **Implementation:**
  - Edit `app/Filament/Resources/Activities/Schemas/ActivityForm.php`
  - Add slug generation from title (same pattern as Article)
  - Add helper text to all fields:
    - `title`: "Nama kegiatan yang akan ditampilkan."
    - `slug`: "URL-friendly version dari nama kegiatan."
    - `description`: "Deskripsi lengkap tentang kegiatan ini."
    - `held_at`: "Tanggal pelaksanaan kegiatan."
    - `location`: "Lokasi atau tempat pelaksanaan kegiatan."
    - `is_featured`: "Tandai untuk menampilkan kegiatan ini di halaman utama."
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 2)
  - **Blocks:** Task 11 (ActivitiesTable)
  - **Blocked By:** Task 2 (ActivityObserver)
  
  **References:**
  - Current: `app/Filament/Resources/Activities/Schemas/ActivityForm.php`
  - Pattern: Same as Task 5
  
  **Acceptance Criteria:**
  - [ ] `title` field has slug auto-generation
  - [ ] All fields have helperText()
  
  **Commit:** YES
  - Message: `feat(activities): add slug auto-generation and helper text to ActivityForm`
  - Files: `app/Filament/Resources/Activities/Schemas/ActivityForm.php`

---

- [x] **7. Update BannerResource Form - Helper Text**

  **What to do:**
  BannerResource has inline form (not extracted). Add helper text to all form fields.
  
  **Implementation:**
  - Edit `app/Filament/Resources/Banners/BannerResource.php` - `form()` method
  - Add helper text to each field:
    - `title`: "Judul banner untuk identifikasi internal."
    - `type`: "Jenis banner: hero, sidebar, popup, atau footer."
    - `image_path`: "Gambar banner. Ukuran ideal tergantung jenis: Hero (1200x400), Sidebar (300x250), Footer (1200x200)."
    - `link_url`: "URL yang akan dibuka saat banner diklik (opsional)."
    - `alt_text`: "Teks alternatif untuk SEO dan accessibility."
    - `sort_order`: "Urutan tampilan banner (angka kecil = lebih awal)."
    - `is_active`: "Aktifkan untuk menampilkan banner di website."
    - `starts_at`: "Tanggal mulai menampilkan banner (kosongkan untuk segera)."
    - `ends_at`: "Tanggal berhenti menampilkan banner (kosongkan untuk selamanya)."
    - `click_count`: "Jumlah klik (otomatis terisi)."
    - `view_count`: "Jumlah tampilan (otomatis terisi)."
  
  **Note:** Banners don't have slug field - skip slug generation.
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 2)
  - **Blocks:** Task 12 (BannerResource table)
  - **Blocked By:** Task 3 (BannerObserver)
  
  **References:**
  - Current: `app/Filament/Resources/Banners/BannerResource.php` lines 39-70
  
  **Acceptance Criteria:**
  - [ ] All form fields have `helperText()`
  - [ ] No existing functionality modified (just added helperText)
  
  **Commit:** YES
  - Message: `feat(banners): add helper text to all form fields in BannerResource`
  - Files: `app/Filament/Resources/Banners/BannerResource.php`

---

- [x] **8. Update CategoryResource Form - Slug & Helper Text**

  **What to do:**
  CategoryResource likely has inline form. Add slug auto-generation from name and helper text.
  
  **Implementation:**
  - Read current `app/Filament/Resources/Categories/CategoryResource.php`
  - Add to form fields:
    - `name`: "Nama kategori yang akan ditampilkan." + live + afterStateUpdated (generates slug)
    - `slug`: "URL-friendly version dari nama kategori."
    - `description`: "Deskripsi kategori untuk SEO."
    - `is_active`: "Aktifkan untuk menampilkan kategori di website."
    - `sort_order`: "Urutan tampilan kategori (angka kecil = lebih awal)."
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 2)
  - **Blocks:** Task 13 (CategoryResource table)
  - **Blocked By:** None (Categories have no images)
  
  **References:**
  - Model: `app/Models/Category.php` - Check fillable fields
  
  **Acceptance Criteria:**
  - [ ] `name` field generates `slug` using same pattern as Articles
  - [ ] All fields have helperText()
  
  **Commit:** YES
  - Message: `feat(categories): add slug auto-generation and helper text to CategoryResource`
  - Files: `app/Filament/Resources/Categories/CategoryResource.php`

---

- [x] **9. Update TagResource Form - Slug & Helper Text**

  **What to do:**
  TagResource likely has inline form. Add slug auto-generation from name and helper text.
  
  **Implementation:**
  - Read current `app/Filament/Resources/Tags/TagResource.php`
  - Add to form fields:
    - `name`: "Nama tag." + live + afterStateUpdated (generates slug)
    - `slug`: "URL-friendly version dari nama tag."
  
  **Note:** Tags table only has name, slug (no other fields per model read earlier).
  
  **Recommended Agent Profile:**
  - **Category:** `quick`
  - **Skills:** None
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 2)
  - **Blocks:** Task 14 (TagResource table)
  - **Blocked By:** None
  
  **References:**
  - Model: `app/Models/Tag.php` - Check fillable: only name, slug
  
  **Acceptance Criteria:**
  - [ ] `name` field generates `slug` 
  - [ ] Both fields have helperText()
  
  **Commit:** YES
  - Message: `feat(tags): add slug auto-generation and helper text to TagResource`
  - Files: `app/Filament/Resources/Tags/TagResource.php`

---

- [x] **10. Update ArticlesTable - ToggleColumn for Booleans**

  **What to do:**
  Change boolean columns from IconColumn to ToggleColumn.
  
  **Implementation:**
  - Edit `app/Filament/Resources/Articles/Tables/ArticlesTable.php`
  - Change:
    ```php
    // FROM:
    IconColumn::make('is_highlighted')
        ->boolean(),
    IconColumn::make('is_published')
        ->boolean(),
    
    // TO:
    ToggleColumn::make('is_highlighted')
        ->helperText('Tandai artikel sebagai highlighted'),
    ToggleColumn::make('is_published')
        ->helperText('Publish atau unpublish artikel'),
    ```
  - Import: `use Filament\Tables\Columns\ToggleColumn;`
  
  **Must NOT do:**
  - Don't enable inline editing (don't add `->disabled(false)` or similar)
  - Keep ToggleColumn as visual indicator only
  - Don't change column order
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 3)
  - **Parallel Group:** Wave 3 with Tasks 11, 12, 13, 14
  - **Blocked By:** Task 5 (ArticleForm)
  
  **References:**
  - Current: `app/Filament/Resources/Articles/Tables/ArticlesTable.php`
  - Filament v5 docs: ToggleColumn - "The toggle column allows you to render a toggle button inside the table"
  - Code: `ToggleColumn::make('is_admin')`
  
  **Acceptance Criteria:**
  - [ ] `is_highlighted` uses `ToggleColumn` (not `IconColumn`)
  - [ ] `is_published` uses `ToggleColumn` (not `IconColumn`)
  - [ ] Import statement for ToggleColumn added
  - [ ] Column order unchanged
  - [ ] All other column properties preserved
  
  **Agent-Executed QA Scenario:**
  ```
  Scenario: ArticlesTable has ToggleColumn for booleans
    Tool: Playwright (playwright skill)
    Preconditions: Dev server running, articles exist
    Steps:
      1. Navigate to: http://localhost:8000/admin/articles
      2. Wait for: table to load (timeout: 10s)
      3. Assert: Column 'is_published' elements have toggle switch appearance
      4. Assert: Column 'is_highlighted' elements have toggle switch appearance
      5. Assert: No IconColumn visible for boolean fields
    Expected Result: Boolean columns display as toggles
    Evidence: Screenshot .sisyphus/evidence/articles-table-toggle.png
  ```
  
  **Commit:** YES
  - Message: `feat(articles): convert boolean columns to ToggleColumn in ArticlesTable`
  - Files: `app/Filament/Resources/Articles/Tables/ArticlesTable.php`

---

- [x] **11. Update ActivitiesTable - ToggleColumn**

  **What to do:**
  Change `is_featured` from IconColumn to ToggleColumn.
  
  **Implementation:**
  - Edit `app/Filament/Resources/Activities/Tables/ActivitiesTable.php`
  - Change `IconColumn::make('is_featured')` to `ToggleColumn::make('is_featured')`
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 3)
  - **Blocked By:** Task 6 (ActivityForm)
  
  **Acceptance Criteria:**
  - [ ] `is_featured` uses ToggleColumn
  
  **Commit:** YES
  - Message: `feat(activities): convert is_featured to ToggleColumn in ActivitiesTable`
  - Files: `app/Filament/Resources/Activities/Tables/ActivitiesTable.php`

---

- [x] **12. Update BannerResource Table - ToggleColumn**

  **What to do:**
  Change `is_active` from IconColumn to ToggleColumn in BannerResource table.
  
  **Implementation:**
  - Edit `app/Filament/Resources/Banners/BannerResource.php` - `table()` method
  - Change `IconColumn::make('is_active')` to `ToggleColumn::make('is_active')`
  - Add import for ToggleColumn
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 3)
  - **Blocked By:** Task 7 (BannerResource form)
  
  **References:**
  - Current: `app/Filament/Resources/Banners/BannerResource.php` line ~90
  
  **Acceptance Criteria:**
  - [ ] `is_active` uses ToggleColumn
  
  **Commit:** YES
  - Message: `feat(banners): convert is_active to ToggleColumn in BannerResource table`
  - Files: `app/Filament/Resources/Banners/BannerResource.php`

---

- [x] **13. Update CategoryResource Table - ToggleColumn**

  **What to do:**
  Change `is_active` from IconColumn to ToggleColumn in CategoryResource table.
  
  **Implementation:**
  - Read current `app/Filament/Resources/Categories/CategoryResource.php` table method
  - Change `IconColumn::make('is_active')` to `ToggleColumn::make('is_active')`
  
  **Recommended Agent Profile:**
  - **Category:** `visual-engineering`
  - **Skills:** `livewire-development`
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 3)
  - **Blocked By:** Task 8 (CategoryResource form)
  
  **Acceptance Criteria:**
  - [ ] `is_active` uses ToggleColumn
  
  **Commit:** YES
  - Message: `feat(categories): convert is_active to ToggleColumn in CategoryResource table`
  - Files: `app/Filament/Resources/Categories/CategoryResource.php`

---

- [x] **14. Update TagResource Table - Check & Skip if No Booleans**

  **What to do:**
  Check if TagResource table has any boolean columns. If not, mark as skipped.
  
  **Implementation:**
  - Read `app/Filament/Resources/Tags/TagResource.php` table method
  - If has boolean IconColumns → change to ToggleColumn
  - If no booleans → mark task complete with "SKIPPED - No boolean columns"
  
  **Expected:** Tags likely has no boolean columns (only name, slug in model).
  
  **Recommended Agent Profile:**
  - **Category:** `quick`
  - **Skills:** None
  
  **Parallelization:**
  - **Can Run In Parallel:** YES (Wave 3)
  - **Blocked By:** Task 9 (TagResource form)
  
  **Acceptance Criteria:**
  - [ ] Either: Boolean columns converted to ToggleColumn, OR task marked skipped
  
  **Commit:** YES (if changes made) or NO (if skipped)
  - Message: `feat(tags): convert boolean columns to ToggleColumn` (if applicable)

---

## Commit Strategy

| After Task | Commit Message | Files | Verification |
|------------|----------------|-------|--------------|
| 1 | `feat(observers): add ArticleObserver for thumbnail cleanup` | ArticleObserver.php | `php artisan tinker` test |
| 2 | `feat(observers): add ActivityObserver for activity_images cleanup` | ActivityObserver.php | Tinker test |
| 3 | `feat(observers): add BannerObserver for image cleanup` | BannerObserver.php | Tinker test |
| 4 | `chore(providers): register model observers` | AppServiceProvider.php | Grep observers |
| 5 | `feat(articles): add slug auto-generation and helper text to ArticleForm` | ArticleForm.php | Playwright slug test |
| 6 | `feat(activities): add slug auto-generation and helper text to ActivityForm` | ActivityForm.php | Playwright helper text check |
| 7 | `feat(banners): add helper text to BannerResource form` | BannerResource.php | Playwright helper text check |
| 8 | `feat(categories): add slug auto-generation and helper text to CategoryResource` | CategoryResource.php | Playwright slug + helper |
| 9 | `feat(tags): add slug auto-generation and helper text to TagResource` | TagResource.php | Playwright slug + helper |
| 10 | `feat(articles): convert boolean columns to ToggleColumn` | ArticlesTable.php | Playwright toggle check |
| 11 | `feat(activities): convert is_featured to ToggleColumn` | ActivitiesTable.php | Playwright toggle check |
| 12 | `feat(banners): convert is_active to ToggleColumn` | BannerResource.php | Playwright toggle check |
| 13 | `feat(categories): convert is_active to ToggleColumn` | CategoryResource.php | Playwright toggle check |
| 14 | `feat(tags): convert boolean columns to ToggleColumn` (if applicable) | TagResource.php | Playwright toggle check |

---

## Success Criteria

### Verification Commands
```bash
# 1. Verify observers exist
php artisan tinker --execute="var_dump(class_exists(App\Observers\ArticleObserver::class));"
php artisan tinker --execute="var_dump(class_exists(App\Observers\ActivityObserver::class));"
php artisan tinker --execute="var_dump(class_exists(App\Observers\BannerObserver::class));"

# 2. Verify observers registered
grep -n "Article::observe" app/Providers/AppServiceProvider.php
grep -n "Activity::observe" app/Providers/AppServiceProvider.php
grep -n "Banner::observe" app/Providers/AppServiceProvider.php

# 3. Test image deletion (manual - see QA scenarios)
# 4. Test slug generation (manual - see QA scenarios)
# 5. Test toggle columns (manual - see QA scenarios)

# 6. Run linting
vendor/bin/pint --test

# 7. Verify no PHP syntax errors
php -l app/Observers/ArticleObserver.php
php -l app/Observers/ActivityObserver.php
php -l app/Observers/BannerObserver.php
```

### Final Checklist
- [x] All 3 observers created and registered
- [x] All 5 resources have helper text on form fields
- [x] Articles, Activities, Categories, Tags have slug auto-generation
- [x] Articles, Activities, Banners, Categories have ToggleColumn for booleans
- [x] All tests pass (if applicable)
- [x] No PHP syntax errors
- [x] Code follows Pint formatting standards
- [x] All QA scenarios pass

### Expected Outcome
Admin panel has modern UX with:
- Toggle switches instead of boolean icons
- Auto-generated slugs from titles
- Helpful explanations on all form fields
- Automatic cleanup of orphaned images

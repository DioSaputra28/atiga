# Frontend Website Development - Tax Consultant

## TL;DR

> **Quick Summary**: Membangun 8 halaman frontend website konsultan pajak (Atiga) dengan design berdasarkan template3.html. Menggunakan Blade layouts, dummy data realistis, dan fully responsive.
>
> **Deliverables**:
> - 3 Layout files: `app.blade.php`, `navbar.blade.php`, `footer.blade.php`
> - 8 Halaman: Beranda, Tentang Kami, Artikel, Detail Artikel, Layanan, Training, Aktifitas, Kontak
> - Controllers: `HomeController`, `PageController`, `ArticleController`, `TrainingController`, `ActivityController`
> - Routes: Indonesian URLs (`/tentang-kami`, `/layanan`, `/kontak`, etc.)
>
> **Estimated Effort**: Large (multi-page website)
> **Parallel Execution**: YES - 3 waves
> **Critical Path**: Layouts → Home → Articles → Detail Article

---

## Context

### Original Request
User ingin mengembangkan halaman customer/frontend untuk website konsultan pajak "Atiga". Admin panel sudah selesai menggunakan Filament v5. Sekarang perlu membuat:
1. Layout files (navbar, footer, app) di `resources/views/web/`
2. 8 halaman dengan design sesuai template3.html
3. Menggunakan data dummy yang realistis (bukan Lorem Ipsum)
4. Fully responsive dan mobile-friendly

### Design Source
Template: `template3.html`
- Color palette: Primary #062E3F, Accent #D8AE6C, Secondary #8DB9DC
- Font: Poppins (Google Fonts)
- Icons: Font Awesome 6.4.0
- Framework: Tailwind CSS

### Metis Review
**Identified Gaps** (addressed in this plan):
- ✅ Data source: Dummy data (hardcoded in controllers)
- ✅ URL structure: Indonesian (`/tentang-kami`, `/layanan`, etc.)
- ✅ Mobile specs: Included responsive breakpoints
- ✅ Scope exclusions: Listed explicitly
- ✅ Acceptance criteria: Executable commands provided

---

## Work Objectives

### Core Objective
Membangun frontend website konsultan pajak dengan 8 halaman lengkap, design profesional, dan user experience yang baik untuk menarik klien potensial.

### Concrete Deliverables
1. **Layout Components** (3 files)
   - `resources/views/web/layouts/app.blade.php` - Main layout wrapper
   - `resources/views/web/layouts/navbar.blade.php` - Navigation component
   - `resources/views/web/layouts/footer.blade.php` - Footer component

2. **Page Views** (8 files)
   - `resources/views/web/home.blade.php` - Beranda
   - `resources/views/web/about.blade.php` - Tentang Kami
   - `resources/views/web/articles/index.blade.php` - Daftar Artikel
   - `resources/views/web/articles/show.blade.php` - Detail Artikel
   - `resources/views/web/services.blade.php` - Layanan
   - `resources/views/web/trainings.blade.php` - Training
   - `resources/views/web/activities.blade.php` - Aktifitas
   - `resources/views/web/contact.blade.php` - Kontak

3. **Controllers** (5 files)
   - `app/Http/Controllers/Web/HomeController.php`
   - `app/Http/Controllers/Web/PageController.php`
   - `app/Http/Controllers/Web/ArticleController.php`
   - `app/Http/Controllers/Web/TrainingController.php`
   - `app/Http/Controllers/Web/ActivityController.php`

4. **Routes** - Update `routes/web.php`

### Definition of Done
- [x] Semua 8 halaman accessible via browser (return 200)
- [x] Navigation active states working
- [x] Mobile responsive (tested on mobile viewport)
- [x] No Lorem Ipsum - all content in Indonesian realistic
- [x] Design colors match template (#062E3F, #D8AE6C)
- [x] All interactive elements functional (slider, accordion)

### Must Have
- Hero slider with auto-rotation (6s interval)
- Sticky navigation
- Mobile hamburger menu
- Footer with 4 columns
- Contact page with Google Maps embed
- Article cards with thumbnails
- Accordion for regulations section
- Gallery grid with hover effects

### Must NOT Have (Guardrails)
- Search functionality
- User authentication/login
- Comment systems
- Social media sharing buttons
- Newsletter subscription
- Live chat
- Multi-language switching
- Cookie consent banner
- Contact form backend processing (dummy form only)
- Database integration (use dummy data only)
- Modifications to existing Filament admin

---

## Verification Strategy

### Test Decision
- **Infrastructure exists**: YES (Laravel 12 + Tailwind configured)
- **Automated tests**: NO (manual browser testing with Playwright)
- **Framework**: None for this frontend work

### Agent-Executed QA Scenarios (MANDATORY)

**Scenario 1: All Pages Load Successfully**
Tool: Bash (curl)
Preconditions: Server running on localhost:8000
Steps:
  1. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/ → Assert: 200
  2. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/tentang-kami → Assert: 200
  3. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/artikel → Assert: 200
  4. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/artikel/strategi-efisiensi-pajak → Assert: 200
  5. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/layanan → Assert: 200
  6. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/training → Assert: 200
  7. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/aktifitas → Assert: 200
  8. curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/kontak → Assert: 200
Expected Result: All 8 routes return HTTP 200
Evidence: Terminal output captured

**Scenario 2: Navigation Active States**
Tool: Playwright (playwright skill)
Preconditions: Dev server running
Steps:
  1. Navigate to http://localhost:8000/tentang-kami
  2. Wait for nav element: nav
  3. Assert: Link "Tentang Kami" has class "text-secondary-500" or active indicator
  4. Navigate to http://localhost:8000/layanan
  5. Assert: Link "Layanan" has active state class
  6. Screenshot: .sisyphus/evidence/nav-active-states.png
Expected Result: Current page nav item visually highlighted
Evidence: .sisyphus/evidence/nav-active-states.png

**Scenario 3: Mobile Responsive Layout**
Tool: Playwright (playwright skill)
Preconditions: Dev server running
Steps:
  1. Navigate to http://localhost:8000/
  2. Set viewport: {width: 375, height: 667} (iPhone SE)
  3. Assert: Hamburger menu icon visible (fa-bars or similar)
  4. Click hamburger menu
  5. Assert: Mobile nav dropdown/menu visible
  6. Assert: No horizontal scroll (document.body.scrollWidth <= window.innerWidth)
  7. Screenshot: .sisyphus/evidence/mobile-homepage.png
Expected Result: Mobile layout displays correctly with hamburger menu
Evidence: .sisyphus/evidence/mobile-homepage.png

**Scenario 4: Hero Slider Functionality**
Tool: Playwright (playwright skill)
Preconditions: Dev server running
Steps:
  1. Navigate to http://localhost:8000/
  2. Wait for: .slide element visible
  3. Capture first slide text content
  4. Click next slide button: #nextSlide
  5. Wait 500ms for transition
  6. Assert: Slide content changed
  7. Wait 6500ms (auto-rotation)
  8. Assert: Slide changed to next automatically
  9. Screenshot: .sisyphus/evidence/hero-slider.png
Expected Result: Slider navigable manually and auto-rotates every 6s
Evidence: .sisyphus/evidence/hero-slider.png

**Scenario 5: Color System Implementation**
Tool: Bash (grep)
Preconditions: All view files created
Steps:
  1. grep -r "#062E3F\|primary-700" resources/views/web/ → Assert: Matches found
  2. grep -r "#D8AE6C\|accent" resources/views/web/ → Assert: Matches found
  3. grep -r "Poppins" resources/views/web/layouts/app.blade.php → Assert: Font loaded
  4. grep -r "font-awesome" resources/views/web/layouts/app.blade.php → Assert: FA CDN included
Expected Result: Design system colors and fonts properly implemented
Evidence: Grep output captured

**Scenario 6: Contact Page with Maps**
Tool: Playwright (playwright skill)
Preconditions: Dev server running
Steps:
  1. Navigate to http://localhost:8000/kontak
  2. Wait for: iframe or .gmap element (timeout: 10s)
  3. Assert: Google Maps iframe present OR map placeholder visible
  4. Assert: Contact form with input fields present
  5. Assert: Contact info (address, phone, email) displayed
  6. Screenshot: .sisyphus/evidence/contact-page.png
Expected Result: Contact page has map and contact form
Evidence: .sisyphus/evidence/contact-page.png

**Scenario 7: No Placeholder Content**
Tool: Bash (grep)
Preconditions: All view files created
Steps:
  1. grep -ri "lorem ipsum" resources/views/web/ → Assert: No matches
  2. grep -ri "dolor sit amet" resources/views/web/ → Assert: No matches
  3. grep -ri "consectetur" resources/views/web/ → Assert: No matches
  4. Count Indonesian realistic words: grep -ri "pajak\|konsultan\|perusahaan\|pelatihan" resources/views/web/ | wc -l → Assert: > 20
Expected Result: No Lorem Ipsum, realistic Indonesian content
Evidence: Grep results

---

## Execution Strategy

### Parallel Execution Waves

```
Wave 1 (Foundation - Start Immediately):
├── Task 1: Create layout files (app, navbar, footer)
├── Task 2: Create controllers structure
└── Task 3: Setup routes

Wave 2 (Core Pages - After Wave 1):
├── Task 4: Homepage (Beranda) with slider
├── Task 5: About page (Tentang Kami)
└── Task 6: Contact page (Kontak) with maps

Wave 3 (Content Pages - After Wave 2):
├── Task 7: Articles listing page
├── Task 8: Article detail page
├── Task 9: Services page (Layanan)
├── Task 10: Training page
└── Task 11: Activities page

Critical Path: Task 1 → Task 4 → Task 7 → Task 8
```

### Dependency Matrix

| Task | Depends On | Blocks | Can Parallelize With |
|------|------------|--------|---------------------|
| 1 (Layouts) | None | 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 | None |
| 2 (Controllers) | None | 4, 5, 6, 7, 8, 9, 10, 11 | 1, 3 |
| 3 (Routes) | None | 4, 5, 6, 7, 8, 9, 10, 11 | 1, 2 |
| 4 (Home) | 1, 2, 3 | 7 | 5, 6 |
| 5 (About) | 1, 2, 3 | None | 4, 6 |
| 6 (Contact) | 1, 2, 3 | None | 4, 5 |
| 7 (Articles Index) | 1, 2, 3, 4 | 8 | 9, 10, 11 |
| 8 (Article Show) | 1, 2, 3, 7 | None | 9, 10, 11 |
| 9 (Services) | 1, 2, 3 | None | 7, 8, 10, 11 |
| 10 (Training) | 1, 2, 3 | None | 7, 8, 9, 11 |
| 11 (Activities) | 1, 2, 3 | None | 7, 8, 9, 10 |

---

## TODOs

### Wave 1: Foundation

- [x] 1. Create Layout Files

  **What to do**:
  - Create `resources/views/web/layouts/app.blade.php` - Main layout with:
    - HTML5 boilerplate with meta viewport
    - Poppins font from Google Fonts
    - Font Awesome 6.4.0 CDN
    - Tailwind CSS @vite directive
    - Yield sections: title, content, scripts
    - Dark mode support (from template)
  - Create `resources/views/web/layouts/navbar.blade.php` - Navigation with:
    - Top bar: Logo (scale-balanced icon) + company name "Atiga" + social icons
    - Sticky navbar: Links (Beranda, Layanan, Regulasi, Insight, Kontak)
    - CTA button: "Konsultasi Gratis"
    - Mobile hamburger menu toggle
    - Active state logic using Route::currentRouteName()
  - Create `resources/views/web/layouts/footer.blade.php` - Footer with:
    - 4 columns: Logo + description, Quick Links, Services, Contact Info
    - Social media icons
    - Copyright bar
    - Responsive grid layout

  **Must NOT do**:
  - Do NOT modify existing welcome.blade.php (will be replaced)
  - Do NOT add admin panel links in navbar
  - Do NOT use inline styles (use Tailwind classes)

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
    - Reason: Frontend layout creation requiring precise HTML/CSS structure
  - **Skills**: [`frontend-ui-ux`]
    - `frontend-ui-ux`: Design implementation and Blade templating
  - **Skills Evaluated but Omitted**:
    - `livewire-development`: Not needed for static pages
    - `pest-testing`: No automated tests required

  **Parallelization**:
  - **Can Run In Parallel**: NO (sequential file creation)
  - **Parallel Group**: Wave 1 - Task 1
  - **Blocks**: Tasks 4, 5, 6, 7, 8, 9, 10, 11
  - **Blocked By**: None

  **References**:
  - Template pattern: `template3.html:39-73` (header/nav structure)
  - Template pattern: `template3.html:354-436` (footer structure)
  - Laravel docs: Blade layouts inheritance
  - Tailwind: Responsive prefixes (sm:, md:, lg:)

  **Acceptance Criteria**:
  - [x] `resources/views/web/layouts/app.blade.php` exists
  - [x] `resources/views/web/layouts/navbar.blade.php` exists
  - [x] `resources/views/web/layouts/footer.blade.php` exists
  - [x] All layouts use `@extends` and `@section` correctly
  - [x] Poppins font loaded from Google Fonts
  - [x] Font Awesome 6.4.0 CDN included
  - [x] Tailwind classes used (no inline styles)

  **Agent-Executed QA**:
  ```
  Scenario: Layout files created correctly
    Tool: Bash
    Steps:
      1. test -f resources/views/web/layouts/app.blade.php → Assert: exit 0
      2. test -f resources/views/web/layouts/navbar.blade.php → Assert: exit 0
      3. test -f resources/views/web/layouts/footer.blade.php → Assert: exit 0
      4. grep -q "@yield('content')" resources/views/web/layouts/app.blade.php → Assert: match
      5. grep -q "fonts.googleapis.com" resources/views/web/layouts/app.blade.php → Assert: match
      6. grep -q "font-awesome" resources/views/web/layouts/app.blade.php → Assert: match
  ```

  **Commit**: YES
  - Message: `feat(frontend): add base layout files`
  - Files: `resources/views/web/layouts/*`

- [x] 2. Create Controllers

  **What to do**:
  - Create `app/Http/Controllers/Web/HomeController.php`:
    - Method: `index()` - returns view with dummy data for homepage
    - Dummy data: 3 slider items, 6 articles, 4 gallery images
  - Create `app/Http/Controllers/Web/PageController.php`:
    - Method: `about()` - Tentang Kami page
    - Method: `services()` - Layanan page
    - Method: `contact()` - Kontak page
  - Create `app/Http/Controllers/Web/ArticleController.php`:
    - Method: `index()` - Articles listing with dummy array
    - Method: `show($slug)` - Single article detail
  - Create `app/Http/Controllers/Web/TrainingController.php`:
    - Method: `index()` - Training list with dummy data
  - Create `app/Http/Controllers/Web/ActivityController.php`:
    - Method: `index()` - Activities gallery with dummy data

  **Dummy Data Structure**:
  ```php
  // Articles array (8 items)
  [
      [
          'title' => 'Strategi Efisiensi Pajak 2026 untuk Perusahaan Menengah dan Besar',
          'slug' => 'strategi-efisiensi-pajak-2026',
          'excerpt' => 'Panduan lengkap untuk mengoptimalkan beban pajak perusahaan sesuai regulasi terbaru...',
          'content' => 'Full article content here...',
          'thumbnail' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800',
          'category' => 'Tax Update',
          'published_at' => '12 Februari 2026',
          'views' => 1250,
          'author' => 'Tim Ahli Pajak Atiga'
      ],
      // ... 7 more articles with realistic titles
  ]

  // Services array (6 items)
  [
      ['name' => 'Konsultasi Pajak', 'icon' => 'fa-calculator', 'description' => '...'],
      ['name' => 'Pendampingan Pemeriksaan', 'icon' => 'fa-shield-alt', 'description' => '...'],
      // ... 4 more
  ]

  // Trainings array (4 items)
  [
      [
          'title' => 'Workshop Coretax System untuk Perusahaan',
          'date' => '15 Maret 2026',
          'location' => 'Jakarta Convention Center',
          'price' => 'Rp 2.500.000',
          'image' => 'https://images.unsplash.com/photo-1544531586-fde5298cdd40?w=600'
      ],
      // ... 3 more
  ]
  ```

  **Must NOT do**:
  - Do NOT query database (use hardcoded arrays)
  - Do NOT create Form Requests
  - Do NOT add authentication middleware

  **Recommended Agent Profile**:
  - **Category**: `quick`
    - Reason: Straightforward controller creation with dummy data
  - **Skills**: []
    - No special skills needed for basic controllers

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Task 1 and 3)
  - **Parallel Group**: Wave 1
  - **Blocks**: Tasks 4-11
  - **Blocked By**: None

  **References**:
  - Laravel docs: Controllers structure
  - Existing: `app/Http/Controllers/` for namespace pattern

  **Acceptance Criteria**:
  - [x] All 5 controller files exist in `app/Http/Controllers/Web/`
  - [x] Each controller returns view with dummy data array
  - [x] Dummy data uses realistic Indonesian content
  - [x] No database queries (Eloquent/DB facade not used)

  **Agent-Executed QA**:
  ```
  Scenario: Controllers created with dummy data
    Tool: Bash
    Steps:
      1. test -f app/Http/Controllers/Web/HomeController.php → Assert: exit 0
      2. grep -q "return view('web.home'" app/Http/Controllers/Web/HomeController.php → Assert: match
      3. grep -q "'title' => '" app/Http/Controllers/Web/HomeController.php → Assert: match
      4. grep -q "'pajak\|perusahaan\|pelatihan'" app/Http/Controllers/Web/*.php → Assert: match
  ```

  **Commit**: YES
  - Message: `feat(frontend): add web controllers with dummy data`
  - Files: `app/Http/Controllers/Web/*`

- [x] 3. Setup Routes

  **What to do**:
  Update `routes/web.php`:
  ```php
  use App\Http\Controllers\Web\HomeController;
  use App\Http\Controllers\Web\PageController;
  use App\Http\Controllers\Web\ArticleController;
  use App\Http\Controllers\Web\TrainingController;
  use App\Http\Controllers\Web\ActivityController;

  // Home
  Route::get('/', [HomeController::class, 'index'])->name('home');

  // Static Pages
  Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
  Route::get('/layanan', [PageController::class, 'services'])->name('services');
  Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

  // Articles
  Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
  Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

  // Training
  Route::get('/training', [TrainingController::class, 'index'])->name('trainings.index');

  // Activities
  Route::get('/aktifitas', [ActivityController::class, 'index'])->name('activities.index');
  ```

  **Must NOT do**:
  - Do NOT use English URLs (use `/tentang-kami` not `/about`)
  - Do NOT add middleware
  - Do NOT modify Filament routes

  **Recommended Agent Profile**:
  - **Category**: `quick`
  - **Skills**: []

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Task 1 and 2)
  - **Parallel Group**: Wave 1
  - **Blocks**: Tasks 4-11
  - **Blocked By**: None

  **Acceptance Criteria**:
  - [x] `routes/web.php` updated with 8 route definitions
  - [x] All routes use Indonesian URLs
  - [x] Named routes defined

  **Agent-Executed QA**:
  ```
  Scenario: All routes registered
    Tool: Bash
    Steps:
      1. php artisan route:list | grep -c "web" → Assert: >= 8
      2. php artisan route:list | grep -q "tentang-kami" → Assert: match
      3. php artisan route:list | grep -q "artikel/{slug}" → Assert: match
  ```

  **Commit**: YES
  - Message: `feat(frontend): add web routes`
  - Files: `routes/web.php`

---

### Wave 2: Core Pages

- [x] 4. Homepage (Beranda)

  **What to do**:
  Create `resources/views/web/home.blade.php` extending app layout:
  
  **Sections to implement**:
  1. **Hero Slider** (from template3.html:78-112):
     - 3 slides with different images and content
     - Auto-rotation every 6 seconds
     - Prev/Next buttons
     - Gradient overlay on images
     - Category badges (Tax Update, Tax Insight, Transfer Pricing)
     - Large headline text
  
  2. **Featured Articles Grid** (2 cards side by side):
     - Large cards with image background
     - Category badge overlay
     - Title overlay
  
  3. **Main Content Area** (lg:col-span-2):
     - 2-3 article cards (horizontal layout)
     - Regulasi Pajak accordion section (4 items)
     - 3 more article cards
  
  4. **Sidebar** (lg:col-span-1):
     - Rekomendasi Artikel widget (5 small cards)
     - CTA card (gradient background)
  
  5. **Galeri Kegiatan**:
     - 4-column grid
     - Square images with hover overlay
     - Scale animation on hover

  **JavaScript needed**:
  - Slider auto-rotation (setInterval 6000ms)
  - Slide navigation (next/prev)
  - Accordion toggle functionality

  **Must NOT do**:
  - Do NOT make slider infinite loop complex (simple modulo is fine)
  - Do NOT add lazy loading

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 5, 6)
  - **Parallel Group**: Wave 2
  - **Blocks**: Task 7 (shares article component patterns)
  - **Blocked By**: Tasks 1, 2, 3

  **References**:
  - Template: `template3.html:75-351`
  - Components: Use `navbar.blade.php`, `footer.blade.php`

  **Acceptance Criteria**:
  - [x] Hero slider with 3 slides functional
  - [x] Auto-rotation every 6 seconds
  - [x] Manual navigation works
  - [x] Accordion expands/collapses
  - [x] Gallery hover effects work
  - [x] Mobile responsive layout

  **Agent-Executed QA**:
  ```
  Scenario: Homepage complete and functional
    Tool: Playwright
    Steps:
      1. Navigate to http://localhost:8000/
      2. Wait for: .slide (timeout: 5s)
      3. Assert: At least 3 .slide elements present
      4. Click: #nextSlide
      5. Wait 500ms
      6. Assert: Active slide changed (opacity-100 class moved)
      7. Click: .accordion-trigger (first)
      8. Assert: Accordion content visible (no 'hidden' class)
      9. Hover: .group (gallery item)
      10. Assert: Overlay opacity changes
      11. Screenshot: .sisyphus/evidence/homepage.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add homepage with slider and sections`
  - Files: `resources/views/web/home.blade.php`

- [x] 5. About Page (Tentang Kami)

  **What to do**:
  Create `resources/views/web/about.blade.php`:
  
  **Sections**:
  1. **Hero Banner**:
     - Background image with overlay
     - Page title: "Tentang Kami"
     - Breadcrumb: Beranda > Tentang Kami
  
  2. **Company Overview**:
     - Heading: "Atiga - Konsultan Pajak Terpercaya"
     - Paragraph about company (realistic content)
     - Stats: Years of experience, Clients served, Success rate
  
  3. **Vision & Mission**:
     - Two columns
     - Vision statement
     - Mission points (bullet list)
  
  4. **Our Team/Expertise**:
     - Grid of 4 expert cards
     - Photo placeholder, Name, Title, Brief bio
  
  5. **Why Choose Us**:
     - 4 feature cards with icons
     - Professional, Trusted, Experienced, Client-focused

  **Dummy Data**:
  - Company founded: 2015
  - Clients: 500+
  - Team members: 4 experts
  - Success rate: 98%

  **Must NOT do**:
  - Do NOT add actual team photos (use placeholders)
  - Do NOT make team section dynamic

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 4, 6)
  - **Parallel Group**: Wave 2
  - **Blocks**: None
  - **Blocked By**: Tasks 1, 2, 3

  **Acceptance Criteria**:
  - [x] All 5 sections present
  - [x] Realistic Indonesian content
  - [x] Team cards with placeholder images
  - [x] Stats displayed prominently

  **Agent-Executed QA**:
  ```
  Scenario: About page loads with all sections
    Tool: Bash + Playwright
    Steps:
      1. curl -s http://localhost:8000/tentang-kami | grep -q "Tentang Kami" → Assert: match
      2. curl -s http://localhost:8000/tentang-kami | grep -q "Atiga" → Assert: match
      3. Navigate to /tentang-kami
      4. Assert: h1 contains "Tentang Kami"
      5. Assert: At least 4 team member cards present
      6. Screenshot: .sisyphus/evidence/about-page.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add about page`
  - Files: `resources/views/web/about.blade.php`

- [x] 6. Contact Page (Kontak)

  **What to do**:
  Create `resources/views/web/contact.blade.php`:
  
  **Sections**:
  1. **Hero Banner**:
     - Page title: "Hubungi Kami"
  
  2. **Contact Grid** (2 columns on desktop):
     - **Left Column - Contact Form**:
       - Name input
       - Email input
       - Phone input
       - Subject select (Konsultasi, Pelatihan, Lainnya)
       - Message textarea
       - Submit button (dummy - no backend)
     - **Right Column - Contact Info**:
       - Address with icon (Jl. Sudirman No. 123, Jakarta)
       - Phone with icon (+62 21 1234 5678)
       - Email with icon (info@atiga.co.id)
       - Working hours with icon (Senin-Jumat: 08:00-17:00)
       - Social media links
  
  3. **Google Maps Section**:
     - Full-width map embed
     - Use Google Maps embed iframe
     - Coordinates for Jakarta (or placeholder)

  **Form Fields**:
  - All fields required (HTML5 validation)
  - Client-side validation only (no backend processing)
  - Form submits to # (dummy)

  **Must NOT do**:
  - Do NOT add form backend processing
  - Do NOT add CSRF token (form doesn't submit)

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 4, 5)
  - **Parallel Group**: Wave 2
  - **Blocks**: None
  - **Blocked By**: Tasks 1, 2, 3

  **References**:
  - Template: `template3.html:402-421` (contact info pattern)
  - Google Maps embed documentation

  **Acceptance Criteria**:
  - [x] Contact form with all fields
  - [x] Contact info with icons
  - [x] Google Maps iframe embedded
  - [x] Form validation (HTML5 required)

  **Agent-Executed QA**:
  ```
  Scenario: Contact page with map and form
    Tool: Playwright
    Steps:
      1. Navigate to http://localhost:8000/kontak
      2. Assert: h1 contains "Hubungi Kami"
      3. Assert: iframe (Google Maps) present OR placeholder div
      4. Assert: Input name="name" present
      5. Assert: Input name="email" present
      6. Assert: Textarea name="message" present
      7. Assert: Button type="submit" present
      8. Screenshot: .sisyphus/evidence/contact-page.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add contact page with map`
  - Files: `resources/views/web/contact.blade.php`

---

### Wave 3: Content Pages

- [x] 7. Articles Index Page

  **What to do**:
  Create `resources/views/web/articles/index.blade.php`:
  
  **Sections**:
  1. **Hero Banner**:
     - Title: "Artikel & Insight"
     - Subtitle: "Update perpajakan dan tips bisnis"
  
  2. **Main Content** (lg:col-span-2):
     - Grid of article cards (2 columns on desktop)
     - Each card: Thumbnail, Category badge, Title, Excerpt, Date, Read more link
     - Pagination (simple prev/next or load more)
  
  3. **Sidebar** (lg:col-span-1):
     - Search box (dummy - no functionality)
     - Categories widget
     - Popular articles widget

  **Dummy Data**: 8-10 articles passed from controller

  **Must NOT do**:
  - Do NOT add actual search functionality
  - Do NOT add category filtering (display only)

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 8, 9, 10, 11)
  - **Parallel Group**: Wave 3
  - **Blocks**: Task 8 (shares article card component)
  - **Blocked By**: Tasks 1, 2, 3, 4

  **Acceptance Criteria**:
  - [x] 8-10 article cards displayed
  - [x] Grid layout (2 columns desktop)
  - [x] Each card links to detail page
  - [x] Sidebar widgets present

  **Agent-Executed QA**:
  ```
  Scenario: Articles listing page
    Tool: Playwright
    Steps:
      1. Navigate to http://localhost:8000/artikel
      2. Assert: h1 contains "Artikel"
      3. Count article cards → Assert: >= 6
      4. Click first article link
      5. Assert: URL contains "/artikel/"
      6. Screenshot: .sisyphus/evidence/articles-index.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add articles listing page`
  - Files: `resources/views/web/articles/index.blade.php`

- [x] 8. Article Detail Page

  **What to do**:
  Create `resources/views/web/articles/show.blade.php`:
  
  **Sections**:
  1. **Article Header**:
     - Full-width featured image
     - Category badge
     - Title (large)
     - Meta: Author, Date, Views
  
  2. **Content Area** (lg:col-span-2):
     - Article body (rich text content)
     - Share buttons (dummy)
     - Tags
  
  3. **Sidebar** (lg:col-span-1):
     - Author info card
     - Related articles (3 items)
     - Categories

  **Dummy Data**: Single article by slug

  **Must NOT do**:
  - Do NOT add comments section
  - Do NOT add social sharing functionality

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 7, 9, 10, 11)
  - **Parallel Group**: Wave 3
  - **Blocks**: None
  - **Blocked By**: Tasks 1, 2, 3, 7

  **Acceptance Criteria**:
  - [x] Article displays with all fields
  - [x] Sidebar with related articles
  - [x] Navigation back to articles list

  **Agent-Executed QA**:
  ```
  Scenario: Article detail page
    Tool: Playwright
    Steps:
      1. Navigate to http://localhost:8000/artikel/strategi-efisiensi-pajak-2026
      2. Assert: h1 contains article title
      3. Assert: Featured image present
      4. Assert: Article content visible
      5. Assert: Sidebar with related articles
      6. Screenshot: .sisyphus/evidence/article-detail.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add article detail page`
  - Files: `resources/views/web/articles/show.blade.php`

- [x] 9. Services Page (Layanan)

  **What to do**:
  Create `resources/views/web/services.blade.php`:
  
  **Sections**:
  1. **Hero Banner**:
     - Title: "Layanan Kami"
     - Subtitle about services
  
  2. **Services Grid** (3 columns on desktop):
     - 6 service cards:
       1. Konsultasi Pajak
       2. Pendampingan Pemeriksaan
       3. Transfer Pricing
       4. Tax Planning
       5. Sengketa Pajak
       6. Pelatihan Perpajakan
     - Each card: Icon, Title, Description, Learn more link
  
  3. **Process Section**:
     - 4-step workflow (Konsultasi → Analisis → Solusi → Implementasi)
     - Visual timeline or numbered steps
  
  4. **CTA Section**:
     - Full-width banner
     - "Butuh Bantuan Pajak?" heading
     - Contact button

  **Dummy Data**: 6 services array from controller

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 7, 8, 10, 11)
  - **Parallel Group**: Wave 3
  - **Blocks**: None
  - **Blocked By**: Tasks 1, 2, 3

  **Acceptance Criteria**:
  - [x] 6 service cards displayed
  - [x] Process section with 4 steps
  - [x] CTA section at bottom

  **Agent-Executed QA**:
  ```
  Scenario: Services page
    Tool: Bash
    Steps:
      1. curl -s http://localhost:8000/layanan | grep -q "Layanan Kami" → Assert: match
      2. curl -s http://localhost:8000/layanan | grep -c "Konsultasi\|Transfer\|Planning" → Assert: >= 3
      3. Screenshot via Playwright
  ```

  **Commit**: YES
  - Message: `feat(frontend): add services page`
  - Files: `resources/views/web/services.blade.php`

- [x] 10. Training Page

  **What to do**:
  Create `resources/views/web/trainings.blade.php`:
  
  **Sections**:
  1. **Hero Banner**:
     - Title: "Pelatihan Perpajakan"
     - Subtitle about training programs
  
  2. **Upcoming Trainings**:
     - List of training cards
     - Each card: Image, Title, Date, Location, Price, Register button
     - Highlight featured training
  
  3. **Why Our Training**:
     - 4 benefits with icons
  
  4. **Past Trainings**:
     - Gallery of past events (optional)

  **Dummy Data**: 4 upcoming trainings

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 7, 8, 9, 11)
  - **Parallel Group**: Wave 3
  - **Blocks**: None
  - **Blocked By**: Tasks 1, 2, 3

  **Acceptance Criteria**:
  - [x] Training cards with all info
  - [x] Date and price displayed
  - [x] Register buttons (dummy)

  **Agent-Executed QA**:
  ```
  Scenario: Training page
    Tool: Playwright
    Steps:
      1. Navigate to http://localhost:8000/training
      2. Assert: h1 contains "Pelatihan"
      3. Count training cards → Assert: >= 3
      4. Screenshot: .sisyphus/evidence/training-page.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add training page`
  - Files: `resources/views/web/trainings.blade.php`

- [x] 11. Activities Page

  **What to do**:
  Create `resources/views/web/activities.blade.php`:
  
  **Sections**:
  1. **Hero Banner**:
     - Title: "Aktifitas Kami"
     - Subtitle about company activities
  
  2. **Activities Gallery**:
     - Masonry or grid layout (3-4 columns)
     - Activity cards with image
     - Title and date overlay on hover
     - Categories/tabs (Seminar, Workshop, Training, Client Meeting)
  
  3. **Highlight Section**:
     - Featured activity with large image
     - Description

  **Dummy Data**: 8-12 activity images with titles

  **Recommended Agent Profile**:
  - **Category**: `visual-engineering`
  - **Skills**: [`frontend-ui-ux`]

  **Parallelization**:
  - **Can Run In Parallel**: YES (with Tasks 7, 8, 9, 10)
  - **Parallel Group**: Wave 3
  - **Blocks**: None
  - **Blocked By**: Tasks 1, 2, 3

  **Acceptance Criteria**:
  - [x] Gallery grid with hover effects
  - [x] 8-12 activity items
  - [x] Category tabs (visual only)

  **Agent-Executed QA**:
  ```
  Scenario: Activities page
    Tool: Playwright
    Steps:
      1. Navigate to http://localhost:8000/aktifitas
      2. Assert: h1 contains "Aktifitas"
      3. Count gallery items → Assert: >= 8
      4. Hover first item → Assert: Overlay visible
      5. Screenshot: .sisyphus/evidence/activities-page.png
  ```

  **Commit**: YES
  - Message: `feat(frontend): add activities page`
  - Files: `resources/views/web/activities.blade.php`

---

## Commit Strategy

| After Task | Message | Files | Verification |
|------------|---------|-------|--------------|
| 1 | `feat(frontend): add base layout files` | `resources/views/web/layouts/*` | View files exist |
| 2 | `feat(frontend): add web controllers with dummy data` | `app/Http/Controllers/Web/*` | Controllers return views |
| 3 | `feat(frontend): add web routes` | `routes/web.php` | Route list shows 8+ routes |
| 4 | `feat(frontend): add homepage with slider and sections` | `resources/views/web/home.blade.php` | Slider works |
| 5 | `feat(frontend): add about page` | `resources/views/web/about.blade.php` | Page loads |
| 6 | `feat(frontend): add contact page with map` | `resources/views/web/contact.blade.php` | Map visible |
| 7 | `feat(frontend): add articles listing page` | `resources/views/web/articles/index.blade.php` | Articles display |
| 8 | `feat(frontend): add article detail page` | `resources/views/web/articles/show.blade.php` | Detail loads |
| 9 | `feat(frontend): add services page` | `resources/views/web/services.blade.php` | Services grid |
| 10 | `feat(frontend): add training page` | `resources/views/web/trainings.blade.php` | Trainings listed |
| 11 | `feat(frontend): add activities page` | `resources/views/web/activities.blade.php` | Gallery works |

---

## Success Criteria

### Verification Commands
```bash
# 1. All routes return 200
for route in / /tentang-kami /artikel /artikel/strategi-efisiensi-pajak-2026 /layanan /training /aktifitas /kontak; do
  echo "Testing $route:"
  curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8000$route
done

# 2. Layout files exist
ls -la resources/views/web/layouts/

# 3. Controllers exist
ls -la app/Http/Controllers/Web/

# 4. No Lorem Ipsum
grep -ri "lorem ipsum" resources/views/web/ || echo "PASS: No placeholder text"

# 5. Design colors used
grep -r "#062E3F\|primary-700" resources/views/web/ | wc -l
grep -r "#D8AE6C" resources/views/web/ | wc -l
```

### Final Checklist
- [x] All 8 pages accessible (HTTP 200)
- [x] Navigation active states work
- [x] Mobile responsive (tested)
- [x] Hero slider auto-rotates
- [x] Accordion expands/collapses
- [x] Gallery hover effects work
- [x] Contact page has map
- [x] No Lorem Ipsum content
- [x] All text in Indonesian
- [x] Design matches template colors
- [x] Poppins font loaded
- [x] Font Awesome icons display

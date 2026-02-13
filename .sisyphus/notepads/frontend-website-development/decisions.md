# Frontend Website Development - Blade + Tailwind Layout Best Practices

## Date: 2026-02-13
## Context: Multi-page public website with shared navbar/footer

---

## 1. BLADE LAYOUT ARCHITECTURE DECISIONS

### A. Layout Strategy: Components Over Template Inheritance (Recommended)

**Official Laravel 12 Position:**
- Modern Laravel favors **Blade Components** over `@extends`/`@yield`/`@section` for layouts
- Components offer better data/attribute binding and are more maintainable
- However, template inheritance is still fully supported for legacy apps

**Source:** Laravel 12.x Documentation - Blade > Building Layouts

### B. Recommended Layout Structure

```
resources/views/
├── layouts/
│   ├── web.blade.php          # Main public website layout
│   └── app.blade.php          # Admin/app layout (if needed)
├── components/
│   ├── nav-link.blade.php     # Reusable nav link component
│   └── mobile-menu.blade.php  # Mobile menu component
├── partials/
│   ├── navbar.blade.php       # Navbar partial
│   └── footer.blade.php       # Footer partial
└── web/                       # Public page views
    ├── home.blade.php
    ├── about.blade.php
    └── contact.blade.php
```

### C. Layout Using Components (Modern Approach)

```blade
{{-- resources/views/layouts/web.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased">
    @include('partials.navbar')
    
    <main>
        {{ $slot }}
    </main>
    
    @include('partials.footer')
    
    @stack('scripts')
</body>
</html>
```

**Key Directives:**
- `@stack('styles')` / `@stack('scripts')` - For pushing page-specific CSS/JS from child views
- `@include('partials.navbar')` - Reusable partials for shared components
- `{{ $slot }}` - Default content slot

**Source:** Laravel 12.x Documentation - Blade > Stacks

---

## 2. ROUTE NAMING & ACTIVE LINK PATTERNS

### A. Route Naming Best Practices

**DO:**
```php
// routes/web.php
Route::get('/', [HomeController::class, 'index'])->name('web.home');
Route::get('/about', [AboutController::class, 'index'])->name('web.about');
Route::get('/contact', [ContactController::class, 'index'])->name('web.contact');
Route::get('/services', [ServiceController::class, 'index'])->name('web.services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('web.services.show');
```

**Rationale:**
- Use `web.` prefix for public routes to avoid collision with admin routes
- Use resource-style naming even for non-resource controllers
- Enables `request()->routeIs('web.services.*')` pattern matching

### B. Active Link Detection Methods

**Method 1: Inline in Blade (Simplest)**
```blade
<a href="{{ route('web.about') }}" 
   class="{{ request()->routeIs('web.about') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
   About
</a>
```

**Method 2: Wildcard Pattern Matching**
```blade
{{-- Matches web.services.index, web.services.show, etc. --}}
<a href="{{ route('web.services.index') }}" 
   class="{{ request()->routeIs('web.services.*') ? 'text-blue-600' : 'text-gray-600' }}">
   Services
</a>
```

**Method 3: Multiple Route Patterns**
```blade
{{-- Active for multiple route groups --}}
<a href="{{ route('web.about') }}" 
   class="{{ request()->routeIs(['web.about', 'web.team.*', 'web.careers.*']) ? 'text-blue-600' : 'text-gray-600' }}">
   Company
</a>
```

**Method 4: NavLink Component (Recommended for Reusability)**

```php
<?php
// app/View/Components/NavLink.php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class NavLink extends Component
{
    public bool $isActive = false;

    public function __construct(
        public string $href,
        public ?string $active = null,
        public bool $exact = false
    ) {
        $this->isActive = $this->checkActive();
    }

    protected function checkActive(): bool
    {
        if ($this->active === null) {
            return request()->is(trim($this->href, '/'));
        }
        
        return request()->routeIs($this->active);
    }

    public function render()
    {
        return view('components.nav-link');
    }
}
```

```blade
{{-- resources/views/components/nav-link.blade.php --}}
@php
$classes = $isActive 
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
```

**Usage:**
```blade
<x-nav-link href="{{ route('web.home') }}" active="web.home">Home</x-nav-link>
<x-nav-link href="{{ route('web.services.index') }}" active="web.services.*">Services</x-nav-link>
```

**Source:** Laravel 12.x Documentation - Routing > Accessing Current Route
**Reference:** Laravel Daily - "Laravel: Active Menu Item By Route Name or URL"

---

## 3. TAILWIND RESPONSIVE NAVIGATION PATTERNS

### A. Breakpoint Strategy

**Mobile-First Approach (Tailwind Default):**
```blade
{{-- Mobile styles first (no prefix), then override at breakpoints --}}
<nav class="bg-white shadow">
    {{-- Hidden on mobile, flex on medium+ screens --}}
    <div class="hidden md:flex space-x-8">
        <x-nav-link href="{{ route('web.home') }}">Home</x-nav-link>
        <x-nav-link href="{{ route('web.about') }}">About</x-nav-link>
    </div>
    
    {{-- Mobile menu button - visible only on small screens --}}
    <div class="flex md:hidden">
        <button type="button" class="...">
            {{-- Hamburger icon --}}
        </button>
    </div>
</nav>
```

**Standard Tailwind Breakpoints:**
| Prefix | Min Width | Usage |
|--------|-----------|-------|
| `sm:` | 640px | Large phones |
| `md:` | 768px | Tablets |
| `lg:` | 1024px | Laptops |
| `xl:` | 1280px | Desktops |
| `2xl:` | 1536px | Large screens |

**Source:** Tailwind CSS v4 Documentation - Responsive Design

### B. Responsive Navbar Pattern

```blade
{{-- resources/views/partials/navbar.blade.php --}}
<nav class="bg-white shadow" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('web.home') }}">
                        <img class="h-8 w-auto" src="/logo.svg" alt="Logo">
                    </a>
                </div>
                
                {{-- Desktop Navigation --}}
                <div class="hidden md:ml-6 md:flex md:space-x-8">
                    <x-nav-link href="{{ route('web.home') }}" active="web.home">Home</x-nav-link>
                    <x-nav-link href="{{ route('web.about') }}" active="web.about">About</x-nav-link>
                    <x-nav-link href="{{ route('web.services.index') }}" active="web.services.*">Services</x-nav-link>
                    <x-nav-link href="{{ route('web.contact') }}" active="web.contact">Contact</x-nav-link>
                </div>
            </div>
            
            {{-- Mobile menu button --}}
            <div class="flex items-center md:hidden">
                <button @click="open = !open" type="button" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open main menu</span>
                    {{-- Icon when menu is closed --}}
                    <svg x-show="!open" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    {{-- Icon when menu is open --}}
                    <svg x-show="open" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Mobile menu --}}
    <div x-show="open" class="md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('web.home') }}" 
               class="{{ request()->routeIs('web.home') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Home
            </a>
            {{-- Additional mobile links... --}}
        </div>
    </div>
</nav>
```

**Key Tailwind Classes for Navbars:**
- `hidden md:flex` - Hide on mobile, show on desktop
- `md:hidden` - Show on mobile, hide on desktop
- `max-w-7xl mx-auto` - Container with max width, centered
- `px-4 sm:px-6 lg:px-8` - Responsive padding (mobile → tablet → desktop)

**Source:** Tailwind UI Official Components - Navigation > Navbars

---

## 4. DO'S AND DON'TS

### ✅ DO

1. **Use named routes** - Always use `->name('web.page')` for URL generation and active state
2. **Prefix public routes** with `web.` to avoid collision with admin/app routes
3. **Use Blade Components** for reusable UI elements (NavLink, Button, etc.)
4. **Use `@stack`** for page-specific CSS/JS that needs to be in head/body end
5. **Use `request()->routeIs()`** for active link detection (supports wildcards)
6. **Mobile-first CSS** - Write base styles for mobile, override with `md:`, `lg:` prefixes
7. **Use `max-w-7xl mx-auto`** for consistent container width
8. **Include viewport meta tag** - Required for responsive design

### ❌ DON'T

1. **Don't use `@extends`/`@section` for new projects** - Use components instead
2. **Don't hardcode URLs** - Always use `route()` helper
3. **Don't check `Request::url()` for active state** - Use `routeIs()` for flexibility
4. **Don't skip the viewport meta tag** - Breaks mobile responsiveness
5. **Don't use `sm:` for mobile targeting** - Unprefixed = mobile, `sm:` = 640px+
6. **Don't forget accessibility** - Include `sr-only` text for icon buttons

---

## 5. RECOMMENDED VIEW COMPOSER PATTERN

For complex navigation that needs data (e.g., dynamic menu items):

```php
<?php
// app/Providers/ViewServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('partials.navbar', function ($view) {
            $view->with('navItems', [
                ['label' => 'Home', 'route' => 'web.home'],
                ['label' => 'About', 'route' => 'web.about'],
                ['label' => 'Services', 'route' => 'web.services.index'],
                ['label' => 'Contact', 'route' => 'web.contact'],
            ]);
        });
    }
}
```

Then in navbar:
```blade
@foreach($navItems as $item)
    <x-nav-link href="{{ route($item['route']) }}" active="{{ $item['route'] }}">
        {{ $item['label'] }}
    </x-nav-link>
@endforeach
```

---

## 6. TYPICAL PAGE VIEW STRUCTURE

```blade
{{-- resources/views/web/about.blade.php --}}
<x-web-layout>
    <x-slot:title>About Us - {{ config('app.name') }}</x-slot>
    
    @push('styles')
        {{-- Page-specific CSS --}}
    @endpush
    
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900">About Us</h1>
        {{-- Content --}}
    </div>
    
    @push('scripts')
        {{-- Page-specific JS --}}
    @endpush
</x-web-layout>
```

---

## 7. OFFICIAL REFERENCE LINKS

### Laravel Documentation
- **Blade Templates:** https://laravel.com/docs/12.x/blade
- **Routing:** https://laravel.com/docs/12.x/routing
- **Views:** https://laravel.com/docs/12.x/views
- **View Components:** https://laravel.com/docs/12.x/blade#components

### Tailwind CSS Documentation
- **Responsive Design:** https://tailwindcss.com/docs/responsive-design
- **Container:** https://tailwindcss.com/docs/container
- **Flexbox:** https://tailwindcss.com/docs/flex

### Tailwind UI (Official Components)
- **Navbars:** https://tailwindui.com/components/application-ui/navigation/navbars


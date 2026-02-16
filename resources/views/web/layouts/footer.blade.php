@php
    $companyName = site_company_name('Atiga');
    $companyLogo = site_company_logo();
    $companyLogoUrl = null;

    if (filled($companyLogo)) {
        $companyLogoUrl = str_starts_with($companyLogo, 'http://') || str_starts_with($companyLogo, 'https://')
            ? $companyLogo
            : \Illuminate\Support\Facades\Storage::url($companyLogo);
    }
@endphp

<footer class="mt-16 bg-primary-700 text-white">
    <div class="mx-auto max-w-7xl px-3 py-8 sm:px-4 sm:py-10 lg:py-12">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8 lg:grid-cols-4">
            <div>
                <div class="mb-3 flex items-center gap-2.5 sm:mb-4 sm:gap-3">
                    @if ($companyLogoUrl)
                        <img src="{{ $companyLogoUrl }}" alt="{{ $companyName }}" class="h-9 w-9 rounded-lg object-cover sm:h-10 sm:w-10">
                    @else
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-accent text-primary-700 sm:h-10 sm:w-10">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                    @endif
                    <div>
                        <p class="text-base font-extrabold sm:text-lg">{{ $companyName }}</p>
                        <p class="text-xs leading-5 text-white/70">Konsultan Pajak & Kepatuhan Bisnis</p>
                    </div>
                </div>
                <p class="text-sm leading-6 text-white/70">Mitra terpercaya dalam solusi perpajakan untuk perusahaan dan individu.</p>
                <div class="mt-4 flex gap-2">
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-youtube text-sm"></i></a>
                </div>
            </div>

            <div>
                <h5 class="mb-3 text-base font-semibold sm:mb-4 sm:text-lg">Tautan</h5>
                <ul class="space-y-1.5 text-sm leading-6 text-white/70 sm:space-y-2">
                    <li><a href="{{ Route::has('home') ? route('home', [], false) : '#' }}" class="block px-1 py-2 hover:text-accent sm:px-0">Beranda</a></li>
                    <li><a href="{{ Route::has('services') ? route('services', [], false) : '#' }}" class="block px-1 py-2 hover:text-accent sm:px-0">Layanan</a></li>
                    <li><a href="{{ Route::has('articles.index') ? route('articles.index', [], false) : '#' }}" class="block px-1 py-2 hover:text-accent sm:px-0">Artikel</a></li>
                    <li><a href="{{ Route::has('contact') ? route('contact', [], false) : '#' }}" class="block px-1 py-2 hover:text-accent sm:px-0">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h5 class="mb-3 text-base font-semibold sm:mb-4 sm:text-lg">Layanan</h5>
                <ul class="space-y-1.5 text-sm leading-6 text-white/70 sm:space-y-2">
                    <li><a href="#" class="block px-1 py-2 hover:text-accent sm:px-0">Konsultasi Pajak</a></li>
                    <li><a href="#" class="block px-1 py-2 hover:text-accent sm:px-0">Transfer Pricing</a></li>
                    <li><a href="#" class="block px-1 py-2 hover:text-accent sm:px-0">Tax Planning</a></li>
                    <li><a href="#" class="block px-1 py-2 hover:text-accent sm:px-0">Sengketa Pajak</a></li>
                </ul>
            </div>

            <div>
                <h5 class="mb-3 text-base font-semibold sm:mb-4 sm:text-lg">Hubungi Kami</h5>
                <ul class="space-y-3 text-sm leading-6 text-white/70">
                    <li class="flex items-start gap-2.5 sm:gap-3"><i class="fa-solid fa-location-dot mt-1 text-accent"></i><span>Jl. Sudirman No. 123, Jakarta</span></li>
                    <li class="flex items-center gap-2.5 sm:gap-3"><i class="fa-solid fa-phone text-accent"></i><span>+62 21 1234 5678</span></li>
                    <li class="flex items-center gap-2.5 sm:gap-3"><i class="fa-solid fa-envelope text-accent"></i><span>info@atiga.id</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-8 border-t border-white/10 pt-5 sm:mt-10 sm:pt-6">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <p class="text-center text-xs leading-5 text-white/50 sm:text-left sm:text-sm">&copy; {{ date('Y') }} Atiga. Hak Cipta Dilindungi.</p>
                <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-white/50 sm:gap-6 sm:text-sm">
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>

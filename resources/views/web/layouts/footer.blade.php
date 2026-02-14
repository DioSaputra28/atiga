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
    <div class="mx-auto max-w-7xl px-4 py-12">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="mb-4 flex items-center gap-3">
                    @if ($companyLogoUrl)
                        <img src="{{ $companyLogoUrl }}" alt="{{ $companyName }}" class="h-10 w-10 rounded-lg object-cover">
                    @else
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent text-primary-700">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                    @endif
                    <div>
                        <p class="text-lg font-extrabold">{{ $companyName }}</p>
                        <p class="text-xs text-white/70">Konsultan Pajak & Kepatuhan Bisnis</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-white/70">Mitra terpercaya dalam solusi perpajakan untuk perusahaan dan individu.</p>
                <div class="mt-4 flex gap-2">
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white hover:bg-accent hover:text-primary-700"><i class="fa-brands fa-youtube text-sm"></i></a>
                </div>
            </div>

            <div>
                <h5 class="mb-4 text-lg font-semibold">Tautan</h5>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><a href="{{ Route::has('home') ? route('home', [], false) : '#' }}" class="hover:text-accent">Beranda</a></li>
                    <li><a href="{{ Route::has('services') ? route('services', [], false) : '#' }}" class="hover:text-accent">Layanan</a></li>
                    <li><a href="{{ Route::has('articles.index') ? route('articles.index', [], false) : '#' }}" class="hover:text-accent">Artikel</a></li>
                    <li><a href="{{ Route::has('contact') ? route('contact', [], false) : '#' }}" class="hover:text-accent">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h5 class="mb-4 text-lg font-semibold">Layanan</h5>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><a href="#" class="hover:text-accent">Konsultasi Pajak</a></li>
                    <li><a href="#" class="hover:text-accent">Transfer Pricing</a></li>
                    <li><a href="#" class="hover:text-accent">Tax Planning</a></li>
                    <li><a href="#" class="hover:text-accent">Sengketa Pajak</a></li>
                </ul>
            </div>

            <div>
                <h5 class="mb-4 text-lg font-semibold">Hubungi Kami</h5>
                <ul class="space-y-3 text-sm text-white/70">
                    <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot mt-0.5 text-accent"></i><span>Jl. Sudirman No. 123, Jakarta</span></li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-accent"></i><span>+62 21 1234 5678</span></li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-accent"></i><span>info@atiga.id</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-white/10 pt-6">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <p class="text-sm text-white/50">&copy; {{ date('Y') }} Atiga. Hak Cipta Dilindungi.</p>
                <div class="flex gap-6 text-sm text-white/50">
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>

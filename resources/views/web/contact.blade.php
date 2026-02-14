@extends('web.layouts.app')

@section('title', 'Kontak - Atiga')

@section('content')
{{-- Hero Section --}}
<section class="bg-gradient-to-br from-primary-700 to-primary-600 py-16 md:py-24">
    <div class="mx-auto max-w-7xl px-4 text-center">
        <h1 class="text-3xl font-extrabold text-white md:text-5xl">
            Hubungi Kami
        </h1>
        <p class="mx-auto mt-4 max-w-2xl text-base text-white/80 md:text-lg">
            Tim ahli pajak kami siap membantu kebutuhan perpajakan Anda. Jangan ragu untuk menghubungi kami melalui formulir atau informasi kontak di bawah.
        </p>
    </div>
</section>

{{-- Contact Form & Info Section --}}
<section class="py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-8 lg:grid-cols-2">
            {{-- Contact Form --}}
            <div class="rounded-2xl bg-white p-6 shadow-lg md:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-700 text-white">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <h2 class="text-xl font-bold text-primary-700">Kirim Pesan</h2>
                </div>
                
                <form action="#" method="POST" class="space-y-5">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-primary-700">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-primary-700 placeholder-slate-400 focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-primary-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-primary-700 placeholder-slate-400 focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="email@example.com"
                            >
                        </div>
                    </div>
                    
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-primary-700">
                                Nomor Telepon
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-primary-700 placeholder-slate-400 focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="+62 xxx xxxx xxxx"
                            >
                        </div>
                        <div>
                            <label for="subject" class="mb-2 block text-sm font-medium text-primary-700">
                                Subjek <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="subject" 
                                name="subject" 
                                required
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-primary-700 focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                            >
                                <option value="">Pilih subjek</option>
                                <option value="konsultasi">Konsultasi Pajak</option>
                                <option value="pendampingan">Pendampingan Pemeriksaan</option>
                                <option value="training">Pelatihan & Workshop</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="message" class="mb-2 block text-sm font-medium text-primary-700">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="5" 
                            required
                            class="w-full resize-none rounded-lg border border-slate-300 px-4 py-3 text-sm text-primary-700 placeholder-slate-400 focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                            placeholder="Tuliskan pesan atau pertanyaan Anda..."
                        ></textarea>
                    </div>
                    
                    <button 
                        type="submit"
                        class="w-full rounded-lg bg-primary-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-700/30"
                    >
                        <i class="fa-solid fa-paper-plane mr-2"></i>
                        Kirim Pesan
                    </button>
                </form>
            </div>
            
            {{-- Contact Info --}}
            <div class="space-y-6">
                <div class="rounded-2xl bg-white p-6 shadow-lg md:p-8">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent text-primary-700">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <h2 class="text-xl font-bold text-primary-700">Informasi Kontak</h2>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-primary-700">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-primary-700">Alamat</h3>
                                <p class="text-sm text-slate-600">{{ $contactInfo['address'] ?? '' }}</p>
                                <p class="text-sm text-slate-600">{{ $contactInfo['address_detail'] ?? '' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-primary-700">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-primary-700">Telepon</h3>
                                <p class="text-sm text-slate-600">{{ $contactInfo['phone'] ?? '' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-primary-700">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-primary-700">WhatsApp</h3>
                                <p class="text-sm text-slate-600">{{ $contactInfo['whatsapp'] ?? '' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-primary-700">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-primary-700">Email</h3>
                                <p class="text-sm text-slate-600">{{ $contactInfo['email'] ?? '' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-primary-700">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-primary-700">Jam Operasional</h3>
                                <p class="text-sm text-slate-600">{{ $contactInfo['hours'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Quick Action Card --}}
                <div class="rounded-2xl bg-gradient-to-br from-accent to-yellow-500 p-6 text-primary-700 md:p-8">
                    @php
                        $usesWhatsappContactAction = str_starts_with($contactActionUrl, 'https://wa.me/');
                    @endphp
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-700/20">
                        <i class="fa-solid fa-comments text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold">Butuh Respons Cepat?</h3>
                    <p class="mt-2 text-sm opacity-90">
                        Hubungi kami langsung via WhatsApp untuk respons lebih cepat terkait kebutuhan perpajakan Anda.
                    </p>
                    <a 
                        href="{{ $contactActionUrl }}"
                        target="{{ $usesWhatsappContactAction ? '_blank' : '_self' }}"
                        @if ($usesWhatsappContactAction)
                            rel="noopener noreferrer"
                        @endif
                        class="mt-4 inline-flex items-center gap-2 rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-600"
                    >
                        <i class="{{ $usesWhatsappContactAction ? 'fa-brands fa-whatsapp' : 'fa-solid fa-envelope' }}"></i>
                        {{ $usesWhatsappContactAction ? 'Chat WhatsApp' : 'Kirim Email' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Office Locations Section --}}
<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-10 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-700 text-white">
                    <i class="fa-solid fa-building"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-primary-700 md:text-3xl">Lokasi Kantor Kami</h2>
            <p class="mx-auto mt-3 max-w-2xl text-slate-600">
                Kunjungi kantor kami di lokasi terdekat. Kami hadir di beberapa kota besar di Indonesia.
            </p>
        </div>
        
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach($officeLocations as $location)
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
                    {{-- Map Embed --}}
                    <div class="relative h-48 w-full bg-slate-100">
                        <iframe
                            src="{{ $location['map_embed'] }}"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="absolute inset-0"
                            title="Peta {{ $location['name'] }}"
                        ></iframe>
                    </div>
                    
                    {{-- Location Info --}}
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-primary-700">{{ $location['name'] }}</h3>
                        <div class="mt-3 flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-accent"></i>
                            <p class="text-sm text-slate-600">{{ $location['address'] }}</p>
                        </div>
                        <a 
                            href="https://maps.google.com/?q={{ urlencode($location['address']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary-700 hover:text-accent transition"
                        >
                            <i class="fa-solid fa-map-location-dot"></i>
                            Lihat di Google Maps
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="py-16" data-faq-accordion>
    <div class="mx-auto max-w-3xl px-4">
        <div class="mb-10 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-700 text-white">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-primary-700 md:text-3xl">Pertanyaan yang Sering Diajukan</h2>
            <p class="mx-auto mt-3 max-w-2xl text-slate-600">
                Temukan jawaban atas pertanyaan umum seputar layanan konsultasi pajak kami.
            </p>
        </div>

        <div class="space-y-4">
            @foreach($faqItems as $index => $faq)
                <div
                    class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md"
                    data-faq-item
                >
                    <button
                        data-faq-trigger
                        class="flex w-full items-center justify-between px-5 py-4 text-left transition hover:bg-slate-50"
                        aria-expanded="false"
                    >
                        <span class="pr-4 text-sm font-semibold text-primary-700 md:text-base">
                            {{ $faq['question'] }}
                        </span>
                        <i
                            class="fa-solid fa-chevron-down shrink-0 text-accent transition-transform duration-200"
                        ></i>
                    </button>
                    <div
                        data-faq-content
                        class="hidden border-t border-slate-100"
                    >
                        <div class="px-5 py-4 text-sm leading-relaxed text-slate-600">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // FAQ Accordion functionality
    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('[data-faq-item]');

        faqItems.forEach(item => {
            const trigger = item.querySelector('[data-faq-trigger]');
            const content = item.querySelector('[data-faq-content]');
            const icon = trigger.querySelector('.fa-chevron-down');

            trigger.addEventListener('click', function() {
                const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

                // Close all other items (single-open accordion)
                faqItems.forEach(otherItem => {
                    const otherTrigger = otherItem.querySelector('[data-faq-trigger]');
                    const otherContent = otherItem.querySelector('[data-faq-content]');
                    const otherIcon = otherTrigger.querySelector('.fa-chevron-down');

                    if (otherItem !== item) {
                        otherTrigger.setAttribute('aria-expanded', 'false');
                        otherContent.classList.add('hidden');
                        otherIcon.classList.remove('rotate-180');
                        otherItem.classList.remove('ring-2', 'ring-accent/30');
                    }
                });

                // Toggle current item
                trigger.setAttribute('aria-expanded', !isExpanded);

                if (isExpanded) {
                    content.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                    item.classList.remove('ring-2', 'ring-accent/30');
                } else {
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                    item.classList.add('ring-2', 'ring-accent/30');
                }
            });
        });
    });
</script>
@endpush

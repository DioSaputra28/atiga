@extends('web.layouts.app')

@section('title', 'Training - Atiga')

@push('styles')
<style>
    .training-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .training-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(6, 46, 63, 0.2);
    }
    .training-card:hover .training-image {
        transform: scale(1.05);
    }
    .training-image {
        transition: transform 0.5s ease;
    }
    .category-card {
        transition: all 0.3s ease;
    }
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px -10px rgba(6, 46, 63, 0.15);
    }
    .testimonial-card {
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -12px rgba(6, 46, 63, 0.15);
    }
    .benefit-item {
        transition: all 0.3s ease;
    }
    .benefit-item:hover {
        background: rgba(216, 174, 108, 0.1);
    }
</style>
@endpush

@section('content')
{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-primary-700">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4 py-20 md:py-28">
        {{-- Breadcrumb --}}
        <nav class="mb-8 flex items-center gap-2 text-sm text-white/60">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="hover:text-accent transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-accent">Training</span>
        </nav>
        
        {{-- Hero Content --}}
        <div class="max-w-3xl">
            <span class="mb-4 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-accent">
                Pelatihan & Sertifikasi
            </span>
            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                Tingkatkan Kompetensi<br>
                <span class="text-accent">Perpajakan Anda</span>
            </h1>
            <p class="max-w-2xl text-lg text-white/80 leading-relaxed">
                Program pelatihan dan sertifikasi perpajakan yang komprehensif, dipandu oleh instruktur berpengalaman untuk membantu Anda menguasai aspek perpajakan Indonesia.
            </p>
        </div>
    </div>
    
    {{-- Bottom Wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 80V40C240 0 480 0 720 20C960 40 1200 60 1440 40V80H0Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- Stats Overview --}}
<section class="bg-slate-50 py-12">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($stats as $stat)
                <div class="flex items-center gap-4 rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary-700 text-white">
                        <i class="fa-solid {{ $stat['icon'] }} text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-primary-700">{{ $stat['number'] }}</p>
                        <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Training Programs --}}
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                Program Unggulan
            </span>
            <h2 class="text-3xl font-extrabold text-primary-700 md:text-4xl">
                Pilih Program <span class="text-accent">Terbaik Anda</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-600">
                Berbagai pilihan program pelatihan dari level dasar hingga lanjut, disesuaikan dengan kebutuhan karir dan bisnis Anda.
            </p>
        </div>
        
        <div class="grid items-start gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($trainings as $training)
            <div class="training-card group flex flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                {{-- Image --}}
                <div class="relative h-52 overflow-hidden">
                    <a href="{{ route('trainings.show', $training['slug']) }}" class="block h-full">
                        <img src="{{ $training['image'] }}" alt="{{ $training['title'] }}" class="training-image h-full w-full object-cover">
                    </a>
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-primary-700/60 to-transparent"></div>
                    
                    {{-- Badges --}}
                    <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                        @if($training['is_featured'])
                        <span class="rounded-full bg-accent px-3 py-1 text-xs font-bold text-primary-700">
                            Unggulan
                        </span>
                        @endif
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $training['status'] === 'ongoing' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($training['status']) }}
                        </span>
                    </div>
                    
                    {{-- Price Badge --}}
                    <div class="absolute bottom-4 right-4">
                        <div class="rounded-lg bg-white px-3 py-2 text-center shadow-lg">
                            <p class="text-lg font-bold text-primary-700">{{ $training['price'] }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Content --}}
                <div class="flex flex-col p-6">
                    <h3 class="mb-2 text-xl font-bold text-primary-700 line-clamp-2">
                        <a href="{{ route('trainings.show', $training['slug']) }}" class="transition hover:text-secondary-600">
                            {{ $training['title'] }}
                        </a>
                    </h3>
                    <p class="mb-3 text-sm text-slate-600 line-clamp-3">{{ $training['description'] }}</p>
                    
                    {{-- Meta Info --}}
                    <div class="mb-3 flex flex-wrap gap-3 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <i class="fa-regular fa-clock text-accent"></i>
                            {{ $training['duration'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-user-tie text-accent"></i>
                            {{ $training['instructor'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-desktop text-accent"></i>
                            {{ $training['format'] }}
                        </span>
                    </div>
                    
                    {{-- Schedule --}}
                    <div class="mb-4 rounded-lg bg-slate-50 p-3">
                        <p class="mb-2 text-xs font-semibold text-slate-500">Jadwal Tersedia:</p>
                        <p class="text-xs text-slate-700">{{ $training['schedule'] }}</p>
                    </div>
                    
                    {{-- CTA --}}
                    @if(filled($training['registration_link']))
                        <a href="{{ $training['registration_link'] }}" class="mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-primary-700 py-3 text-sm font-bold text-white transition-all hover:bg-primary-600 hover:shadow-lg">
                            <i class="fa-solid fa-user-plus"></i>
                            Daftar Sekarang
                        </a>
                    @else
                        <span class="mt-2 flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-slate-200 py-3 text-sm font-bold text-slate-500">
                            <i class="fa-solid fa-circle-info"></i>
                            Informasi Pendaftaran Menyusul
                        </span>
                    @endif

                    <a href="{{ route('trainings.show', $training['slug']) }}" class="mt-2 inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        <i class="fa-solid fa-circle-info"></i>
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-12 lg:grid-cols-2 items-center">
            {{-- Left Content --}}
            <div>
                <span class="mb-3 inline-block rounded-full bg-accent/20 px-4 py-1 text-sm font-semibold text-primary-700">
                    Keunggulan Kami
                </span>
                <h2 class="mb-6 text-3xl font-extrabold text-primary-700 md:text-4xl">
                    Mengapa Memilih <span class="text-accent">Training Atiga?</span>
                </h2>
                <p class="mb-8 text-slate-600 leading-relaxed">
                    Kami berkomitmen memberikan pengalaman belajar terbaik dengan materi yang selalu update, instruktur berpengalaman, dan dukungan penuh bagi setiap peserta.
                </p>
                
                <div class="space-y-4">
                    <div class="benefit-item flex items-start gap-4 rounded-xl p-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-primary-700 text-white">
                            <i class="fa-solid fa-chalkboard-user text-xl"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-lg font-bold text-primary-700">Instruktur Berpengalaman</h4>
                            <p class="text-sm text-slate-600">Dipandu oleh praktisi perpajakan dengan sertifikasi BKP dan pengalaman industri yang luas.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item flex items-start gap-4 rounded-xl p-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-primary-700 text-white">
                            <i class="fa-solid fa-book-open text-xl"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-lg font-bold text-primary-700">Materi Selalu Update</h4>
                            <p class="text-sm text-slate-600">Kurikulum disesuaikan dengan peraturan perpajakan terbaru dan praktik industri terkini.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item flex items-start gap-4 rounded-xl p-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-primary-700 text-white">
                            <i class="fa-solid fa-headset text-xl"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-lg font-bold text-primary-700">Dukungan Pasca Training</h4>
                            <p class="text-sm text-slate-600">Akses grup diskusi, konsultasi lanjutan, dan video rekaman untuk pembelajaran berkelanjutan.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item flex items-start gap-4 rounded-xl p-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-primary-700 text-white">
                            <i class="fa-solid fa-award text-xl"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-lg font-bold text-primary-700">Sertifikat Resmi</h4>
                            <p class="text-sm text-slate-600">Dapatkan sertifikat keikutsertaan yang diakui industri untuk memperkuat kredibilitas profesional Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Right Image --}}
            <div class="relative">
                <div class="absolute -right-4 -top-4 h-32 w-32 rounded-full bg-accent/20"></div>
                <div class="absolute -bottom-4 -left-4 h-24 w-24 rounded-full bg-secondary-500/20"></div>
                <div class="relative overflow-hidden rounded-3xl">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80" alt="Training Session" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-700/40 to-transparent"></div>
                </div>
                
                {{-- Floating Stats --}}
                <div class="absolute -bottom-6 -left-6 rounded-2xl bg-white p-4 shadow-xl">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent text-primary-700">
                            <i class="fa-solid fa-trophy text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-primary-700">10+ Tahun</p>
                            <p class="text-xs text-slate-500">Pengalaman Training</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="relative overflow-hidden bg-primary-700 py-24">
    {{-- Background Decoration --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute left-1/4 top-0 h-64 w-64 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-64 w-64 rounded-full bg-secondary-500 blur-3xl"></div>
    </div>
    
    <div class="relative mx-auto max-w-7xl px-4">
        <div class="mb-16 text-center">
            <span class="mb-3 inline-block rounded-full bg-accent/30 px-4 py-1 text-sm font-semibold text-accent">
                Testimoni Peserta
            </span>
            <h2 class="text-3xl font-extrabold text-white md:text-4xl">
                Apa Kata <span class="text-accent">Mereka?</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-white/70">
                Pengalaman nyata dari alumni yang telah mengikuti program training kami.
            </p>
        </div>
        
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card rounded-2xl bg-white/10 p-8 backdrop-blur-sm">
                {{-- Rating --}}
                <div class="mb-4 flex gap-1">
                    @for($i = 0; $i < $testimonial['rating']; $i++)
                    <i class="fa-solid fa-star text-accent"></i>
                    @endfor
                </div>
                
                {{-- Content --}}
                <p class="mb-6 text-white/90 leading-relaxed">"{{ $testimonial['content'] }}"</p>
                
                {{-- Author --}}
                <div class="flex items-center gap-4">
                    <img src="{{ $testimonial['photo'] }}" alt="{{ $testimonial['name'] }}" class="h-14 w-14 rounded-full object-cover ring-2 ring-accent">
                    <div>
                        <p class="font-bold text-white">{{ $testimonial['name'] }}</p>
                        <p class="text-sm text-white/60">{{ $testimonial['company'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-4xl px-4 text-center">
        <div class="rounded-3xl bg-gradient-to-r from-primary-700 to-primary-600 p-10 md:p-16">
            <div class="mb-6 flex justify-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-accent/20">
                    <i class="fa-solid fa-rocket text-4xl text-accent"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white md:text-4xl">
                Siap Meningkatkan Karir Perpajakan Anda?
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-white/80">
                Daftar sekarang dan mulai perjalanan Anda menjadi profesional perpajakan yang kompeten dan terpercaya.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-accent px-8 py-4 text-lg font-bold text-primary-700 transition-all hover:bg-accent/90 hover:shadow-lg">
                    <i class="fa-solid fa-user-plus"></i>
                    Daftar Training
                </a>
                <a href="{{ Route::has('contact') ? route('contact') : '#' }}" class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 px-8 py-4 text-lg font-semibold text-white transition-all hover:bg-white/10">
                    Konsultasi Gratis
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

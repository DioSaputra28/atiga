@extends('web.layouts.app')

@section('title', $trainingDetail['title'].' - Training Atiga')

@section('content')
<section class="bg-slate-50 py-12 md:py-16">
    <div class="mx-auto max-w-5xl px-4">
        <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-500">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="transition hover:text-primary-700">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('trainings.index') }}" class="transition hover:text-primary-700">Training</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-primary-700">Detail</span>
        </nav>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <img src="{{ $trainingDetail['image'] }}" alt="{{ $trainingDetail['title'] }}" class="h-64 w-full object-cover md:h-80">

            <div class="p-6 md:p-8">
                <div class="mb-5 flex flex-wrap items-center gap-2">
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $trainingDetail['status'] === 'ongoing' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($trainingDetail['status']) }}
                    </span>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ $trainingDetail['price'] }}</span>
                </div>

                <h1 class="mb-4 text-2xl font-extrabold text-primary-700 md:text-3xl">
                    {{ $trainingDetail['title'] }}
                </h1>

                <div class="grid gap-3 rounded-xl bg-slate-50 p-4 text-sm text-slate-600 md:grid-cols-2">
                    <p class="flex items-start gap-2"><i class="fa-regular fa-calendar mt-0.5 text-accent"></i><span>{{ $trainingDetail['schedule'] }}</span></p>
                    <p class="flex items-start gap-2"><i class="fa-regular fa-clock mt-0.5 text-accent"></i><span>{{ $trainingDetail['duration'] }}</span></p>
                    <p class="flex items-start gap-2"><i class="fa-solid fa-user-tie mt-0.5 text-accent"></i><span>{{ $trainingDetail['instructor'] }}</span></p>
                    <p class="flex items-start gap-2"><i class="fa-solid fa-location-dot mt-0.5 text-accent"></i><span>{{ $trainingDetail['location'] }}</span></p>
                </div>

                <div class="mt-6 border-t border-slate-100 pt-6">
                    <h2 class="mb-3 text-lg font-bold text-primary-700">Deskripsi</h2>
                    <p class="whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $trainingDetail['description'] }}</p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if (filled($trainingDetail['registration_link']))
                        <a href="{{ $trainingDetail['registration_link'] }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-primary-600">
                            <i class="fa-solid fa-user-plus"></i>
                            Daftar Sekarang
                        </a>
                    @else
                        <span class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-500">
                            <i class="fa-solid fa-circle-info"></i>
                            Pendaftaran Menyusul
                        </span>
                    @endif

                    <a href="{{ route('trainings.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Training
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

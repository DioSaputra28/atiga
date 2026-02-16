@extends('web.layouts.app')

@section('title', $trainingDetail['title'].' - Training Atiga')

@section('content')
<section class="bg-slate-50 py-10 sm:py-12 md:py-16">
    <div class="mx-auto max-w-5xl px-3 sm:px-4">
        <nav class="mb-5 flex flex-wrap items-center gap-x-2 gap-y-1.5 text-xs text-slate-500 sm:mb-6 sm:text-sm">
            <a href="{{ Route::has('home') ? route('home') : '/' }}" class="transition hover:text-primary-700">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('trainings.index') }}" class="transition hover:text-primary-700">Training</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-primary-700">Detail</span>
        </nav>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm sm:rounded-2xl">
            <img src="{{ $trainingDetail['image'] }}" alt="{{ $trainingDetail['title'] }}" class="h-48 w-full object-cover sm:h-64 md:h-80">

            <div class="p-4 sm:p-6 md:p-8">
                <div class="mb-5 flex flex-wrap items-center gap-2">
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $trainingDetail['status'] === 'ongoing' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($trainingDetail['status']) }}
                    </span>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ $trainingDetail['price'] }}</span>
                </div>

                <h1 class="mb-3 break-words text-xl font-extrabold leading-tight text-primary-700 sm:mb-4 sm:text-2xl md:text-3xl">
                    {{ $trainingDetail['title'] }}
                </h1>

                <div class="grid grid-cols-1 gap-2.5 rounded-xl bg-slate-50 p-3 text-xs text-slate-600 sm:gap-3 sm:p-4 sm:text-sm md:grid-cols-2">
                    <p class="flex min-w-0 items-start gap-2"><i class="fa-regular fa-calendar mt-0.5 shrink-0 text-accent"></i><span class="break-words">{{ $trainingDetail['schedule'] }}</span></p>
                    <p class="flex min-w-0 items-start gap-2"><i class="fa-regular fa-clock mt-0.5 shrink-0 text-accent"></i><span class="break-words">{{ $trainingDetail['duration'] }}</span></p>
                    <p class="flex min-w-0 items-start gap-2"><i class="fa-solid fa-user-tie mt-0.5 shrink-0 text-accent"></i><span class="break-words">{{ $trainingDetail['instructor'] }}</span></p>
                    <p class="flex min-w-0 items-start gap-2"><i class="fa-solid fa-location-dot mt-0.5 shrink-0 text-accent"></i><span class="break-words">{{ $trainingDetail['location'] }}</span></p>
                </div>

                <div class="mt-5 border-t border-slate-100 pt-5 sm:mt-6 sm:pt-6">
                    <h2 class="mb-3 text-lg font-bold text-primary-700">Deskripsi</h2>
                    <p class="whitespace-pre-line break-words text-sm leading-7 text-slate-600 sm:text-base sm:leading-8">{{ $trainingDetail['description'] }}</p>
                </div>

                <div class="mt-6 flex flex-wrap gap-2.5 sm:mt-8 sm:gap-3">
                    @if (filled($trainingDetail['registration_link']))
                        <a href="{{ $trainingDetail['registration_link'] }}" class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-primary-700 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-primary-600 sm:w-auto sm:px-5 sm:py-3">
                            <i class="fa-solid fa-user-plus"></i>
                            Daftar Sekarang
                        </a>
                    @else
                        <span class="inline-flex min-h-[44px] w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-500 sm:w-auto sm:px-5 sm:py-3">
                            <i class="fa-solid fa-circle-info"></i>
                            Pendaftaran Menyusul
                        </span>
                    @endif

                    <a href="{{ route('trainings.index') }}" class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 sm:w-auto sm:px-5 sm:py-3">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Training
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

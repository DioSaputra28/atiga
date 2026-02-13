<?php

use App\Http\Controllers\Web\ActivityController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\TrainingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/layanan', [PageController::class, 'services'])->name('services');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/training', [TrainingController::class, 'index'])->name('trainings.index');
Route::get('/aktifitas', [ActivityController::class, 'index'])->name('activities.index');

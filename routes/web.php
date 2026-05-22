<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/informasi-publik', [PageController::class, 'informasi'])->name('informasi');
Route::get('/tentang-kami', [PageController::class, 'tentang'])->name('tentang');
Route::get('/skema-sertifikasi', [PageController::class, 'skema'])->name('skema');
Route::get('/daftar-penerima-sertifikat', [PageController::class, 'sertifikat'])->name('sertifikat');
Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('kegiatan.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

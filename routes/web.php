<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LlmsController;
use App\Http\Controllers\KarierController;
use App\Http\Controllers\DokumenLamaranController;
use App\Http\Controllers\VerifikasiSertifikatController;

// Subdomain verifikasi (tujuan QR di sertifikat/SK dari CBT) — harus terdaftar paling atas:
// route tanpa domain di bawah juga cocok untuk host ini.
Route::domain(config('app.verifikasi_domain'))->group(function () {
    Route::get('/{path?}', [VerifikasiSertifikatController::class, 'fromSubdomain'])
        ->where('path', '.*')
        ->name('verifikasi.subdomain');
});

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/informasi-publik', [PageController::class, 'informasi'])->name('informasi');
Route::get('/tentang-kami', [PageController::class, 'tentang'])->name('tentang');
Route::get('/skema-sertifikasi', [PageController::class, 'skema'])->name('skema');
Route::get('/skema-sertifikasi/bidang/{bidang}', [SkemaController::class, 'bidang'])->name('skema.bidang');
Route::get('/skema-sertifikasi/{slug}', [SkemaController::class, 'show'])->name('skema.show');
Route::get('/daftar-penerima-sertifikat', [PageController::class, 'sertifikat'])->name('sertifikat');
Route::get('/daftar-penerima-sertifikat/search', [PageController::class, 'sertifikatSearch'])->name('sertifikat.search');
Route::permanentRedirect('/verifikasi-sertifikat', '/daftar-penerima-sertifikat');
Route::get('/verifikasi-sertifikat/sk/{noSk}', [VerifikasiSertifikatController::class, 'sk'])
    ->where('noSk', '.+')
    ->name('verifikasi.sk');
Route::get('/verifikasi-sertifikat/{nomor}', [VerifikasiSertifikatController::class, 'show'])->name('verifikasi.show');
Route::get('/jadwal-sertifikasi-kompetensi', [PageController::class, 'jadwalSertifikasi'])->name('jadwal-sertifikasi');
Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('kegiatan.index');
Route::get('/booklet', [PageController::class, 'booklet'])->name('booklet');
Route::get('/webinar-gerakan-nasional-sertifikasi-kompetensi', [PageController::class, 'webinarGerakanNasional'])->name('webinar.gerakan-nasional');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategori/{slug}', [BlogController::class, 'kategori'])->name('blog.kategori');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/llms.txt', [LlmsController::class, 'index'])->name('llms');
Route::get('/llms-full.txt', [LlmsController::class, 'full'])->name('llms.full');

Route::get('/b/{code}', [BlogController::class, 'short'])->name('blog.short');

Route::get('/blog/{slug}', [BlogController::class, 'redirectLegacy'])->name('blog.show.legacy');

Route::get('/karier', [KarierController::class, 'index'])->name('karier.index');
Route::get('/karier/{slug}', [KarierController::class, 'show'])->name('karier.show');
// Maks. 5 kiriman/menit per IP — tiap kiriman bisa membawa upload hingga ±20 MB.
Route::post('/karier/apply', [KarierController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('karier.apply');

// Dokumen pelamar (disk privat) — hanya admin, dicek di controller.
Route::get('/dokumen-lamaran/{lamaran}/{jenis}', DokumenLamaranController::class)
    ->name('lamaran.dokumen');

Route::get('/{slug}', [BlogController::class, 'show'])
    ->where('slug', '(?!admin$|api$|blog$|booklet$|daftar-penerima-sertifikat$|email$|forgot-password$|informasi-publik$|jadwal-sertifikasi-kompetensi$|karier$|kegiatan$|livewire$|llms\.txt$|llms-full\.txt$|login$|logout$|register$|reset-password$|sanctum$|sitemap\.xml$|skema-sertifikasi$|storage$|tentang-kami$|vendor$|verifikasi-sertifikat$)[^/]+')
    ->name('blog.show');

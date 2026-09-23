<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkron rutin dari database CBT — aman dijalankan tiap hari walau tidak ada data
// baru (upsert by nomor_sertifikat), supaya sertifikat baru otomatis muncul di
// website tanpa admin perlu ingat klik tombol "Sync dari CBT" di panel admin.
Schedule::command('sertifikat:sync-cbt')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->onOneServer();

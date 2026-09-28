<?php

namespace App\Http\Controllers;

use App\Models\LamaranKarir;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Unduh dokumen pelamar (CV, ijazah, dll). Dokumen berisi data pribadi, jadi disimpan di
 * disk privat dan hanya bisa diakses admin panel — tautan ini juga yang dikirim ke
 * Google Sheets, sehingga bocornya spreadsheet tidak langsung membocorkan dokumennya.
 */
class DokumenLamaranController extends Controller
{
    public function __invoke(Request $request, LamaranKarir $lamaran, string $jenis)
    {
        if (! $request->user()) {
            return redirect()->guest(Filament::getPanel('admin')->getLoginUrl());
        }

        abort_unless($request->user()->is_admin, 403);
        abort_unless(array_key_exists($jenis, LamaranKarir::DOKUMEN), 404);

        $path = $lamaran->{$jenis};
        $disk = Storage::disk(LamaranKarir::DOKUMEN_DISK);

        abort_unless($path && $disk->exists($path), 404);

        $namaFile = Str::slug(LamaranKarir::DOKUMEN[$jenis].' '.$lamaran->nama_lengkap)
            .'.'.pathinfo($path, PATHINFO_EXTENSION);

        // inline: PDF/gambar langsung tampil di tab baru, format lain tetap terunduh.
        return $disk->response($path, $namaFile, [], 'inline');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use RalphJSmit\Laravel\SEO\Support\SEOData;

/**
 * Tujuan QR code di Sertifikat & SK yang diterbitkan CBT. QR berisi
 * https://verifikasi-sertifikat.lspedukia.id/{nomor} dan .../sk/{no_sk} — subdomain itu
 * diarahkan ke aplikasi ini lalu dialihkan ke /verifikasi-sertifikat/... (fromSubdomain).
 * Data dibaca dari tabel `sertifikats` (sync harian dari CBT), hanya yang tampil.
 */
class VerifikasiSertifikatController extends Controller
{
    public function show(string $nomor)
    {
        return $this->result(
            Sertifikat::tampil()->where('nomor_sertifikat', $nomor)->first(),
            'Nomor Sertifikat',
            $nomor,
        );
    }

    /** Nomor SK berisi garis miring, mis. 012/SK-SP/LSP-EDUKIA/IX/2026. */
    public function sk(string $noSk)
    {
        return $this->result(
            Sertifikat::tampil()->where('no_sk', $noSk)->first(),
            'Nomor SK',
            $noSk,
        );
    }

    /**
     * Semua URL di subdomain verifikasi dialihkan ke domain utama dengan path yang sama
     * di bawah /verifikasi-sertifikat; halaman utama subdomain ke daftar penerima.
     */
    public function fromSubdomain(string $path = '')
    {
        $path = trim($path, '/');
        $target = $path === ''
            ? route('sertifikat', absolute: false)
            : '/verifikasi-sertifikat/'.implode('/', array_map('rawurlencode', explode('/', $path)));

        return redirect()->away(rtrim(config('app.url'), '/').$target, 301);
    }

    private function result(?Sertifikat $sertifikat, string $label, string $nomor)
    {
        $view = view('verifikasi-sertifikat', compact('sertifikat', 'label', 'nomor'))
            ->with('activeNav', 'sertifikat')
            ->with('SEOData', new SEOData(
                title: $sertifikat ? 'Verifikasi Sertifikat — '.$sertifikat->nama : 'Verifikasi Sertifikat',
                description: 'Hasil verifikasi keaslian sertifikat kompetensi yang diterbitkan LSP Edukia.',
                robots: 'noindex, nofollow',
            ));

        return response($view, $sertifikat ? 200 : 404);
    }
}

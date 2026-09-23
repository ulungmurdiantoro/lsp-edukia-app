<?php

namespace App\Console\Commands;

use App\Models\Sertifikat;
use App\Support\SertifikatExcelHelper;
use App\Support\Skemas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Sinkronkan peserta yang sudah LULUS & sertifikatnya sudah terbit/terdistribusi dari
 * database sistem CBT (koneksi 'cbt', lihat config/database.php) ke tabel sertifikats
 * yang dipakai halaman /daftar-penerima-sertifikat. Melengkapi App\Console\Commands\
 * ImportSertifikat (yang membaca dari 2 file Excel resmi) dengan jalur data langsung
 * dari sistem ujian.
 *
 * Membaca dari VIEW read-only v_sertifikasi_kelulusan (bukan tabel mentah) supaya akses
 * lintas-database dibatasi hanya ke kolom yang relevan, dan supaya filter "lulus & sudah
 * terdistribusi" konsisten dengan definisi resminya di sisi CBT.
 */
class SyncSertifikatFromCbt extends Command
{
    protected $signature = 'sertifikat:sync-cbt';
    protected $description = 'Sinkronkan peserta LULUS yang sertifikatnya sudah terbit dari database CBT ke tabel sertifikats';

    public function handle(): void
    {
        // Peta kode-tengah (mis. AIL, LIM, ESG) → data master skema (kode, gelar) dari
        // App\Support\Skemas, sumber tunggal 26 skema LSP Edukia. Catatan: lisensi_kan di
        // master ini TIDAK dipakai lagi untuk kolom `lisensi` — kolom itu sekarang diambil
        // dari with_kan, yaitu pilihan KAN/non-KAN yang sungguhan dipakai saat sertifikat
        // didistribusikan, bukan status lisensi default per skema.
        $skemaMaster = Skemas::all()->keyBy(fn (array $s) => SertifikatExcelHelper::middleKodeFor($s['nama']) ?? '');

        $rows = DB::connection('cbt')->table('v_sertifikasi_kelulusan')
            ->whereNotNull('sk_number')
            // valid_until wajib ada — baris yang SK/sertifikatnya terisi tapi belum punya
            // tanggal kadaluarsa berarti belum benar-benar selesai difinalisasi di sisi CBT.
            ->whereNotNull('valid_until')
            ->select([
                'nama_peserta as nama',
                'kode_skema',
                'classroom_title',
                'sk_number',
                'sertifikat_number',
                'finalized_at',
                'valid_until',
                'with_kan',
            ])
            ->orderBy('finalized_at')
            ->get();

        $synced = 0;
        $skipped = 0;
        $hidden = 0;

        foreach ($rows as $row) {
            $scheme = SertifikatExcelHelper::resolveScheme($row->kode_skema, $row->classroom_title);

            if (! $row->nama || ! $row->finalized_at || ! $scheme) {
                $this->warn("  Dilewati (skema tidak dikenali): {$row->nama} | {$row->classroom_title}");
                $skipped++;
                continue;
            }

            // Skema/kategori sudah pasti valid dari resolveScheme() di atas, jadi kode-tengah
            // hasil middleKodeFor() dijamin ada di $skemaMaster (tidak perlu fallback lagi).
            $middle = SertifikatExcelHelper::middleKodeFor($scheme['skema']);
            $master = $skemaMaster->get($middle);

            Sertifikat::updateOrCreate(
                ['nomor_sertifikat' => $row->sertifikat_number],
                [
                    'nama' => SertifikatExcelHelper::clean($row->nama),
                    'gelar' => $master['gelar'] ?? null,
                    'skema' => $scheme['skema'],
                    'kategori' => $scheme['kategori'],
                    'lisensi' => (bool) $row->with_kan,
                    'no_sk' => $row->sk_number,
                    'no_skema' => $master['kode'] ?? $row->kode_skema,
                    'tanggal_terbit' => $row->finalized_at,
                    'tanggal_kadaluarsa' => $row->valid_until,
                    'tampil' => true,
                ]
            );
            $synced++;

            // Baris lama dengan nama+skema sama tapi nomor sertifikat beda kemungkinan
            // besar orang yang sama yang dulu masuk lewat import Excel (sertifikat:import
            // / tombol admin) dan sekarang punya data resmi dari CBT — sembunyikan yang
            // lama (bukan hapus, supaya tetap ada untuk audit) supaya tidak dobel tampil
            // di halaman publik /daftar-penerima-sertifikat.
            $namaTernormalisasi = SertifikatExcelHelper::normalizeNama($row->nama);
            $duplikatLama = Sertifikat::where('skema', $scheme['skema'])
                ->where('nomor_sertifikat', '!=', $row->sertifikat_number)
                ->where('tampil', true)
                ->get()
                ->filter(fn (Sertifikat $s) => SertifikatExcelHelper::normalizeNama($s->nama) === $namaTernormalisasi);

            foreach ($duplikatLama as $stale) {
                $stale->update(['tampil' => false]);
                $this->warn("  Disembunyikan (duplikat lama, digantikan {$row->sertifikat_number}): {$stale->nama} | {$stale->nomor_sertifikat}");
                $hidden++;
            }
        }

        $this->info("Selesai! {$synced} sertifikat disinkronkan, {$skipped} dilewati, {$hidden} duplikat lama disembunyikan.");
    }
}

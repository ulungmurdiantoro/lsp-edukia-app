<?php

namespace App\Console\Commands;

use App\Models\Sertifikat;
use App\Support\SertifikatExcelHelper;
use App\Support\Skemas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Sinkronkan peserta yang sudah terbit No SK & No Sertifikat dari database sistem CBT
 * (koneksi 'cbt', lihat config/database.php) ke tabel sertifikats yang dipakai halaman
 * /daftar-penerima-sertifikat. Melengkapi App\Console\Commands\ImportSertifikat (yang
 * membaca dari 2 file Excel resmi) dengan jalur data langsung dari sistem ujian.
 */
class SyncSertifikatFromCbt extends Command
{
    protected $signature = 'sertifikat:sync-cbt';
    protected $description = 'Sinkronkan peserta yang sudah terbit No SK & No Sertifikat dari database CBT ke tabel sertifikats';

    public function handle(): void
    {
        // Peta kode-tengah (mis. AIL, LIM, ESG) → data master skema (kode, gelar, status
        // lisensi KAN) dari App\Support\Skemas, sumber tunggal 26 skema LSP Edukia.
        $skemaMaster = Skemas::all()->keyBy(fn (array $s) => SertifikatExcelHelper::middleKodeFor($s['nama']) ?? '');

        $rows = DB::connection('cbt')->table('participant_results as pr')
            ->join('students as s', 's.id', '=', 'pr.student_id')
            ->join('classrooms as c', 'c.id', '=', 's.classroom_id')
            ->whereNotNull('pr.sk_number')
            ->whereNotNull('pr.sertifikat_number')
            ->select([
                's.name as nama',
                'c.kode_skema',
                'c.title as classroom_title',
                'pr.sk_number',
                'pr.sertifikat_number',
                'pr.finalized_at',
                'pr.valid_until',
            ])
            ->orderBy('pr.finalized_at')
            ->get();

        $synced = 0;
        $skipped = 0;

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
                    'lisensi' => $master['lisensi_kan'] ?? false,
                    'no_sk' => $row->sk_number,
                    'no_skema' => $master['kode'] ?? $row->kode_skema,
                    'tanggal_terbit' => $row->finalized_at,
                    'tanggal_kadaluarsa' => $row->valid_until,
                    'tampil' => true,
                ]
            );
            $synced++;
        }

        $this->info("Selesai! {$synced} sertifikat disinkronkan, {$skipped} dilewati.");
    }
}

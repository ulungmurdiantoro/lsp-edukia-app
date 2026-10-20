<?php

namespace App\Console\Commands;

use App\Models\Sertifikat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Koreksi administratif masa berlaku sertifikat (Pemberitahuan No. 553/SPT/EDUKIA/X/2026):
 * tanggal berakhir yang tercatat tepat 3 tahun setelah tanggal terbit (pola lama register
 * Excel) diubah menjadi 1 hari sebelumnya. Baris yang sudah benar (mis. hasil sync CBT)
 * tidak tersentuh, sehingga aman dijalankan berulang kali.
 *
 * Setiap perubahan dicatat ke storage/app/private/koreksi-masa-berlaku/*.csv sebagai bukti
 * ketertelusuran (nomor sertifikat, tanggal lama, tanggal baru).
 */
class KoreksiMasaBerlakuSertifikat extends Command
{
    protected $signature = 'sertifikat:koreksi-masa-berlaku {--dry-run : Tampilkan sertifikat yang akan dikoreksi tanpa menyimpan perubahan}';

    protected $description = 'Koreksi tanggal berakhir sertifikat 3 tahun menjadi 1 hari sebelum tanggal yang sama pada tahun ketiga';

    public function handle(): int
    {
        $koreksi = Sertifikat::query()
            ->whereNotNull('tanggal_terbit')
            ->whereNotNull('tanggal_kadaluarsa')
            ->orderBy('tanggal_terbit')
            ->orderBy('nomor_sertifikat')
            ->get()
            ->map(fn (Sertifikat $s) => [
                'sertifikat' => $s,
                'baru' => Sertifikat::koreksiTanggalBerakhir($s->tanggal_terbit, $s->tanggal_kadaluarsa),
            ])
            ->reject(fn (array $k) => $k['baru']->isSameDay($k['sertifikat']->tanggal_kadaluarsa))
            ->values();

        if ($koreksi->isEmpty()) {
            $this->info('Tidak ada sertifikat yang perlu dikoreksi.');

            return self::SUCCESS;
        }

        $this->table(
            ['Nomor Sertifikat', 'Nama', 'Terbit', 'Berakhir (lama)', 'Berakhir (baru)', 'Tampil'],
            $koreksi->map(fn (array $k) => [
                $k['sertifikat']->nomor_sertifikat,
                $k['sertifikat']->nama,
                $k['sertifikat']->tanggal_terbit->toDateString(),
                $k['sertifikat']->tanggal_kadaluarsa->toDateString(),
                $k['baru']->toDateString(),
                $k['sertifikat']->tampil ? 'ya' : 'tidak',
            ])->all(),
        );

        if ($this->option('dry-run')) {
            $this->warn("Dry run: {$koreksi->count()} sertifikat akan dikoreksi. Tidak ada perubahan yang disimpan.");

            return self::SUCCESS;
        }

        $csv = "nomor_sertifikat,nama,tanggal_terbit,tanggal_kadaluarsa_lama,tanggal_kadaluarsa_baru\n";

        DB::transaction(function () use ($koreksi, &$csv) {
            foreach ($koreksi as $k) {
                $s = $k['sertifikat'];
                $csv .= implode(',', array_map(fn (string $v) => '"'.str_replace('"', '""', $v).'"', [
                    $s->nomor_sertifikat,
                    $s->nama,
                    $s->tanggal_terbit->toDateString(),
                    $s->tanggal_kadaluarsa->toDateString(),
                    $k['baru']->toDateString(),
                ]))."\n";

                $s->update(['tanggal_kadaluarsa' => $k['baru']]);
            }
        });

        $log = 'koreksi-masa-berlaku/koreksi-'.now()->format('Ymd-His').'.csv';
        Storage::disk('local')->put($log, $csv);

        $this->info("Selesai! {$koreksi->count()} sertifikat dikoreksi. Log: ".Storage::disk('local')->path($log));

        return self::SUCCESS;
    }
}

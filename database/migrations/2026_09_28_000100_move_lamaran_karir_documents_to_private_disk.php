<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Dokumen pelamar dulu disimpan di disk 'public' (bisa diakses siapa pun lewat
 * /storage/lamaran-karir/...). Pindahkan ke disk privat 'local' dengan path yang sama,
 * sehingga kolom di database tidak perlu diubah.
 */
return new class extends Migration
{
    private const KOLOM = ['cv', 'portofolio', 'ijazah', 'sertifikat_pelatihan'];

    public function up(): void
    {
        $this->pindahkan(Storage::disk('public'), Storage::disk('local'));
    }

    public function down(): void
    {
        $this->pindahkan(Storage::disk('local'), Storage::disk('public'));
    }

    private function pindahkan($dari, $ke): void
    {
        DB::table('lamaran_karirs')->select(self::KOLOM)->orderBy('id')->each(function ($row) use ($dari, $ke) {
            foreach (self::KOLOM as $kolom) {
                $path = $row->{$kolom};

                if (! $path || ! $dari->exists($path) || $ke->exists($path)) {
                    continue;
                }

                $ke->writeStream($path, $dari->readStream($path));
                $dari->delete($path);
            }
        });
    }
};

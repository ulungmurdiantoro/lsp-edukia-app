<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    /** Nomor surat pemberitahuan koreksi administratif masa berlaku (20 Oktober 2026). */
    public const NOMOR_PEMBERITAHUAN_KOREKSI = '553/SPT/EDUKIA/X/2026';

    /** Akhir periode sertifikasi yang dicakup pemberitahuan koreksi (April 2024 – Agustus 2026). */
    public const AKHIR_PERIODE_KOREKSI = '2026-08-31';

    protected $fillable = [
        'nama',
        'gelar',
        'skema',
        'kategori',
        'lisensi',
        'nomor_sertifikat',
        'no_sk',
        'no_skema',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'tampil',
    ];

    protected $casts = [
        'tanggal_terbit'     => 'date',
        'tanggal_kadaluarsa' => 'date',
        'tampil'             => 'boolean',
        'lisensi'            => 'boolean',
    ];

    protected $appends = ['status'];

    // Computed: aktif | expiring (≤90 hari) | kadaluarsa (sudah lewat)
    public function getStatusAttribute(): string
    {
        if (! $this->tanggal_kadaluarsa) {
            return 'aktif';
        }
        $today = now()->startOfDay();
        if ($this->tanggal_kadaluarsa->lt($today)) {
            return 'kadaluarsa';
        }
        if ($this->tanggal_kadaluarsa->lte(now()->startOfDay()->addDays(90))) {
            return 'expiring';
        }
        return 'aktif';
    }

    /**
     * Masa berlaku 3 tahun berakhir 1 hari kalender sebelum tanggal yang sama pada tahun
     * ketiga (mulai 18 Juni 2026 → berakhir 17 Juni 2029), sesuai Pemberitahuan Koreksi
     * Administratif No. 553/SPT/EDUKIA/X/2026.
     */
    public static function tanggalBerakhir(CarbonInterface $mulai): CarbonInterface
    {
        return $mulai->copy()->startOfDay()->addYearsNoOverflow(3)->subDay();
    }

    /**
     * Data lama (register Excel) mencantumkan tanggal berakhir tepat 3 tahun setelah tanggal
     * terbit. Tanggal berpola lama itu dikoreksi ke tanggalBerakhir(); tanggal lain (sudah
     * benar, atau memang berbeda) dikembalikan apa adanya.
     */
    public static function koreksiTanggalBerakhir(?CarbonInterface $terbit, ?CarbonInterface $berakhir): ?CarbonInterface
    {
        if (! $terbit || ! $berakhir) {
            return $berakhir;
        }

        $polaLama = $terbit->copy()->startOfDay()->addYearsNoOverflow(3);

        return $berakhir->isSameDay($polaLama) ? self::tanggalBerakhir($terbit) : $berakhir;
    }

    /** Sertifikat terbit dalam periode yang dicakup pemberitahuan koreksi masa berlaku. */
    public function getTercakupKoreksiMasaBerlakuAttribute(): bool
    {
        return $this->tanggal_terbit !== null
            && $this->tanggal_terbit->lte(self::AKHIR_PERIODE_KOREKSI);
    }

    public function scopeTampil(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('tampil', true);
    }
}

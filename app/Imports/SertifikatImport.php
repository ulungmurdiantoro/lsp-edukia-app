<?php

namespace App\Imports;

use App\Models\Sertifikat;
use App\Support\SertifikatExcelHelper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

/**
 * Import via tombol "Import Excel" di admin. Mengikuti format register resmi
 * FR.AK.09 LSP Edukia: No, Nama Lengkap, Skema, Batch, No Skema, No Sertifikat,
 * No SK, Nama Gelar, Tanggal Rilis, Tanggal_Berakhir, ditambah kolom Lisensi.
 * Kolom "Batch" tidak disimpan (tidak ada padanan field di tabel sertifikats).
 */
class SertifikatImport implements ToModel, WithHeadingRow, WithUpserts
{
    // Dimuat sekali (bukan per baris) untuk mempertahankan nilai lisensi yang sudah ada
    // di database saat kolom "Lisensi" kosong/tidak ada di file yang diimport.
    private ?array $lisensiTersimpan = null;

    /**
     * Kolom "lisensi" wajib selalu ada di array yang dikembalikan model() karena upsert()
     * dari maatwebsite/excel membangun daftar kolom UPDATE dari baris pertama batch,
     * lalu menerapkannya ke semua baris — kalau ada baris yang tidak menyertakan kolom ini
     * sama sekali, query upsert-nya akan gagal (kolom tidak konsisten antar baris).
     *
     * Karena itu, jika file yang diimport tidak mengisi kolom "Lisensi" untuk suatu baris,
     * nilai lisensi yang SUDAH ADA di database untuk nomor sertifikat tsb dipertahankan
     * (bukan otomatis di-set false) — supaya import ulang tanpa kolom ini tidak diam-diam
     * menghapus status "Berlisensi KAN" yang sudah diisi manual/via import sebelumnya.
     */
    private function resolveLisensi(array $row, string $nomorSertifikat): bool
    {
        if (array_key_exists('lisensi', $row) && trim((string) $row['lisensi']) !== '') {
            return (bool) $row['lisensi'];
        }

        if ($this->lisensiTersimpan === null) {
            $this->lisensiTersimpan = Sertifikat::query()->pluck('lisensi', 'nomor_sertifikat')->all();
        }

        return (bool) ($this->lisensiTersimpan[$nomorSertifikat] ?? false);
    }

    public function model(array $row): ?Sertifikat
    {
        $nama = SertifikatExcelHelper::clean($row['nama_lengkap'] ?? '');
        $nomorSertifikat = SertifikatExcelHelper::clean($row['no_sertifikat'] ?? '');
        $noSkemaRaw = SertifikatExcelHelper::clean($row['no_skema'] ?? '');
        $skemaTextRaw = SertifikatExcelHelper::clean($row['skema'] ?? '');
        $noSk = SertifikatExcelHelper::clean($row['no_sk'] ?? '');
        $gelar = SertifikatExcelHelper::clean($row['nama_gelar'] ?? '');
        $tanggalTerbit = SertifikatExcelHelper::parseTanggal($row['tanggal_rilis'] ?? null);
        $tanggalKadaluarsa = SertifikatExcelHelper::parseTanggal($row['tanggal_berakhir'] ?? null);

        $scheme = SertifikatExcelHelper::resolveScheme($noSkemaRaw, $skemaTextRaw);

        // Baris kosong/contoh atau data tidak lengkap → lewati tanpa error.
        if ($nama === '' || $nomorSertifikat === '' || ! $tanggalTerbit || ! $scheme) {
            return null;
        }

        return new Sertifikat([
            'nama' => $nama,
            'gelar' => $gelar !== '' ? $gelar : null,
            'skema' => $scheme['skema'],
            'kategori' => $scheme['kategori'],
            'lisensi' => $this->resolveLisensi($row, $nomorSertifikat),
            'nomor_sertifikat' => $nomorSertifikat,
            'no_sk' => ($noSk !== '' && $noSk !== '-') ? $noSk : null,
            'no_skema' => $noSkemaRaw !== '' ? $noSkemaRaw : null,
            'tanggal_terbit' => $tanggalTerbit,
            'tanggal_kadaluarsa' => $tanggalKadaluarsa,
            'tampil' => true,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nomor_sertifikat';
    }
}

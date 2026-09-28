<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LamaranKarir extends Model
{
    /**
     * Kolom dokumen upload pelamar → label. File disimpan di disk privat 'local'
     * (storage/app/private) dan hanya bisa diunduh admin lewat route lamaran.dokumen.
     */
    public const DOKUMEN = [
        'cv' => 'CV',
        'portofolio' => 'Portofolio',
        'ijazah' => 'Ijazah',
        'sertifikat_pelatihan' => 'Sertifikat Pelatihan',
    ];

    public const DOKUMEN_DISK = 'local';

    protected $fillable = [
        'posisi', 'nama_lengkap', 'tempat_tanggal_lahir', 'nomor_whatsapp', 'domisili',
        'pendidikan_terakhir', 'jurusan', 'pengalaman_kerja', 'sertifikat_iso',
        'sertifikat_list', 'pengalaman_audit', 'cv', 'portofolio', 'ijazah',
        'sertifikat_pelatihan', 'bersedia_fulltime', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'bersedia_fulltime' => 'boolean',
    ];

    /**
     * URL unduh dokumen (butuh login admin), atau null bila dokumen tidak diunggah.
     */
    public function dokumenUrl(string $jenis): ?string
    {
        return $this->{$jenis} ? route('lamaran.dokumen', [$this, $jenis]) : null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LamaranKarir extends Model
{
    protected $fillable = [
        'posisi', 'nama_lengkap', 'tempat_tanggal_lahir', 'nomor_whatsapp', 'domisili',
        'pendidikan_terakhir', 'jurusan', 'pengalaman_kerja', 'sertifikat_iso',
        'sertifikat_list', 'pengalaman_audit', 'cv', 'portofolio', 'ijazah',
        'sertifikat_pelatihan', 'bersedia_fulltime', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'bersedia_fulltime' => 'boolean',
    ];
}

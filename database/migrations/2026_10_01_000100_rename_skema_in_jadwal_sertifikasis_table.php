<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Nama skema di App\Support\Skemas berubah mengikuti revisi dokumen skema (efektif
 * 15 September 2026). Kolom jadwal_sertifikasis.skema menyimpan nama skema sebagai teks,
 * jadi nama lama diganti agar jadwal tetap tertaut ke halaman skema & tetap valid di admin.
 */
return new class extends Migration
{
    /** nama baru => nama lama yang pernah dipakai */
    private const PETA = [
        'Auditor Internal SPMI Terintegrasi ISO 21001:2025' => ['Auditor Internal SPMI Terintegrasi ISO 21001:2018'],
        'Lead Auditor SPMI Terintegrasi ISO 21001:2025' => ['Lead Auditor SPMI Terintegrasi ISO 21001:2018'],
        'Lead Implementer SPMI Terintegrasi ISO 21001:2025' => ['Lead Implementer SPMI Terintegrasi ISO 21001:2018'],
        'Lifting Engineer for Heavy & Critical Lifting' => ['Lifting Engineer for Heavy & Critical Lifting Operation'],
        'Laboratory Quality System Officer ISO/IEC 17025 / Petugas Sistem Mutu Laboratorium ISO/IEC 17025' => ['Laboratory Quality System Officer ISO/IEC 17025'],
        'GLP Laboratory Officer / Petugas Laboratorium Berbasis GLP' => ['GLP Laboratory Officer', 'GLP Laboratory Technician / Teknisi Laboratorium Berbasis GLP'],
        'QC Laboratory Officer / Petugas QC Laboratorium' => ['QC Laboratory Officer', 'QC Laboratory Analyst / Analis QC Laboratorium'],
    ];

    public function up(): void
    {
        foreach (self::PETA as $baru => $lama) {
            DB::table('jadwal_sertifikasis')->whereIn('skema', $lama)->update(['skema' => $baru]);
        }
    }

    public function down(): void
    {
        foreach (self::PETA as $baru => $lama) {
            DB::table('jadwal_sertifikasis')->where('skema', $baru)->update(['skema' => $lama[0]]);
        }
    }
};

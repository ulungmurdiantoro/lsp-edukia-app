<?php

namespace Database\Seeders;

use App\Models\JadwalSertifikasi;
use App\Support\Skemas;
use Illuminate\Database\Seeder;

/**
 * Dummy jadwal sertifikasi (belum selesai / akan datang) untuk mengisi
 * tampilan awal halaman /jadwal-sertifikasi-kompetensi sebelum admin
 * menginput jadwal sungguhan lewat panel admin.
 */
class JadwalSertifikasiDummySeeder extends Seeder
{
    public function run(): void
    {
        $dummy = [
            ['skema' => 'Panelis Terlatih Pengujian Sensori Pangan', 'tanggal' => '2026-08-20'],
            ['skema' => 'Laboratory Operations Officer / Pranata Laboratorium', 'tanggal' => '2026-08-27'],
            ['skema' => 'Training of Trainer (ToT) Outcome Based Education (OBE)', 'tanggal' => '2026-09-03'],
            ['skema' => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017', 'tanggal' => '2026-09-10'],
            ['skema' => 'Quality Management System (ISO 9001) Officer', 'tanggal' => '2026-09-17'],
            ['skema' => 'Auditor Internal SPMI Terintegrasi ISO 21001:2018', 'tanggal' => '2026-10-01'],
            ['skema' => 'Implementer Tata Kelola Organisasi Perguruan Tinggi', 'tanggal' => '2026-10-15'],
            ['skema' => 'GLP Laboratory Technician / Teknisi Laboratorium Berbasis GLP', 'tanggal' => '2026-10-22'],
            ['skema' => 'Lead Auditor SPMI Terintegrasi ISO 21001:2018', 'tanggal' => '2026-11-05'],
            ['skema' => 'Laboratory HSE Officer / Petugas K3L Laboratorium', 'tanggal' => '2026-11-12'],
            ['skema' => 'Corporate Legal Officer', 'tanggal' => '2026-11-26'],
            ['skema' => 'Environmental Management System (ISO 14001) Officer', 'tanggal' => '2026-12-03'],
            ['skema' => 'Quality Assurance Officer', 'tanggal' => '2026-12-10'],
            ['skema' => 'Sustainability Officer', 'tanggal' => '2026-12-17'],
        ];

        foreach ($dummy as $row) {
            $skema = Skemas::all()->firstWhere('nama', $row['skema']);

            JadwalSertifikasi::updateOrCreate(
                ['skema' => $row['skema'], 'tanggal_sertifikasi' => $row['tanggal']],
                [
                    'bidang' => $skema['bidang'] ?? 'manajemen',
                    'tampil' => true,
                ]
            );
        }

        $this->command->info(count($dummy).' dummy jadwal sertifikasi (belum selesai) berhasil dibuat.');
    }
}

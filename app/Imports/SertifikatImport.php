<?php

namespace App\Imports;

use App\Models\Sertifikat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SertifikatImport implements ToModel, WithHeadingRow, WithUpserts
{
    private static array $skemaKategori = [
        'Auditor Internal SPMI Terintegrasi ISO 21001:2018'          => 'spmi',
        'Lead Auditor Internal SPMI Terintegrasi ISO 21001:2018'     => 'spmi',
        'Lead Implementer SPMI Terintegrasi ISO 21001:2018'          => 'spmi',
        'Training of Trainer (ToT) Outcome Based Education (OBE)'    => 'pt',
        'Implementer Tata Kelola Organisasi Perguruan Tinggi'        => 'pt',
        'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017'   => 'lab17025',
        'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017'   => 'lab17025',
        'Lifting Engineer for Medium Lifting'                         => 'lifting',
        'Lifting Engineer for Heavy & Critical Lifting Operation'     => 'lifting',
        '2D Lifting Designer'                                        => 'lifting',
        '3D Lifting Designer'                                        => 'lifting',
        'Laboratory Quality System Officer ISO/IEC 17025'            => 'labtest',
        'Food Safety Management Officer'                              => 'labtest',
        'Panelis Terlatih Pengujian Sensori Pangan'                  => 'labtest',
        'GLP Laboratory Technician'                                   => 'labtest',
        'Laboratory HSE Officer'                                      => 'labtest',
        'Laboratory Operations Officer'                               => 'labtest',
        'QC Laboratory Analyst'                                       => 'labtest',
        'Quality Management System (ISO 9001) Officer'               => 'manajemen',
        'Quality Assurance Officer'                                   => 'manajemen',
        'Research and Development Officer'                            => 'manajemen',
        'Regulatory Affairs Officer'                                  => 'manajemen',
        'Sustainability Officer'                                      => 'manajemen',
        'ESG Officer'                                                 => 'manajemen',
        'Environmental Management System (ISO 14001) Officer'        => 'manajemen',
        'Corporate Legal Officer'                                     => 'hukum',
    ];

    private function resolveKategori(string $skema, ?string $kategoriFromRow): string
    {
        if (! empty($kategoriFromRow)) {
            return trim($kategoriFromRow);
        }

        $skemaTrimmed = trim($skema);

        // Exact match
        if (isset(self::$skemaKategori[$skemaTrimmed])) {
            return self::$skemaKategori[$skemaTrimmed];
        }

        // Case-insensitive match
        foreach (self::$skemaKategori as $key => $kat) {
            if (strcasecmp($skemaTrimmed, $key) === 0) {
                return $kat;
            }
        }

        // Partial / contains match
        $skemaLower = mb_strtolower($skemaTrimmed);
        foreach (self::$skemaKategori as $key => $kat) {
            if (str_contains($skemaLower, mb_strtolower(substr($key, 0, 20)))) {
                return $kat;
            }
        }

        return 'spmi'; // default fallback
    }

    public function model(array $row): Sertifikat
    {
        $skema    = trim($row['skema'] ?? '');
        $kategori = $this->resolveKategori($skema, $row['kategori'] ?? null);

        return new Sertifikat([
            'nama'               => $row['nama'],
            'gelar'              => $row['gelar'] ?? null,
            'skema'              => $skema,
            'kategori'           => $kategori,
            'nomor_sertifikat'   => $row['nomor_sertifikat'],
            'no_sk'              => $row['no_sk'] ?? null,
            'no_skema'           => $row['no_skema'] ?? null,
            'tanggal_terbit'     => Carbon::parse($row['tanggal_terbit']),
            'tanggal_kadaluarsa' => Carbon::parse($row['tanggal_kadaluarsa']),
            'tampil'             => isset($row['tampil']) ? (bool) $row['tampil'] : true,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nomor_sertifikat';
    }
}

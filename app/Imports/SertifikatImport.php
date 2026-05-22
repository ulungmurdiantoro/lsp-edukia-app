<?php

namespace App\Imports;

use App\Models\Sertifikat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SertifikatImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): Sertifikat
    {
        return new Sertifikat([
            'nama'               => $row['nama'],
            'skema'              => $row['skema'],
            'kategori'           => $row['kategori'],
            'nomor_sertifikat'   => $row['nomor_sertifikat'],
            'tanggal_terbit'     => Carbon::parse($row['tanggal_terbit']),
            'tanggal_kadaluarsa' => Carbon::parse($row['tanggal_kadaluarsa']),
            'tampil'             => isset($row['tampil']) ? (bool) $row['tampil'] : true,
        ]);
    }

    // Update jika nomor_sertifikat sudah ada, insert jika baru
    public function uniqueBy(): string
    {
        return 'nomor_sertifikat';
    }
}

<?php

namespace App\Jobs;

use App\Models\LamaranKarir;
use App\Services\GoogleSheetsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncLamaranToSheets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $backoff = 60; // retry setelah 60 detik bila API error

    public function __construct(
        private readonly LamaranKarir $lamaran
    ) {}

    public function handle(GoogleSheetsService $sheets): void
    {
        $headers = [
            'ID', 'Tanggal', 'Posisi', 'Nama Lengkap', 'TTL', 'WhatsApp',
            'Domisili', 'Pendidikan', 'Jurusan', 'Pengalaman Mutu',
            'Sertifikat ISO?', 'Daftar Sertifikat', 'Pengalaman Audit',
            'Full-time?', 'Status',
        ];

        $sheets->ensureHeader($headers);

        $sheets->appendRow([
            $this->lamaran->id,
            $this->lamaran->created_at?->format('d/m/Y H:i'),
            $this->lamaran->posisi,
            $this->lamaran->nama_lengkap,
            $this->lamaran->tempat_tanggal_lahir,
            $this->lamaran->nomor_whatsapp,
            $this->lamaran->domisili,
            $this->lamaran->pendidikan_terakhir,
            $this->lamaran->jurusan,
            $this->lamaran->pengalaman_kerja,
            $this->lamaran->sertifikat_iso,
            $this->lamaran->sertifikat_list ?? '',
            $this->lamaran->pengalaman_audit,
            $this->lamaran->bersedia_fulltime ? 'YA' : 'TIDAK',
            $this->lamaran->status,
        ]);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SyncLamaranToSheets gagal', [
            'lamaran_id' => $this->lamaran->id,
            'error'      => $e->getMessage(),
        ]);
    }
}

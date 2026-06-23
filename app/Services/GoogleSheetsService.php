<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Kirim data ke Google Sheets via Google Apps Script Web App.
 * Tidak membutuhkan service account key — cukup Web App URL dari Apps Script.
 *
 * Setup:
 * 1. Buka spreadsheet → Extensions → Apps Script
 * 2. Paste script dari GOOGLE_APPS_SCRIPT.md
 * 3. Deploy → New deployment → Web app → Execute as: Me, Who has access: Anyone
 * 4. Copy Web App URL → isi GOOGLE_SHEETS_WEBHOOK_URL di .env
 */
class GoogleSheetsService
{
    private string $webhookUrl;

    public function __construct()
    {
        $this->webhookUrl = config('google-sheets.webhook_url', '');
    }

    public function appendRow(array $values): void
    {
        if (empty($this->webhookUrl)) {
            Log::warning('GoogleSheetsService: GOOGLE_SHEETS_WEBHOOK_URL belum diisi.');
            return;
        }

        $response = Http::timeout(10)->post($this->webhookUrl, [
            'values' => $values,
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException(
                'Google Sheets webhook error: '.$response->status().' '.$response->body()
            );
        }
    }

    public function ensureHeader(array $headers): void
    {
        // Header dikelola langsung di Apps Script (baris pertama tetap).
    }
}

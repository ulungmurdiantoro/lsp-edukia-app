<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Sheets — Lamaran Karir Sync via Apps Script Webhook
    |--------------------------------------------------------------------------
    |
    | webhook_url : URL dari Google Apps Script Web App deployment.
    |   Cara setup:
    |   1. Buka spreadsheet → Extensions → Apps Script
    |   2. Paste kode dari instruksi di bawah
    |   3. Deploy → New deployment → Web app
    |      - Execute as  : Me (akun Google Anda)
    |      - Who has access: Anyone
    |   4. Copy URL → isi di GOOGLE_SHEETS_WEBHOOK_URL (.env)
    |
    */

    'webhook_url' => env('GOOGLE_SHEETS_WEBHOOK_URL', ''),
];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Sheets — Lamaran Karir Sync
    |--------------------------------------------------------------------------
    |
    | credentials_path : Path absolut ke file JSON service account Google.
    |   Gunakan service account yang sama dengan Analytics, atau buat baru.
    |   Pastikan service account di-share ke Spreadsheet dengan role Editor.
    |
    | spreadsheet_id   : ID spreadsheet dari URL Google Sheets.
    |   Contoh URL: docs.google.com/spreadsheets/d/1aBcD.../edit
    |   ID-nya adalah bagian "1aBcD..." di antara /d/ dan /edit.
    |
    */

    'credentials_path' => env(
        'GOOGLE_SHEETS_CREDENTIALS',
        storage_path('app/analytics/service-account-credentials.json')
    ),

    'spreadsheet_id' => env('GOOGLE_SHEETS_SPREADSHEET_ID', ''),
];

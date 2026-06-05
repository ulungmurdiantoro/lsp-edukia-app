<?php

return [
    /*
     * Property ID Google Analytics 4 (GA4). Ambil di GA4 → Admin → Property Settings.
     * Isi via .env: ANALYTICS_PROPERTY_ID=
     */
    'property_id' => env('ANALYTICS_PROPERTY_ID'),

    /*
     * Path ke file kredensial service account (JSON) dari Google Cloud.
     * Letakkan di: storage/app/analytics/service-account-credentials.json
     * (di luar git — sudah aman karena storage/ tidak di-commit).
     */
    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),

    /*
     * Lama cache respons Google API (menit). Default 1 hari.
     */
    'cache_lifetime_in_minutes' => 60 * 24,

    'cache' => [
        'store' => 'file',
    ],
];

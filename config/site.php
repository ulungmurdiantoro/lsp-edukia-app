<?php

return [
    /**
     * Pengukuran & verifikasi search engine (Fase 1 blueprint SEO).
     * Isi via .env — kosong = tag tidak dirender.
     */
    'google_analytics_id'   => env('GOOGLE_ANALYTICS_ID'),       // mis. G-XXXXXXXXXX
    'gsc_verification'      => env('GOOGLE_SITE_VERIFICATION'),   // token meta Google Search Console
    'bing_verification'     => env('BING_SITE_VERIFICATION'),     // token meta Bing Webmaster Tools

    /**
     * Paksa skema HTTPS untuk URL yang digenerate (canonical, OG, sitemap).
     * Aktif otomatis di production; dapat dipaksa via APP_FORCE_HTTPS=true.
     */
    'force_https' => env('APP_FORCE_HTTPS', env('APP_ENV') === 'production'),

    /**
     * Profil sosial resmi — dipakai untuk schema Organization `sameAs`
     * (memperkuat entity di Knowledge Graph). Isi via .env, pisahkan dengan koma.
     */
    'social' => array_values(array_filter(array_map('trim', explode(',', (string) env('SOCIAL_PROFILES', ''))))),

    /**
     * Kontak & identitas lembaga (dipakai schema & footer).
     */
    'phone'   => env('SITE_PHONE', '+6285175479385'),
    'whatsapp'=> env('SITE_WHATSAPP', '6285175479385'),
    'email'   => env('SITE_EMAIL', 'edukasi.cendekia@gmail.com'),
];

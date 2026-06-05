<?php

use RalphJSmit\Laravel\SEO\Models\SEO;

return [
    /**
     * Model SEO. Override jika ingin memakai model kustom (selalu extend SEO bawaan).
     */
    'model' => SEO::class,

    /**
     * Nama situs yang dipakai di tag OpenGraph.
     */
    'site_name' => 'LSP Edukia',

    /**
     * Path sitemap (relatif terhadap root domain). Lihat SitemapController / spatie/laravel-sitemap.
     */
    'sitemap' => '/sitemap.xml',

    /**
     * Self-referencing canonical pada setiap halaman (rekomendasi Google & Yoast).
     */
    'canonical_link' => true,

    'robots' => [
        'default' => 'max-snippet:-1,max-image-preview:large,max-video-preview:-1',
        'force_default' => false,
    ],

    /**
     * Favicon — dipublikasikan dari folder public.
     */
    'favicon' => '/favicon.ico',

    'title' => [
        /**
         * Infer judul dari URL bila tidak ada judul eksplisit.
         */
        'infer_title_from_url' => true,

        /**
         * Suffix di belakang setiap judul halaman (kecuali homepage_title).
         */
        'suffix' => ' — LSP Edukia',

        /**
         * Judul khusus homepage (tanpa suffix).
         */
        'homepage_title' => 'LSP Edukia — Sertifikasi Kompetensi Profesional BNSP',
    ],

    'description' => [
        'fallback' => 'LSP Edukia adalah lembaga sertifikasi profesi terakreditasi BNSP dengan 26 skema kompetensi di bidang pendidikan tinggi, manajemen mutu, laboratorium, lifting engineering, dan hukum korporasi.',
    ],

    'image' => [
        /**
         * Gambar OG fallback (path dari folder public).
         */
        'fallback' => 'images/hero-index.jpg',
    ],

    'author' => [
        'fallback' => 'Tim LSP Edukia',
    ],

    'twitter' => [
        '@username' => null,
    ],
];

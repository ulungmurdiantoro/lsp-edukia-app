<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Analisis SEO on-page ala Yoast untuk satu artikel.
 * Murni PHP — tanpa dependency eksternal. Menghasilkan skor 0–100 + daftar pemeriksaan.
 */
class SeoAnalyzer
{
    /**
     * @param  array{judul?:?string,ringkasan?:?string,konten?:?string,slug?:?string,thumbnail?:mixed,focus_keyword?:?string}  $data
     * @return array{score:int,label:string,color:string,checks:array<int,array{status:string,text:string}>}
     */
    public static function analyze(array $data): array
    {
        $judul = trim((string) ($data['judul'] ?? ''));
        $ringkasan = trim((string) ($data['ringkasan'] ?? ''));
        $kontenText = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($data['konten'] ?? ''))));
        $kontenRaw = (string) ($data['konten'] ?? '');
        $slug = trim((string) ($data['slug'] ?? ''));
        $keyword = trim((string) ($data['focus_keyword'] ?? ''));
        $hasImage = ! empty($data['thumbnail']);

        $judulLen = Str::length($judul);
        $descLen = Str::length($ringkasan);
        $wordCount = $kontenText === '' ? 0 : str_word_count($kontenText);

        $checks = [];

        // ── Panjang judul ──────────────────────────────────────────────
        $checks[] = match (true) {
            $judulLen === 0 => ['status' => 'bad', 'text' => 'Judul belum diisi.'],
            $judulLen >= 40 && $judulLen <= 60 => ['status' => 'good', 'text' => "Panjang judul ideal ({$judulLen} karakter)."],
            $judulLen >= 30 && $judulLen <= 65 => ['status' => 'ok', 'text' => "Panjang judul cukup ({$judulLen} kar.) — ideal 40–60."],
            default => ['status' => 'bad', 'text' => "Panjang judul {$judulLen} kar. — sebaiknya 40–60."],
        };

        // ── Meta description (ringkasan) ───────────────────────────────
        $checks[] = match (true) {
            $descLen === 0 => ['status' => 'bad', 'text' => 'Meta description (ringkasan) belum diisi.'],
            $descLen >= 120 && $descLen <= 160 => ['status' => 'good', 'text' => "Panjang meta description ideal ({$descLen} kar.)."],
            $descLen >= 80 && $descLen <= 170 => ['status' => 'ok', 'text' => "Meta description {$descLen} kar. — ideal 120–155."],
            default => ['status' => 'bad', 'text' => "Meta description {$descLen} kar. — sebaiknya 120–155."],
        };

        // ── Panjang konten ─────────────────────────────────────────────
        $checks[] = match (true) {
            $wordCount >= 300 => ['status' => 'good', 'text' => "Panjang konten baik ({$wordCount} kata)."],
            $wordCount >= 150 => ['status' => 'ok', 'text' => "Konten {$wordCount} kata — usahakan ≥ 300 kata."],
            default => ['status' => 'bad', 'text' => "Konten terlalu pendek ({$wordCount} kata) — minimal 300."],
        };

        // ── Gambar utama ───────────────────────────────────────────────
        $checks[] = $hasImage
            ? ['status' => 'good', 'text' => 'Gambar utama (thumbnail) sudah diatur.']
            : ['status' => 'bad', 'text' => 'Belum ada gambar utama (thumbnail).'];

        // ── Link internal di konten ────────────────────────────────────
        $hasInternalLink = (bool) preg_match('/href=["\'](\/(?!\/)|https?:\/\/[^"\']*lspedukia\.id)/i', $kontenRaw);
        $checks[] = $hasInternalLink
            ? ['status' => 'good', 'text' => 'Ada tautan internal di konten.']
            : ['status' => 'ok', 'text' => 'Belum ada tautan internal — tautkan ke skema/artikel lain.'];

        // ── Pemeriksaan berbasis keyword fokus ─────────────────────────
        if ($keyword === '') {
            $checks[] = ['status' => 'bad', 'text' => 'Keyword fokus belum diisi — isi untuk analisis lebih akurat.'];
        } else {
            $kw = Str::lower($keyword);

            $checks[] = Str::contains(Str::lower($judul), $kw)
                ? ['status' => 'good', 'text' => 'Keyword fokus muncul di judul.']
                : ['status' => 'bad', 'text' => 'Keyword fokus tidak ada di judul.'];

            $checks[] = Str::contains($slug, Str::slug($keyword))
                ? ['status' => 'good', 'text' => 'Keyword fokus muncul di slug URL.']
                : ['status' => 'ok', 'text' => 'Keyword fokus tidak ada di slug URL.'];

            $checks[] = Str::contains(Str::lower($ringkasan), $kw)
                ? ['status' => 'good', 'text' => 'Keyword fokus muncul di meta description.']
                : ['status' => 'ok', 'text' => 'Keyword fokus tidak ada di meta description.'];

            $awalKonten = Str::lower(Str::words($kontenText, 60, ''));
            $checks[] = Str::contains($awalKonten, $kw)
                ? ['status' => 'good', 'text' => 'Keyword fokus muncul di awal konten.']
                : ['status' => 'ok', 'text' => 'Keyword fokus tidak muncul di paragraf awal konten.'];

            // Densitas keyword
            $occurrences = $wordCount > 0 ? substr_count(Str::lower($kontenText), $kw) : 0;
            $density = $wordCount > 0 ? round(($occurrences * str_word_count($kw)) / $wordCount * 100, 2) : 0;
            $checks[] = match (true) {
                $occurrences === 0 => ['status' => 'bad', 'text' => 'Keyword fokus tidak muncul di konten.'],
                $density >= 0.5 && $density <= 2.5 => ['status' => 'good', 'text' => "Densitas keyword ideal ({$density}%, {$occurrences}×)."],
                $density > 2.5 => ['status' => 'ok', 'text' => "Densitas keyword agak tinggi ({$density}%) — hindari berlebihan."],
                default => ['status' => 'ok', 'text' => "Densitas keyword rendah ({$density}%) — tambah penyebutan natural."],
            };
        }

        // ── Skor ───────────────────────────────────────────────────────
        $weights = ['good' => 1.0, 'ok' => 0.5, 'bad' => 0.0];
        $total = count($checks);
        $sum = array_sum(array_map(fn ($c) => $weights[$c['status']], $checks));
        $score = $total > 0 ? (int) round($sum / $total * 100) : 0;

        [$label, $color] = match (true) {
            $score >= 80 => ['Sangat Baik', '#2f8a55'],
            $score >= 60 => ['Baik', '#2a7fc4'],
            $score >= 40 => ['Cukup', '#d77110'],
            default => ['Perlu Perbaikan', '#c0532e'],
        };

        return compact('score', 'label', 'color', 'checks');
    }
}

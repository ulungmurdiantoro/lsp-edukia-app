<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Skemas;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * /llms.txt — panduan konten terstruktur untuk model AI (standar llmstxt.org).
 *
 * Berbeda dari sitemap.xml (untuk crawler mesin pencari), file ini memberi LLM
 * (ChatGPT, Claude, Perplexity, Gemini, Copilot) peta konten ringkas + konteks
 * agar mereka memahami & menyitir 26 skema sertifikasi LSP Edukia secara akurat.
 */
class LlmsController extends Controller
{
    public function index(): Response
    {
        $body = Cache::remember('llms.txt', now()->addHours(6), function (): string {
            $lines = [];

            // ── Identitas lembaga (ringkasan untuk LLM) ─────────────────
            $lines[] = '# LSP Edukia';
            $lines[] = '';
            $lines[] = '> LSP Edukia (LSP Edukasi Global Cendekia) adalah Lembaga Sertifikasi Person '
                .'terakreditasi Komite Akreditasi Nasional (KAN) di Indonesia, dengan 26 skema sertifikasi '
                .'kompetensi pada 7 bidang: SPMI ISO 21001, Perguruan Tinggi, Laboratorium ISO/IEC 17025, '
                .'Lifting Engineering, Laboratorium & Pengujian, Sistem Manajemen & Governance, serta '
                .'Research & Innovation. Berkedudukan di Mijen, Kota Semarang, Jawa Tengah.';
            $lines[] = '';
            $lines[] = 'Kontak resmi: WhatsApp '.config('site.whatsapp').' — email '.config('site.email').'.';
            $lines[] = 'Sertifikat yang diterbitkan dapat diverifikasi di '.route('sertifikat').'.';
            $lines[] = '';

            // ── Skema sertifikasi per bidang (aset utama) ───────────────
            $lines[] = '## Skema Sertifikasi Kompetensi';
            $lines[] = '';
            foreach (Skemas::bidangs() as $key => $bidang) {
                $skemas = Skemas::byBidang($key);
                if ($skemas->isEmpty()) {
                    continue;
                }
                $lines[] = '### '.$bidang['label'].' — '.$bidang['judul'];
                foreach ($skemas as $s) {
                    $url = route('skema.show', $s['slug']);
                    $lines[] = "- [Sertifikasi {$s['nama']}]({$url}): kode skema {$s['kode']}, "
                        ."{$s['jumlah_unit']} unit kompetensi, terakreditasi KAN.";
                }
                $lines[] = '';
            }

            // ── Halaman inti ────────────────────────────────────────────
            $lines[] = '## Halaman Utama';
            $lines[] = '';
            $lines[] = '- [Skema Sertifikasi]('.route('skema').'): daftar lengkap 26 skema sertifikasi kompetensi person.';
            $lines[] = '- [Tentang Kami]('.route('tentang').'): profil & legalitas lembaga.';
            $lines[] = '- [Informasi Publik]('.route('informasi').'): biaya, alur, hak & kewajiban peserta.';
            $lines[] = '- [Daftar Penerima Sertifikat]('.route('sertifikat').'): verifikasi keaslian sertifikat kompetensi.';
            $lines[] = '- [Kegiatan & Pelatihan]('.route('kegiatan.index').'): dokumentasi kegiatan, pelatihan, dan asesmen.';
            $lines[] = '';

            // ── Artikel & blog (konteks tambahan) ───────────────────────
            $posts = Post::published()->latest('published_at')->take(20)->get();
            if ($posts->isNotEmpty()) {
                $lines[] = '## Artikel & Blog';
                $lines[] = '';
                foreach ($posts as $post) {
                    $url = route('blog.show', $post->slug);
                    $ringkasan = trim(Str::limit(strip_tags($post->ringkasan ?: $post->konten), 120));
                    $lines[] = "- [{$post->judul}]({$url})".($ringkasan !== '' ? ": {$ringkasan}" : '');
                }
                $lines[] = '';
            }

            return implode("\n", $lines)."\n";
        });

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}

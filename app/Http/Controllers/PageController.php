<?php

namespace App\Http\Controllers;

use App\Models\Booklet;
use App\Models\JadwalSertifikasi;
use App\Models\Kegiatan;
use App\Models\Post;
use App\Models\Sertifikat;
use App\Support\Skemas;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PageController extends Controller
{
    /**
     * Kartu skema untuk beranda, diturunkan langsung dari Skemas (satu-satunya sumber data
     * skema) — sebelumnya method ini punya salinan manual 26 skema yang gampang tidak sinkron
     * dengan Skemas::data() (kejadian nyata: kategori Corporate Legal Officer & Research and
     * Development Officer berbeda antara sini dan halaman detail skema).
     */
    private function schemes(): array
    {
        return Skemas::all()
            ->values()
            ->map(fn (array $s, int $i): array => [
                'nomor' => str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
                'kode' => $s['kode'],
                'judul' => $s['nama'],
                'kategori' => $s['bidang'],
                'jumlah_unit' => $s['jumlah_unit'],
                'popular' => $s['popular'] ?? false,
                'lisensi_kan' => $s['lisensi_kan'],
                'gelar' => $s['gelar'] ?? null,
                'reqs' => $s['persyaratan'],
                'slug' => $s['slug'],
            ])->all();
    }

    public function home()
    {
        $schemes = $this->schemes();
        $kategoriCounts = collect($schemes)->countBy('kategori');
        $kegiatan = Post::published()->where('kategori', 'Kegiatan')->latest('published_at')->take(9)->get();

        $seo = new SEOData(
            schema: SchemaCollection::initialize()
                ->addFaqPage(fn ($faq) => $faq
                    ->addQuestion('Apakah LSP Edukia terakreditasi KAN?', 'Ya. LSP Edukia (LSP Edukasi Global Cendekia) adalah Lembaga Sertifikasi Person yang terakreditasi Komite Akreditasi Nasional (KAN). Saat ini 7 dari 26 skema kompetensi telah berlisensi KAN, sisanya merupakan skema LSP Edukia yang belum berlisensi KAN.')
                    ->addQuestion('Berapa skema sertifikasi yang tersedia di LSP Edukia?', 'Tersedia 26 skema sertifikasi kompetensi pada 7 bidang: SPMI ISO 21001, Perguruan Tinggi, Laboratorium ISO/IEC 17025, Lifting Engineering, Laboratorium & Pengujian, Sistem Manajemen & Governance, serta Research & Innovation. Sebanyak 7 skema di antaranya telah berlisensi KAN.')
                    ->addQuestion('Bagaimana cara mendaftar uji kompetensi di LSP Edukia?', 'Pilih skema sertifikasi yang sesuai di halaman Skema Sertifikasi, periksa persyaratan pemohon, lalu hubungi tim kami melalui WhatsApp untuk informasi jadwal dan biaya uji kompetensi.')
                    ->addQuestion('Apakah sertifikat LSP Edukia bisa diverifikasi?', 'Ya. Seluruh penerima sertifikat dapat ditelusuri pada halaman Daftar Penerima Sertifikat berdasarkan nama, nomor sertifikat, atau skema kompetensi.')),
        );

        return view('index', compact('schemes', 'kegiatan', 'kategoriCounts'))
            ->with('activeNav', 'home')
            ->with('SEOData', $seo);
    }

    public function informasi()
    {
        return view('informasi-publik')
            ->with('activeNav', 'informasi')
            ->with('SEOData', new SEOData(
                title: 'Informasi Publik',
                description: 'Informasi publik LSP Edukia: profil lembaga, legalitas, skema sertifikasi, biaya, serta hak dan kewajiban peserta sertifikasi kompetensi person terakreditasi KAN.',
                image: 'images/hero-informasi.jpg',
            ));
    }

    public function tentang()
    {
        return view('tantang-kami')
            ->with('activeNav', 'tentang')
            ->with('SEOData', new SEOData(
                title: 'Tentang Kami',
                description: 'Mengenal LSP Edukia (LSP Edukasi Global Cendekia) — lembaga sertifikasi person terakreditasi KAN yang berkomitmen mencetak SDM unggul dan tersertifikasi.',
                image: 'images/hero-tentang.jpg',
            ));
    }

    public function skema()
    {
        $bidangs = Skemas::bidangs();
        $allSkema = Skemas::all();
        $skemas = $allSkema->groupBy('bidang');

        return view('skema-sertifikasi', compact('bidangs', 'skemas'))
            ->with('activeNav', 'skema')
            ->with('SEOData', new SEOData(
                title: 'Skema Sertifikasi Kompetensi Person',
                description: '26 skema sertifikasi kompetensi person di LSP Edukia (7 skema telah berlisensi KAN): SPMI ISO 21001, OBE, laboratorium ISO 17025, lifting engineering, sistem manajemen ISO 9001/14001, hingga hukum korporasi.',
                image: 'images/hero-skema.jpg',
                // ItemList: enumerasi seluruh 26 judul skema agar mesin pencari & model AI
                // mengenali tiap judul + URL detailnya dari satu halaman daftar (rich result).
                schema: SchemaCollection::initialize()
                    ->push(fn (SEOData $d): array => [
                        '@context' => 'https://schema.org',
                        '@type' => 'ItemList',
                        'name' => 'Skema Sertifikasi Kompetensi LSP Edukia',
                        'description' => 'Daftar 26 skema sertifikasi kompetensi person di LSP Edukia; 7 skema telah berlisensi KAN.',
                        'numberOfItems' => $allSkema->count(),
                        'itemListElement' => $allSkema->values()
                            ->map(fn (array $s, int $i): array => [
                                '@type' => 'ListItem',
                                'position' => $i + 1,
                                'name' => 'Sertifikasi '.$s['nama'],
                                'url' => route('skema.show', $s['slug']),
                            ])->all(),
                    ])
                    ->addBreadcrumbs(fn (BreadcrumbListSchema $b): BreadcrumbListSchema => $b->prependBreadcrumbs([
                        'Beranda' => url('/'),
                    ])),
            ));
    }

    public function sertifikat()
    {
        $now = now();
        $stats = [
            'total' => Sertifikat::tampil()->count(),
            'aktif' => Sertifikat::tampil()->where(fn ($q) => $q->whereNull('tanggal_kadaluarsa')->orWhere('tanggal_kadaluarsa', '>', $now->copy()->addDays(90)))->count(),
            'expiring' => Sertifikat::tampil()->whereBetween('tanggal_kadaluarsa', [$now, $now->copy()->addDays(90)])->count(),
            'kadaluarsa' => Sertifikat::tampil()->where('tanggal_kadaluarsa', '<', $now)->count(),
        ];
        $catCounts = Sertifikat::tampil()
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('sertifikat', compact('stats', 'catCounts'))
            ->with('activeNav', 'sertifikat')
            ->with('SEOData', new SEOData(
                title: 'Daftar Penerima Sertifikat',
                description: 'Verifikasi keaslian sertifikat kompetensi yang diterbitkan LSP Edukia. Cari berdasarkan nama, nomor sertifikat, atau skema sertifikasi kompetensi person.',
                image: 'images/hero-sertifikat.jpg',
            ));
    }

    public function sertifikatSearch(Request $request)
    {
        $now = now();
        $query = Sertifikat::tampil()->orderByDesc('tanggal_terbit');

        if ($q = trim($request->get('q', ''))) {
            $query->where(fn ($sq) => $sq
                ->where('nama', 'like', "%{$q}%")
                ->orWhere('nomor_sertifikat', 'like', "%{$q}%")
                ->orWhere('skema', 'like', "%{$q}%")
            );
        }

        if ($kat = $request->get('kategori')) {
            $query->where('kategori', $kat);
        }

        match ($request->get('lisensi')) {
            'ya' => $query->where('lisensi', true),
            'tidak' => $query->where('lisensi', false),
            default => null,
        };

        match ($request->get('status')) {
            'aktif' => $query->where(fn ($sq) => $sq->whereNull('tanggal_kadaluarsa')->orWhere('tanggal_kadaluarsa', '>', $now->copy()->addDays(90))),
            'expiring' => $query->whereBetween('tanggal_kadaluarsa', [$now, $now->copy()->addDays(90)]),
            'kadaluarsa' => $query->where('tanggal_kadaluarsa', '<', $now),
            default => null,
        };

        $paginator = $query->paginate(25);

        return response()->json([
            'data' => $paginator->getCollection()->map(fn ($c) => [
                'nama' => $c->nama,
                'gelar' => $c->gelar,
                'skema' => $c->skema,
                'kategori' => $c->kategori,
                'lisensi' => $c->lisensi,
                'nomor_sertifikat' => $c->nomor_sertifikat,
                'tanggal_kadaluarsa' => $c->tanggal_kadaluarsa?->translatedFormat('d M Y'),
                'status' => $c->status,
            ]),
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ]);
    }

    public function jadwalSertifikasi()
    {
        // Slug skema dipetakan sekali agar tiap jadwal bisa menaut ke halaman detail skema.
        $slugsByNama = Skemas::all()->pluck('slug', 'nama');

        $jadwal = JadwalSertifikasi::tampil()
            ->orderBy('tanggal_sertifikasi')
            ->get()
            ->each(fn (JadwalSertifikasi $item) => $item->skema_slug = $slugsByNama->get($item->skema));

        // Jadwal yang sudah lewat dipindah ke bagian bawah halaman (terbaru lebih dulu).
        [$selesai, $mendatang] = $jadwal->partition(
            fn (JadwalSertifikasi $item) => $item->tanggal_sertifikasi->lt(now()->startOfDay())
        );
        $perBulan = fn ($items) => $items
            ->groupBy(fn (JadwalSertifikasi $item) => $item->tanggal_sertifikasi->translatedFormat('F Y'))
            ->map(fn ($items) => $items->values());

        $bulan = $perBulan($mendatang);
        $bulanSelesai = $perBulan($selesai->reverse());

        return view('jadwal-sertifikasi', compact('bulan', 'bulanSelesai'))
            ->with('activeNav', 'jadwal')
            ->with('SEOData', new SEOData(
                title: 'Jadwal Sertifikasi Kompetensi',
                description: 'Jadwal pelaksanaan sertifikasi kompetensi LSP Edukia per bulan, mencakup skema SPMI ISO 21001, Perguruan Tinggi, Laboratorium ISO/IEC 17025, Lifting Engineering, Sistem Manajemen, dan lainnya.',
                image: 'images/hero-jadwal.jpg',
                schema: SchemaCollection::initialize()
                    ->addBreadcrumbs(fn (BreadcrumbListSchema $b): BreadcrumbListSchema => $b->prependBreadcrumbs([
                        'Beranda' => url('/'),
                    ])),
            ));
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::aktif()->paginate(12);

        return view('kegiatan.index', compact('kegiatan'))
            ->with('activeNav', '')
            ->with('SEOData', new SEOData(
                title: 'Kegiatan & Pelatihan',
                description: 'Dokumentasi kegiatan sertifikasi, pelatihan, dan asesmen kompetensi yang diselenggarakan LSP Edukia bersama mitra industri dan perguruan tinggi.',
                schema: SchemaCollection::initialize()
                    ->addBreadcrumbs(fn (BreadcrumbListSchema $b) => $b->prependBreadcrumbs([
                        'Beranda' => url('/'),
                    ])),
            ));
    }

    public function booklet()
    {
        $booklets = Booklet::tampil()->orderBy('urutan')->latest()->get();

        return view('booklet', compact('booklets'))
            ->with('activeNav', 'booklet')
            ->with('SEOData', new SEOData(
                title: 'Booklet',
                description: 'Baca dan unduh booklet resmi LSP Edukia: profil lembaga, skema sertifikasi kompetensi person, serta informasi alur dan persyaratan uji kompetensi.',
                image: 'images/hero-informasi.jpg',
                schema: SchemaCollection::initialize()
                    ->addBreadcrumbs(fn (BreadcrumbListSchema $b): BreadcrumbListSchema => $b->prependBreadcrumbs([
                        'Beranda' => url('/'),
                    ])),
            ));
    }

    public function webinarGerakanNasional()
    {
        $assets = [
            [
                'label' => 'Materi',
                'desc' => 'Slide & bahan presentasi narasumber selama sesi webinar.',
                'url' => 'https://drive.google.com/drive/folders/1BYtEAeFicJQTjLGL-YfIiVcQedyIpO5v?usp=sharing',
                'icon' => 'i-doc', 'tone' => 'blue',
            ],
            [
                'label' => 'Dokumentasi',
                'desc' => 'Galeri foto dan dokumentasi pelaksanaan kegiatan.',
                'url' => 'https://drive.google.com/drive/folders/1kJEE6tuW55pT9Z5AdGWTOk6NdLCsSDVi?usp=sharing',
                'icon' => 'i-image', 'tone' => 'orange',
            ],
            [
                'label' => 'Rekaman',
                'desc' => 'Video rekaman penuh seluruh sesi webinar.',
                'url' => 'https://drive.google.com/drive/folders/1gJOC0eqDLL_sHQBsOIlYo6a2HJa3WNng?usp=sharing',
                'icon' => 'i-monitor', 'tone' => 'blue',
            ],
            [
                'label' => 'Sertifikat',
                'desc' => 'Unduh e-sertifikat partisipasi peserta webinar.',
                'url' => 'https://drive.google.com/drive/folders/1ezngfDFaBpEgnEWleEwT8S7qLuKWu6r2?usp=sharing',
                'icon' => 'i-award', 'tone' => 'orange',
            ],
        ];

        $posts = Post::published()->latest('published_at')->take(6)->get();

        return view('webinar.gerakan-nasional', compact('assets', 'posts'))
            ->with('activeNav', '')
            ->with('SEOData', new SEOData(
                title: 'Hasil Webinar Gerakan Nasional Sertifikasi Kompetensi SDM Perguruan Tinggi & Laboratorium ISO/IEC 17025',
                description: 'Materi, dokumentasi, rekaman, dan sertifikat Webinar Gerakan Nasional Sertifikasi Kompetensi SDM Perguruan Tinggi & Laboratorium ISO/IEC 17025 Berstandar Internasional bersama LSP Edukia.',
                image: 'images/hero-informasi.jpg',
                schema: SchemaCollection::initialize()
                    ->addBreadcrumbs(fn (BreadcrumbListSchema $b) => $b->prependBreadcrumbs([
                        'Beranda' => url('/'),
                        'Kegiatan' => route('kegiatan.index'),
                    ])),
            ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\Skemas;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SkemaController extends Controller
{
    /** Halaman detail satu skema: /skema-sertifikasi/{slug} */
    public function show(string $slug)
    {
        $skema = Skemas::find($slug);

        if (! $skema) {
            throw new NotFoundHttpException("Skema '{$slug}' tidak ditemukan.");
        }

        $related = Skemas::related($skema);
        $bidangs = Skemas::bidangs();

        $lisensiFrasa = $skema['lisensi_kan'] ? 'berlisensi KAN' : 'belum berlisensi KAN';
        $deskripsi = "Sertifikasi {$skema['nama']} dari LSP Edukia ({$lisensiFrasa}). "
            ."Skema {$skema['bidang_label']} dengan {$skema['jumlah_unit']} unit kompetensi. "
            .'Lihat persyaratan, unit kompetensi, dan cara mendaftar uji kompetensi.';

        $seo = new SEOData(
            title: 'Sertifikasi '.$skema['nama'],
            description: Str::limit($deskripsi, 155),
            image: 'images/hero-skema.jpg',
            url: route('skema.show', $skema['slug']),
            schema: SchemaCollection::initialize()
                ->push(fn (SEOData $d): array => $this->courseSchema($skema, $deskripsi, $d))
                ->addBreadcrumbs(fn (BreadcrumbListSchema $b): BreadcrumbListSchema => $b->prependBreadcrumbs([
                    'Beranda' => url('/'),
                    'Skema Sertifikasi' => route('skema'),
                    $skema['bidang_label'] => route('skema.bidang', $skema['bidang']),
                ])),
        );

        return view('skema.show', compact('skema', 'related', 'bidangs'))
            ->with('activeNav', 'skema')
            ->with('SEOData', $seo);
    }

    /** Hub bidang: /skema-sertifikasi/bidang/{bidang} */
    public function bidang(string $bidang)
    {
        $bidangs = Skemas::bidangs();

        if (! isset($bidangs[$bidang])) {
            throw new NotFoundHttpException("Bidang '{$bidang}' tidak ditemukan.");
        }

        $info = $bidangs[$bidang];
        $skemas = Skemas::byBidang($bidang);

        $seo = new SEOData(
            title: 'Skema '.$info['label'],
            description: Str::limit(
                "Daftar {$skemas->count()} skema sertifikasi kompetensi person bidang {$info['label']} di LSP Edukia, terakreditasi KAN: {$info['judul']}. Lihat unit kompetensi dan persyaratan tiap skema.",
                155
            ),
            image: 'images/hero-skema.jpg',
            url: route('skema.bidang', $bidang),
            schema: SchemaCollection::initialize()
                ->addBreadcrumbs(fn (BreadcrumbListSchema $b): BreadcrumbListSchema => $b->prependBreadcrumbs([
                    'Beranda' => url('/'),
                    'Skema Sertifikasi' => route('skema'),
                ])),
        );

        return view('skema.bidang', compact('bidang', 'info', 'skemas'))
            ->with('activeNav', 'skema')
            ->with('SEOData', $seo);
    }

    /** Markup JSON-LD Course untuk satu skema. */
    private function courseSchema(array $skema, string $deskripsi, SEOData $d): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $skema['nama'],
            'description' => $deskripsi,
            'url' => $d->url,
            'courseCode' => $skema['kode'],
            'provider' => [
                '@type' => 'Organization',
                'name' => 'LSP Edukia',
                '@id' => config('app.url').'/#organization',
                'url' => config('app.url'),
            ],
            'educationalCredentialAwarded' => ($skema['lisensi_kan'] ? 'Sertifikat Kompetensi Berlisensi KAN — ' : 'Sertifikat Kompetensi LSP Edukia — ').$skema['nama'],
            // Persyaratan pemohon & unit kompetensi — agar mesin pencari memahami isi skema.
            'coursePrerequisites' => array_values($skema['persyaratan']),
            'teaches' => array_values(array_map(fn (array $u): string => $u['judul'], $skema['units'])),
            'hasCourseInstance' => [
                '@type' => 'CourseInstance',
                'courseMode' => 'onsite',
                'courseWorkload' => 'P1D',
                'location' => [
                    '@type' => 'Place',
                    'name' => 'LSP Edukia',
                    'address' => 'Kota Semarang, Jawa Tengah, Indonesia',
                ],
            ],
        ];
    }
}

@php
    use Spatie\SchemaOrg\Schema;

    $organizationSchema = Schema::professionalService()
        ->setProperty('@id', config('app.url') . '/#organization')
        ->name('LSP Edukia')
        ->alternateName('LSP Edukasi Global Cendekia')
        ->url(config('app.url'))
        ->logo(asset('images/logo-edukia.png'))
        ->image(asset('images/hero-index.jpg'))
        ->telephone('+6285175479385')
        ->email('edukasi.cendekia@gmail.com')
        ->address(
            Schema::postalAddress()
                ->streetAddress('Jl. Teras Bali No.12, Mijen')
                ->addressLocality('Kota Semarang')
                ->addressRegion('Jawa Tengah')
                ->postalCode('50219')
                ->addressCountry('ID')
        )
        ->areaServed('Indonesia')
        ->description('Lembaga sertifikasi person terakreditasi KAN dengan 26 skema kompetensi (7 di antaranya berlisensi KAN) di bidang pendidikan tinggi, manajemen mutu, laboratorium, lifting engineering, dan hukum korporasi.')
        // Profil sosial resmi diisi via .env (SOCIAL_PROFILES=url1,url2,...) — memperkuat entity di Knowledge Graph.
        ->sameAs(config('site.social', []));
@endphp
{!! $organizationSchema->toScript() !!}

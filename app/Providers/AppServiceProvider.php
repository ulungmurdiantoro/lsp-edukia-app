<?php

namespace App\Providers;

use App\Models\Booklet;
use App\Support\Skemas;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use RalphJSmit\Laravel\SEO\Facades\SEOManager;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa HTTPS untuk seluruh URL yang digenerate (canonical, OG, sitemap) di production.
        if (config('site.force_https')) {
            URL::forceScheme('https');
        }

        // Paksa locale OpenGraph ke id_ID di seluruh halaman (situs berbahasa Indonesia).
        SEOManager::SEODataTransformer(function (SEOData $SEOData): SEOData {
            $SEOData->locale = 'id_ID';

            return $SEOData;
        });

        // Daftar "Bidang Skema" di footer (layouts.app, tampil di semua halaman) dihitung
        // langsung dari Skemas — sebelumnya angka ini diketik manual di blade dan sudah basi
        // (tidak sinkron dengan jumlah skema sebenarnya per bidang).
        View::composer('layouts.app', function ($view): void {
            $view->with('footerBidangSkema', collect(Skemas::bidangs())
                ->map(fn (array $info, string $key): array => [
                    'label' => $info['label'],
                    'jumlah' => Skemas::byBidang($key)->count(),
                ])->values());

            // Menu Booklet di nav bar & footer hanya muncul bila admin menampilkan booklet (null = sembunyikan).
            $view->with('navBooklet', Booklet::aktif());
        });
    }
}

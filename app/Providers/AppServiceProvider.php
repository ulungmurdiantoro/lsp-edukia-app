<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
    }
}

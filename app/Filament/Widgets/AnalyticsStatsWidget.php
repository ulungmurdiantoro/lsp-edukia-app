<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = -3;

    protected function getStats(): array
    {
        if (! $this->isConfigured()) {
            return [
                Stat::make('Google Analytics 4', 'Belum aktif')
                    ->description('Isi ANALYTICS_PROPERTY_ID + unggah kredensial service account untuk melihat trafik.')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('gray'),
            ];
        }

        try {
            $rows = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));

            $visitors = (int) $rows->sum('activeUsers');
            $views = (int) $rows->sum('screenPageViews');

            // Tren 7 hari terakhir untuk sparkline.
            $chart = $rows->sortBy('date')->take(-7)
                ->map(fn ($r) => (int) ($r['activeUsers'] ?? 0))
                ->values()
                ->all();

            return [
                Stat::make('Pengunjung (30 hari)', number_format($visitors))
                    ->description('Active users — Google Analytics 4')
                    ->descriptionIcon('heroicon-m-users')
                    ->chart(count($chart) > 1 ? $chart : [0, 0])
                    ->color('success'),

                Stat::make('Tayangan Halaman (30 hari)', number_format($views))
                    ->description('Total page views')
                    ->descriptionIcon('heroicon-m-eye')
                    ->color('info'),
            ];
        } catch (\Throwable $e) {
            return [
                Stat::make('Google Analytics 4', 'Gagal memuat data')
                    ->description(str($e->getMessage())->limit(70))
                    ->descriptionIcon('heroicon-m-x-circle')
                    ->color('danger'),
            ];
        }
    }

    /** GA4 hanya dipanggil bila property id terisi & kredensial tersedia — cegah crash dashboard. */
    protected function isConfigured(): bool
    {
        if (blank(config('analytics.property_id'))) {
            return false;
        }

        $creds = config('analytics.service_account_credentials_json');

        if (is_array($creds)) {
            return true;
        }

        return is_string($creds) && file_exists($creds);
    }
}

<?php

namespace app\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // ✅ REQUIRED
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Front;
use App\Models\Service;
use App\Models\LandingPage;
use App\Support\StaticSiteFallback;
use app\models\Visualsetting;

class viewcomposerserviceprovider extends serviceprovider
{
    /**
     * register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $app_setting = StaticSiteFallback::settings();
            $visual_setting = StaticSiteFallback::visualSettings();
            $all_service = collect();
            $all_landing_page = collect();

            try {
                $app_setting = Setting::where('app_id', 1)->first()
                    ?: Setting::first()
                    ?: $app_setting;
            } catch (\Throwable $exception) {
                report($exception);
            }

            try {
                $visual_setting = DB::table('visual_setting')->first() ?: $visual_setting;
            } catch (\Throwable $exception) {
                report($exception);
            }

            try {
                $all_service = DB::table('service_category')->get();
            } catch (\Throwable $exception) {
                report($exception);
            }

            try {
                $all_landing_page = LandingPage::whereNotNull('page_slug')
                    ->where('is_published', true)
                    ->get();
            } catch (\Throwable $exception) {
                report($exception);
            }

            $view->with(compact(
                'app_setting',
                'visual_setting',
                'all_service',
                'all_landing_page'
            ));
        });
    }
}

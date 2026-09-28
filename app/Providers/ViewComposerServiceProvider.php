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
        view::composer('*', function ($view) {
        try {
            $app_setting = setting::first() ?: StaticSiteFallback::settings();
            $visual_setting = db::table('visual_setting')->first() ?: StaticSiteFallback::visualSettings();
            $all_service = db::table('service_category')->get();
            $all_landing_page = LandingPage::whereNotNull('page_slug')->where('is_published', true)->get();
        } catch (\Throwable $exception) {
            report($exception);
            $app_setting = StaticSiteFallback::settings();
            $visual_setting = StaticSiteFallback::visualSettings();
            $all_service = collect();
            $all_landing_page = collect();
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

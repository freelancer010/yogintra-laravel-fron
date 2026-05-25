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
        $app_setting = setting::first();
        $visual_setting = db::table('visual_setting')->first();
        $all_service = db::table('service_category')->get();
        $all_landing_page = LandingPage::whereNotNull('page_slug')->get();

        $view->with(compact(
            'app_setting', 
            'visual_setting', 
            'all_service',
            'all_landing_page'
        ));
    });
    }
}

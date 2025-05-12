<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\Setting;
use App\Models\Slider;
use App\Models\Front;
use App\Models\Service;
use App\Models\LandingPage;
use App\Models\Blog;
use App\Models\Yoga;
use App\Models\Event;

class HomeController extends Controller
{
    private $api;
    private $api_main;

    public function __construct()
    {
        $this->api = 'https://crm.yogintra.com/home';
        $this->api_main = 'https://crm.yogintra.com';
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $app_setting = Setting::first();
        $all_slider = Slider::all();
        
        $all_trainer = collect(Http::get($this->api . '/get_all_trainer_limit')->json())->map(function ($trainer) {
            return (object) $trainer;
        });
    
        $section_1 = Front::getOurFeaturesHeading();
        $section_1_content = Front::getAllOurFeatures();
    
        $section_2 = Front::getOurServiceImage(); // ✅ Fetch Section 2 Data
        $section_2_content = Front::getAllOurService(); // ✅ Fetch Section 2 Content
    
        $all_landing_page = LandingPage::whereNotNull('page_slug')->get();
        $visual_setting = DB::table('visual_setting')->first();
        $all_service = DB::table('service_category')->get();
        $api = $this->api_main;
    
        $rand_service = Service::getSixCategoryForHomePage();

        return view('front.home', compact(
            'app_setting',
            'all_slider',
            'all_trainer',
            'all_landing_page',
            'visual_setting',
            'all_service',
            'api',
            'section_1',
            'section_1_content',
            'section_2',  // ✅ Pass Section 2
            'section_2_content',  // ✅ Pass Section 2 Content
            'rand_service',
        ));
    }   
    

    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('front.about', [
            'page'             => 'about'
        ]);
    }

    public function allTrainers()
    {
        return view('front.index', [
            'page' => 'all_trainers',
            'app_setting' => Setting::getAllAppSetting(),
            'title' => Setting::getAllAppSetting()->app_meta_title,
            'all_trainer' => Http::get($this->api . '/get_all_trainer')->json(),
            'api' => $this->api_main
        ]);
    }

    public function allBlog()
    {
        return view('front.blog', [
            'page' => 'all_blog',
            'get_all_blog' => Blog::getAllBlogsForHomePage(),
            'get_all_blog_category' => Blog::getAllBlogCategory()
        ]);
    }

    public function blogDetails($slug)
    {
        return view('front.index', [
            'page' => 'blog_details',
            'app_setting' => Setting::getAllAppSetting(),
            'blog' => Blog::getBlogBySlug($slug),
            'title' => Blog::getBlogBySlug($slug)->blog_title,
            'get_all_blog_category' => Blog::getAllBlogCategory()
        ]);
    }

    /* 
    * Display the blog category page.
    * @param string $slug
    * @return \Illuminate\View\View
    */
    public function gallery()
    {
        return view('front.gallery', [
            'page' => 'gallery',
            'all_gallery' => \App\Models\Gallery::getAllGallery(),
            'all_category' => \App\Models\Gallery::getAllCategory(),
        ]);
    }

    /**
     * Display the blog category page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function allService($slug)
    {
        $app_setting = \App\Models\Setting::first();
        $service = Service::getServiceCategoryBySlug($slug);

        if (!$service) {
            abort(404); // show 404 if not found
        }

        $all_service_data = Service::getAllServiceByCategoryId($service->service_cat_id);

        return view('front.all_service', [
            'page' => 'all_service',
            'app_setting' => $app_setting,
            'service' => $service,
            'all_service_data' => $all_service_data,
            'title' => $service->service_cat_name
        ]);
    }

    /**
     * Display the service details page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function serviceDetails($slug)
    {
        $service = Service::getServiceBySlug($slug);

        if (!$service) {
            abort(404); // show 404 page if service not found
        }

        return view('front.service_details', [
            'page' => 'service_details',
            'app_setting' => \App\Models\Setting::first(),
            'service' => $service,
            'title' => $service->service_name,
        ]);
    }

    /**
     * Display the yoga centeres page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function allYogaCenter()
    {
        return view('front.all_yoga_center', [
            'page' => 'all_yoga_center',
            'all_center' => Yoga::getAll(),
        ]);
    }


    /**
     * Display the yoga center details page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function yogaCenterDetails($slug)
    {
        $center = Yoga::getBySlug($slug);

        if (!$center) {
            abort(404); // handle not found
        }

        return view('front.yoga_center_details', [
            'center' => $center,
            'title' => $center->page_meta_title ?? $center->center_name
        ]);
    }

    /**
     * Display the teacherTrainingCourse page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function teacherTrainingCourse()
    {
        return view('front.all_events', [
            'all_event' => Event::getAllEventsForHomePage('TTC'),
        ]);
    }

    public function contact()
    {
        return view('front.index', [
            'page' => 'contact',
            'app_setting' => Setting::getAllAppSetting(),
            'title' => Setting::getAllAppSetting()->app_meta_title
        ]);
    }

    public function submitContactForm(Request $request)
    {
        $data = $request->only([
            'name', 'number', 'email', 'country', 'state', 'city', 'class', 'call-from', 'call-to', 'message'
        ]);
        $data['source'] = 'Website';
        $data['created_date'] = now();

        $response = Http::post($this->api . '/addLeads', $data);
        return response()->json($response->json());
    }

    public function termsAndCondition()
    {
        return view('front.index', [
            'page' => 'terms_and_condition',
            'app_setting' => Setting::getAllAppSetting(),
            'title' => 'Terms & Condition'
        ]);
    }

    public function privacyPolicy()
    {
        return view('front.index', [
            'page' => 'privacy_policy',
            'app_setting' => Setting::getAllAppSetting(),
            'title' => 'Privacy Policy'
        ]);
    }

    public function refundPolicy()
    {
        return view('front.index', [
            'page' => 'refund_policy',
            'app_setting' => Setting::getAllAppSetting(),
            'title' => 'Refund Policy'
        ]);
    }
}

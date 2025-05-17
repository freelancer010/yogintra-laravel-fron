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
use App\Models\BlogCategory;
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


    /**
     * Display the trainers page.
     *
     * @return \Illuminate\View\View
     */
    public function allTrainers()
    {
        $response = Http::get($this->api.'/get_all_trainer');

        return view('front.all_trainer', [
            'all_trainer' => $response->json(),
            'api' => $this->api_main
        ]);
    }

    /**
     * Display the trainer details page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function get_data_for_trainer(Request $request)
    {
        $data = ['data' => $request->input('data')];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api.'/getTrainerSearchData');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return response('cURL Error: ' . curl_error($ch), 500);
        }

        curl_close($ch);

        $trainers = json_decode($response, true);
        $api = $this->api_main;
        $currentYear = now()->year;

        $html = '';

        foreach ($trainers as $i => $trainer) {
            $birthYear = date('Y', strtotime($trainer['dob']));
            $age = $currentYear - $birthYear;

            $html .= view('partials.trainer_card', compact('trainer', 'age', 'api', 'i'))->render();
        }

        return $html;
    }


    public function becomeYogaTrainer()
    {
        return view('front.become_yoga_trainer');
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
        $setting = Setting::first();
        $blog = Blog::with('category')->where('blog_slug', $slug)->firstOrFail();
        $categories = BlogCategory::all();

        return view('front.blog_details', [
            'page' => 'blog_details',
            'app_setting' => $setting,
            'blog' => $blog,
            'title' => $blog->blog_title,
            'get_all_blog_category' => $categories,
        ]);
    }

    public function blogCategory($slug)
    {
        $setting = Setting::first();
        $category = BlogCategory::where('category_slug', $slug)->firstOrFail();
        $blogs = Blog::where('blog_category', $category->id)->get();
        $categories = BlogCategory::all();

        return view('front.blog_category', [
            'page' => 'blog_category',
            'app_setting' => $setting,
            'category' => $category,
            'get_all_blog' => $blogs,
            'get_all_blog_category' => $categories,
            'title' => $category->category_name,
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

    /**
     * Display the event details page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('front.contact');
    }

    /**
     * Display the event details page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function allRetreat()
    {
        $all_event = Event::where('category', 'Retreat')->where('status', 'On')->orderByDesc('id')->get();

        return view('front.all_retreat', [
            'all_event' => $all_event
        ]);
    }


    /**
     * Display the event details page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function allWorkshop()
    {
        $data = [];
        $data['all_event'] = Event::where('category', 'Workshop')->where('status', 'On')->orderByDesc('id')->get();

        return view('front.all_workshop', $data);
    }


    /**
     * Display the landing page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function landingPage($slug)
    {
        $data['all_slider'] = Front::getAllSlider();		
        $data['section_1'] = Front::getOurFeaturesHeading();
        $data['section_1_content'] = Front::getAllOurFeatures();
        $data['section_2'] = Front::getOurServiceImage();
        $data['section_2_content'] = Front::getAllOurService();
        $data['rand_service'] = Service::getSixCategoryForHomePage();

        $response = Http::get($this->api . '/get_all_trainer_limit');
        $data['all_trainer'] = collect(Http::get($this->api . '/get_all_trainer_limit')->json())->map(function ($trainer) {
            return (object) $trainer;
        });
        $data['api'] = $this->api_main;;
        $data['page_data'] = Front::getLandingPageBySlug($slug);

        return view('front.landing_page', $data);
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

    /**
     * Display the event details page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function eventDetails($slug)
    {
        $event = DB::table('event')
        ->where('link', $slug)
        // ->where('status', 'On')
        ->first();

        if (!$event) {
            abort(404);
        }

        return view('front.event_details', compact('event'));
    }
}

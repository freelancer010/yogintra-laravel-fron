<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Setting;
use App\Models\Slider;
use App\Models\Front;
use App\Models\Service;
use App\Models\LandingPage;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Yoga;
use App\Models\Event;
use App\Models\Testimonial;

class HomeController extends Controller
{
    private $api;
    private $api_main;
    
    public function embedForm($source = null)
    {
        // Ensure source is properly captured for embedded forms
        $source = $source ?: 'Embedded Form';
        return view('embed.contact-form', [
            'source' => $source,
            'form_type' => 'embed'  // Explicitly set form type
        ]);
    }

    public function __construct()
    {
        $this->api = 'https://crm.yogintra.com/api';
        $this->api_main = 'https://crm.yogintra.com';
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $app_setting = Setting::first();
        $all_slider = Slider::all();
        
        // Keep the homepage focused. The complete directory remains available
        // on /trainers, while this prevents a large CRM response from bloating
        // the initial homepage DOM.
        $all_trainer = $this->cachedTrainers()->take(6);
    
        $section_1 = Front::getOurFeaturesHeading();
        $section_1_content = Front::getAllOurFeatures();
    
        $section_2 = Front::getOurServiceImage(); // ✅ Fetch Section 2 Data
        $section_2_content = Front::getAllOurService(); // ✅ Fetch Section 2 Content
    
        $all_landing_page = LandingPage::whereNotNull('page_slug')->get();
        $visual_setting = DB::table('visual_setting')->first();
        $all_service = DB::table('service_category')->get();
        $api = $this->api_main;
    
        $rand_service = Service::getSixCategoryForHomePage()->take(4);
        
        // Fetch testimonials for review section
        $testimonials = Testimonial::orderByDesc('test_id')->limit(4)->get();

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
            'testimonials'
        ));
    }   
    

    /**
     * Display the about page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
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
    public function allTrainers(Request $request)
    {
        $response = Http::get($this->api.'/get_all_trainer');
        $trainers = collect($response->json());

        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $paginatedTrainers = new LengthAwarePaginator(
            $trainers->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $trainers->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('front.all_trainer', [
            'all_trainer' => $paginatedTrainers,
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
            'get_all_blog' => Blog::getAllBlogsForHomePage(12),
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
            'all_gallery' => \App\Models\Gallery::paginateForPublic(),
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
     * Display the locate us page with all yoga centers.
     *
     * @return \Illuminate\View\View
     */
    public function locateUs()
    {
        return view('front.locate_us', [
            'page' => 'locate_us',
            'all_center' => Yoga::getAll(),
        ]);
    }

    /**
     * Display the landing page.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function landingPage($slug)
    {
        $cacheKey = 'landing-page.data.' . sha1($slug);
        $data = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($slug) {
            $pageData = Front::getLandingPageBySlug($slug);

            if (!$pageData) {
                return null;
            }

            return [
                'all_slider' => Front::getAllSlider(),
                'section_1' => Front::getOurFeaturesHeading(),
                'section_1_content' => Front::getAllOurFeatures(),
                'section_2' => Front::getOurServiceImage(),
                'section_2_content' => Front::getAllOurService(),
                'rand_service' => Service::getSixCategoryForHomePage(),
                'all_trainer' => $this->cachedTrainers(),
                'page_data' => $pageData,
                'page_sections' => \App\Models\LandingPageSection::where('landing_page_id', $pageData->page_id)
                    ->orderBy('sort_order')
                    ->get(),
                'testimonials' => Testimonial::orderByDesc('test_id')->get(),
            ];
        });

        abort_unless($data, 404);
        $data['api'] = $this->api_main;

        // The Classic landing experience currently uses the supplied
        // editorial reference layout. It is intentionally served as a
        // standalone, fast static page until its blocks are mapped back into
        // the visual builder.
        if (!empty($data['page_data']->use_classic_layout)) {
            $referenceLayout = file_get_contents(public_path('assets/landing-reference/index.html'));
            abort_unless($referenceLayout !== false, 500);

            $appSetting = Setting::first();
            $faviconPath = $appSetting->fevicon ?? 'assets/og-logo.webp';
            $favicon = str_starts_with($faviconPath, 'data:') || preg_match('#^https?://#i', $faviconPath)
                ? $faviconPath
                : asset($faviconPath);
            $faviconType = str_starts_with($favicon, 'data:image/svg') ? 'image/svg+xml' : 'image/png';
            $pageImagePath = trim((string) ($data['page_data']->page_image ?? ''));
            $heroImage = $pageImagePath !== '' && $pageImagePath !== 'uploads/1681071409default-profile.png'
                ? (str_starts_with($pageImagePath, 'data:') || preg_match('#^https?://#i', $pageImagePath) ? $pageImagePath : asset($pageImagePath))
                : asset('assets/landing-reference/hero.webp');
            $globalHeader = view('partials.navbar', [
                'app_setting' => $appSetting,
                'all_service' => DB::table('service_category')->get(),
                'visual_setting' => DB::table('visual_setting')->first(),
            ])->render();
            $globalHeader = str_replace(
                '<header id="header" class="header',
                '<header id="header" class="landing-global-header header',
                $globalHeader
            );
            $globalHeader = preg_replace(
                '#(<ul class="menuzord-menu[^"]*"[^>]*>)#',
                '<button class="landing-menu-toggle" type="button" aria-expanded="false" aria-controls="landing-global-menu">Menu <span aria-hidden="true">☰</span></button>$1',
                $globalHeader,
                1
            );
            $globalHeader = str_replace('class="menuzord-menu ', 'id="landing-global-menu" class="menuzord-menu ', $globalHeader);

            $globalFooter = view('partials.footer')->render();
            $globalFooter = str_replace(
                '<footer id="footer" class="footer bg-black-000">',
                '<footer id="footer" class="landing-global-footer footer bg-black-000">',
                $globalFooter
            );
            $trainerSection = view('front.partials.classic-trainers', [
                'trainers' => collect($data['all_trainer'])->take(3),
                'api' => $this->api_main,
            ])->render();

            $referenceLayout = str_replace(
                ['href="styles.css"', 'src="app.js"', 'src="assets/hero.webp"', 'src="assets/guidance.webp"'],
                ['href="/assets/landing-reference/styles.css"', 'src="/assets/landing-reference/app.js"', 'src="' . e($heroImage) . '"', 'src="/assets/landing-reference/guidance.webp"'],
                $referenceLayout
            );
            // The reference file carries a placeholder teal “Y” icon. Remove
            // it so every live city page uses the favicon from global settings.
            $referenceLayout = preg_replace('#<link\s+rel="icon"[^>]*>#i', '', $referenceLayout) ?? $referenceLayout;
            $referenceLayout = str_replace(
                '</head>',
                '<link rel="icon" type="' . $faviconType . '" href="' . e($favicon) . '"><link rel="shortcut icon" type="' . $faviconType . '" href="' . e($favicon) . '"><link rel="apple-touch-icon" href="' . e($favicon) . '"><link rel="stylesheet" href="/assets/front/css/font-awesome.min.css"><link rel="stylesheet" href="/assets/landing-reference/global-header.css"><link rel="stylesheet" href="/assets/landing-reference/classic-trainers.css"><link rel="stylesheet" href="/assets/landing-reference/global-footer.css"><style>.brand-logo img{display:block;width:190px;height:auto;object-fit:contain}@media(max-width:680px){.brand-logo img{width:150px}}</style></head>',
                $referenceLayout
            );
            $referenceLayout = preg_replace('#<header>.*?</header>#s', $globalHeader, $referenceLayout, 1);
            $referenceLayout = str_replace('<section id="about" class="about section">', $trainerSection . '<section id="about" class="about section">', $referenceLayout);
            $referenceLayout = preg_replace('#<footer\\b[^>]*>.*?</footer>#s', $globalFooter, $referenceLayout, 1);
            $referenceLayout = str_replace(
                '</body>',
                '<div hidden><button class="menu-toggle"></button><nav id="navigation"></nav><span id="year"></span></div><script src="/assets/landing-reference/global-header.js" defer></script></body>',
                $referenceLayout
            );

            // A saved Classic canvas replaces only the page body. The shared
            // header, footer, stylesheets, and assets remain the live layout.
            $canvasPrefix = '<!-- classic-builder-canvas -->';
            $savedCanvas = (string) ($data['page_data']->page_content ?? '');
            if (str_starts_with($savedCanvas, $canvasPrefix)) {
                $savedCanvas = substr($savedCanvas, strlen($canvasPrefix));
                if (str_starts_with(ltrim($savedCanvas), '<main')) {
                    // The page-level image is the source of truth for the
                    // hero, including canvases saved before this behaviour.
                    $savedCanvas = preg_replace(
                        '#(<div\\s+class="hero-visual"[^>]*>\\s*<img\\b[^>]*\\bsrc=")[^"]*#i',
                        '$1' . e($heroImage),
                        $savedCanvas,
                        1
                    ) ?? $savedCanvas;
                    $referenceLayout = preg_replace('#<main\\b[^>]*>.*?</main>#s', $savedCanvas, $referenceLayout, 1) ?? $referenceLayout;
                }
            }

            return response($referenceLayout)->header('Content-Type', 'text/html; charset=UTF-8');
        }

        return view('front.landing_page', $data);
    }

    /**
     * Fetch CRM trainer data once, with a short cache and a last-known-good
     * fallback so public pages never block indefinitely on the remote API.
     */
    private function cachedTrainers()
    {
        $allTrainer = Cache::get('homepage.trainers.current');

        if ($allTrainer !== null) {
            return $allTrainer;
        }

        try {
            $response = Http::acceptJson()
                ->connectTimeout(2)
                ->timeout(5)
                ->get($this->api . '/get_all_trainer_limit');

            $trainerPayload = $response->json();
            $trainers = $response->successful() && is_array($trainerPayload)
                ? collect($trainerPayload)->map(fn ($trainer) => (object) $trainer)
                : null;

            if ($trainers === null) {
                throw new \RuntimeException('The trainer API returned an invalid response.');
            }

            Cache::put('homepage.trainers.current', $trainers, now()->addMinutes(10));
            Cache::put('homepage.trainers.last_successful', $trainers, now()->addDay());

            return $trainers;
        } catch (\Throwable $exception) {
            report($exception);
            $allTrainer = Cache::get('homepage.trainers.last_successful', collect());
            Cache::put('homepage.trainers.current', $allTrainer, now()->addMinute());

            return $allTrainer;
        }
    }

    public function submitContactForm(Request $request)
    {
        // Handle AMP form submissions with different field names
        $isAmpForm = $request->header('Content-Type') === 'application/x-www-form-urlencoded' 
                     && $request->has('phone') // AMP forms use 'phone' instead of 'number'
                     && $request->input('source') && str_contains($request->input('source'), 'AMP');

        if ($isAmpForm) {
            // AMP form validation
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|digits_between:8,15',
                'email' => 'required|email',
                'message' => 'nullable|string|max:1000',
            ]);

            $data = [
                'name' => $request->input('name'),
                'number' => $request->input('phone'), // Map phone to number
                'email' => $request->input('email'),
                'country' => $request->input('country', 'India'),
                'state' => $request->input('state', 'Maharashtra'),
                'city' => $request->input('city', 'Mumbai'),
                'class' => $request->input('service', 'General Inquiry'),
                'client-message' => $request->input('message', ''),
                'source' => $request->input('source', 'AMP Website'),
                'form_type' => 'amp',
                'lead-source' => $request->input('source', 'AMP Website'),
                'created_date' => date('Y-m-d H:i:s')
            ];
        } else {
            // Regular form validation
            $request->validate([
                'name' => 'required|string|max:255',
                'number' => 'required|digits_between:8,15',
                'email' => 'required|email',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'class' => 'required|string',
                'client-message' => 'required|string|max:1000',
            ]);

            $data = $request->only([
                'name', 'number', 'email', 'country', 'state', 'city', 'class', 'call-from', 'call-to', 'client-message', 'source', 'form_type'
            ]);

            // Set lead source based on form type and source
            $formType = $request->get('form_type');
            $source = $request->get('source');

            // Determine the lead source based on form type and provided source
            if ($formType === 'embed' && $source) {
                $data['lead-source'] = $source;
            } else if ($formType === 'landing' && $source) {
                $data['lead-source'] = 'Landing Page: ' . $source;
            } else {
                $data['lead-source'] = 'Website';
            }

            $data['created_date'] = date('Y-m-d H:i:s');
        }

        $response = Http::post($this->api . '/addLeads', $data);
        
        // Return appropriate response format for AMP
        if ($isAmpForm) {
            return response()->json([
                'success' => $response->successful(),
                'message' => $response->successful() 
                    ? 'Thank you! Your message has been sent successfully.' 
                    : 'Sorry, there was an error. Please try again.'
            ], $response->successful() ? 200 : 400);
        }
        
        return response()->json($response->json());
    }

    public function termsAndCondition()
    {
        return view('front.terms_and_condition', [
            'page' => 'terms_and_condition'
        ]);
    }

    public function privacyPolicy()
    {
        return response()->view('front.privacy_policy', [
            'page' => 'privacy_policy',
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
          ->header('Pragma', 'no-cache');
    }

    public function refundPolicy()
    {
        return view('front.refund_policy', [
            'page' => 'refund_policy',
        ]);
    }

    public function editorialPolicy()
    {
        return view('front.editorial_policy', [
            'page' => 'editorial_policy',
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
        ->where('status', 'On')
        ->first();

        if (!$event) {
            abort(404);
        }
        return view('front.event_details', compact('event'));
    }

    public function submitTrainerForm(Request $request)
    {
        $data = $request->only([
            'name', 'number', 'email', 'dob',
            'country', 'state', 'city', 'address',
            'education', 'certification', 'experience', 'Other_Certificate'
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api.'/addRecruitments',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response == '1'
            ? response()->json(['success' => true])
            : response()->json(['success' => false], 500);
    }


    public function showTrainer($id)
    {
        // Prepare the POST data like before
        $data = ['data' => '']; // You can send empty if API returns all
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api . '/getTrainerSearchData');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $trainers = json_decode($response, true);

        // Find the trainer by ID
        $trainer = collect($trainers)->firstWhere('id', $id);

        if (!$trainer) {
            return abort(404, 'Trainer not found');
        }

        $api = $this->api_main;
        $birthYear = date('Y', strtotime($trainer['dob']));
        $age = now()->year - $birthYear;

        return view('front.trainer.profile', compact('trainer', 'age', 'api'));
    }

    /**
     * Display the AMP home page.
     *
     * @return \Illuminate\View\View
     */
    public function ampHome()
    {
        $app_setting = Setting::first();
        
        return view('amp.home', [
            'app_setting' => $app_setting
        ]);
    }

    /**
     * Display AMP version of any page.
     *
     * @param string $path
     * @return \Illuminate\View\View
     */
    public function ampPage($path)
    {
        $app_setting = Setting::first();
        
        // Map regular pages to AMP views
        $ampViews = [
            'about' => 'amp.about',
            'contact' => 'amp.contact',
            'gallery' => 'amp.gallery',
            'blog' => 'amp.blog',
            'services' => 'amp.services',
            'home-visit-yoga' => 'amp.service',
            'privacy-policy' => 'amp.privacy-policy',
            'terms-and-condition' => 'amp.terms-and-condition',
        ];

        $viewName = $ampViews[$path] ?? 'amp.home';
        
        // Check if the AMP view exists, fallback to home
        if (!view()->exists($viewName)) {
            $viewName = 'amp.home';
        }
        
        return view($viewName, [
            'app_setting' => $app_setting,
            'path' => $path
        ]);
    }
}

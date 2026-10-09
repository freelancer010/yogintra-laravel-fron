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
use App\Support\StaticSiteFallback;
use App\Services\OptimizedImageUpload;

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
        $app_setting = StaticSiteFallback::settings();
        $all_slider = StaticSiteFallback::sliders();
        $section_1 = StaticSiteFallback::featureHeading();
        $section_1_content = StaticSiteFallback::features();
        $section_2 = StaticSiteFallback::serviceHeading();
        $section_2_content = StaticSiteFallback::serviceItems();
        $all_landing_page = collect();
        $visual_setting = StaticSiteFallback::visualSettings();
        $all_service = collect();
        $rand_service = collect();
        $testimonials = collect();

        // Application settings are the homepage source of truth. Resolve them
        // independently so a failure in any optional homepage table cannot
        // replace valid database settings with the emergency fallback.
        try {
            $app_setting = Setting::where('app_id', 1)->first()
                ?: Setting::first()
                ?: $app_setting;
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $all_slider = Slider::all();
            $section_1 = Front::getOurFeaturesHeading() ?: $section_1;
            $section_1_content = Front::getAllOurFeatures();
            $section_2 = Front::getOurServiceImage() ?: $section_2;
            $section_2_content = Front::getAllOurService();
            $all_landing_page = LandingPage::whereNotNull('page_slug')->get();
            $visual_setting = DB::table('visual_setting')->first() ?: $visual_setting;
            $all_service = DB::table('service_category')->get();
            $rand_service = Service::getSixCategoryForHomePage()->take(4);
            $testimonials = Testimonial::orderByDesc('test_id')->limit(4)->get();
        } catch (\Throwable $exception) {
            report($exception);
        }
        
        // Keep the homepage focused. The complete directory remains available
        // on /trainers, while this prevents a large CRM response from bloating
        // the initial homepage DOM.
        $all_trainer = $this->cachedTrainers()->take(6);
    
        $api = $this->api_main;

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

            // SEO settings belong to each page, not the shared reference template.
            $referenceLayout = preg_replace_callback(
                '#<title\b[^>]*>.*?</title>#is',
                fn () => '<title>' . e((string) ($data['page_data']->page_meta_title ?? '')) . '</title>',
                $referenceLayout, 1
            );
            $referenceLayout = preg_replace('#<meta\b[^>]*\bname=["\'](?:description|keywords)["\'][^>]*>#i', '', $referenceLayout);
            $referenceLayout = str_replace('</head>',
                '<meta name="description" content="' . e((string) ($data['page_data']->page_meta_description ?? '')) . '">' .
                '<meta name="keywords" content="' . e((string) ($data['page_data']->page_keywords ?? '')) . '"></head>',
                $referenceLayout
            );

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
            $heroVariantPaths = preg_match('#^(?:https?:)?//#i', $pageImagePath) || str_starts_with($pageImagePath, 'data:')
                ? []
                : app(OptimizedImageUpload::class)->responsiveVariants($pageImagePath);
            $heroSrcset = collect($heroVariantPaths)
                ->map(fn (string $path, int $width) => asset($path) . ' ' . $width . 'w')
                ->implode(', ');
            $heroSizes = '(max-width: 680px) calc(100vw - 66px), (max-width: 1000px) calc(50vw - 52px), 585px';
            $cityName = trim((string) ($data['page_data']->page_name ?? $data['page_data']->page_slug ?? ''));
            $cityName = ucwords(str_replace(['-', '_'], ' ', $cityName ?: 'your city'));
            $cityLabel = e($cityName);
            $landingSeoMarkup = $this->landingPageSeoMarkup(
                $data['page_data'],
                $appSetting,
                $heroImage,
                $cityName
            );
            // The standalone Classic document bypasses the shared Blade
            // layout, so add page-level SEO metadata directly to its head.
            // This changes only the response and never rewrites saved canvas
            // HTML or any landing-page database fields.
            $referenceLayout = preg_replace('#<link\b[^>]*\brel=["\']canonical["\'][^>]*>#i', '', $referenceLayout) ?? $referenceLayout;
            $referenceLayout = preg_replace('#<link\b[^>]*\brel=["\']alternate["\'][^>]*\bhreflang=["\'][^"\']+["\'][^>]*>#i', '', $referenceLayout) ?? $referenceLayout;
            $heroPreload = '<link rel="preload" as="image" href="' . e($heroImage) . '"' .
                ($heroSrcset !== '' ? ' imagesrcset="' . e($heroSrcset) . '" imagesizes="' . e($heroSizes) . '"' : '') .
                ' fetchpriority="high">';
            $referenceLayout = str_replace('</head>', $landingSeoMarkup . $heroPreload . '</head>', $referenceLayout);
            // These replacements keep the shared editorial layout cohesive
            // while making its default city-facing copy useful and unique.
            // An editor's custom words are left untouched below.
            $defaultCityCopy = [
                'YOUR SPACE. YOUR PACE. YOUR PRACTICE.' => 'YOGINTRA · ' . e(strtoupper($cityName)),
                'A little time for you.<br><em>A healthier,<br>more balanced life.</em>' => 'Yoga classes in ' . $cityLabel . '.<br><em>A healthier,<br>more balanced life.</em>',
                'Personalised and live online yoga classes across India. Experienced guidance, wherever you call home.' => 'Personalised and live online yoga classes in ' . $cityLabel . '. Experienced guidance, wherever you call home.',
                'Start where you are.' => 'Yoga in ' . $cityLabel . '.',
            ];
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

            // The hero copy is the mobile LCP element. Inline only the two
            // small stylesheets needed to paint it and the fixed header;
            // below-the-fold component CSS can download without blocking the
            // first render.
            $landingCss = file_get_contents(public_path('assets/landing-reference/styles.css')) ?: '';
            $landingHeaderCss = file_get_contents(public_path('assets/landing-reference/global-header.css')) ?: '';
            $referenceLayout = str_replace(
                '<link rel="stylesheet" href="styles.css">',
                '<style id="landing-critical-css">' . $landingCss . '</style>',
                $referenceLayout
            );
            $deferredStylesheet = static function (string $url): string {
                $escapedUrl = e($url);

                return '<link rel="preload" as="style" href="' . $escapedUrl . '" onload="this.onload=null;this.rel=\'stylesheet\'">' .
                    '<noscript><link rel="stylesheet" href="' . $escapedUrl . '"></noscript>';
            };

            $referenceLayout = str_replace(
                ['src="app.js"', 'src="assets/hero.webp"', 'src="assets/guidance.webp"'],
                ['src="/assets/landing-reference/app.js"', 'src="' . e($heroImage) . '"', 'src="/assets/landing-reference/guidance.webp"'],
                $referenceLayout
            );
            $referenceLayout = str_replace(array_keys($defaultCityCopy), array_values($defaultCityCopy), $referenceLayout);
            // The reference file carries a placeholder teal “Y” icon. Remove
            // it so every live city page uses the favicon from global settings.
            $referenceLayout = preg_replace('#<link\s+rel="icon"[^>]*>#i', '', $referenceLayout) ?? $referenceLayout;
            $referenceLayout = str_replace(
                '</head>',
                '<meta name="csrf-token" content="' . e(csrf_token()) . '"><link rel="icon" type="' . $faviconType . '" href="' . e($favicon) . '"><link rel="shortcut icon" type="' . $faviconType . '" href="' . e($favicon) . '"><link rel="apple-touch-icon" href="' . e($favicon) . '">' .
                '<style id="landing-header-critical-css">' . $landingHeaderCss . '</style>' .
                $deferredStylesheet(asset('assets/front/css/font-awesome.min.css')) .
                $deferredStylesheet(asset('assets/landing-reference/classic-trainers.css')) .
                $deferredStylesheet(asset('assets/landing-reference/global-footer.css') . '?v=' . filemtime(public_path('assets/landing-reference/global-footer.css'))) .
                '<style>.brand-logo img{display:block;width:190px;height:auto;object-fit:contain}@media(max-width:680px){.brand-logo img{width:150px}}</style></head>',
                $referenceLayout
            );
            $referenceLayout = preg_replace(
                '#<body([^>]*)>#i',
                '<body$1 data-contact-form-endpoint="' . e(route('form.submit')) . '">',
                $referenceLayout,
                1
            ) ?? $referenceLayout;
            $referenceLayout = preg_replace('#<header>.*?</header>#s', $globalHeader, $referenceLayout, 1);
            $referenceLayout = str_replace('<section id="about" class="about section">', $trainerSection . '<section id="about" class="about section">', $referenceLayout);
            $referenceLayout = preg_replace('#<footer\\b[^>]*>.*?</footer>#s', $globalFooter, $referenceLayout, 1);
            $landingFloatingTools = request()->boolean('builder_preview')
                ? ''
                : view('front.partials.landing-floating-tools', [
                    'source' => $cityName . ' Landing Page',
                ])->render() . '<script src="/assets/front/js/contact-popup-form.min.js" defer></script>';
            $referenceLayout = str_replace(
                '</body>',
                $landingFloatingTools . '<script src="/assets/landing-reference/global-header.js" defer></script></body>',
                $referenceLayout
            );

            // A saved Classic canvas replaces only the page body. The shared
            // header, footer, stylesheets, and assets remain the live layout.
            $canvasPrefix = '<!-- classic-builder-canvas -->';
            $savedCanvas = (string) ($data['page_data']->page_content ?? '');
            if (str_starts_with($savedCanvas, $canvasPrefix)) {
                $savedCanvas = substr($savedCanvas, strlen($canvasPrefix));
                if (str_starts_with(ltrim($savedCanvas), '<main')) {
                    if (!str_contains($savedCanvas, 'data-saved-classic-canvas')) {
                        $savedCanvas = preg_replace('#<main\b#', '<main data-saved-classic-canvas="true"', $savedCanvas, 1);
                    }
                    // Only localize the original default phrases; content an
                    // editor has already written for this page remains theirs.
                    $savedCanvas = str_replace(array_keys($defaultCityCopy), array_values($defaultCityCopy), $savedCanvas);
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

            // Seed older canvases once. The marker survives builder saves, so
            // edited reviews (or an intentionally removed section) stay intact.
            if (!str_contains($referenceLayout, 'data-testimonials-initialized')) {
                $reviews = collect($data['testimonials'])->filter(fn ($review) => trim((string) $review->test_description) !== '')->take(3);
                if ($reviews->isNotEmpty()) {
                    $testimonialSection = view('front.partials.classic-testimonials', ['testimonials' => $reviews])->render();
                    if (!str_contains($referenceLayout, 'id="testimonials"')) {
                        $referenceLayout = preg_replace('#(<section\b[^>]*\bid="faq"[^>]*>)#', $testimonialSection . '$1', $referenceLayout, 1, $inserted);
                        if (!$inserted) {
                            $referenceLayout = str_replace('</main>', $testimonialSection . '</main>', $referenceLayout);
                        }
                    }
                    $referenceLayout = preg_replace('#<main\b#', '<main data-testimonials-initialized="true"', $referenceLayout, 1);
                }
            }
            if (!str_contains($referenceLayout, 'data-locations-initialized')) {
                $locations = DB::table('new_landing_page')->where('is_published', true)->orderBy('page_name')->limit(8)->get(['page_name', 'page_slug']);
                $locationsSection = view('front.partials.classic-locations', compact('locations'))->render();
                if (!str_contains($referenceLayout, 'id="locations"')) {
                    $referenceLayout = preg_replace_callback('#(<section\b[^>]*\bid="faq"[^>]*>)#', fn ($match) => $locationsSection . $match[1], $referenceLayout, 1, $insertedLocations);
                    if (!$insertedLocations) $referenceLayout = str_replace('</main>', $locationsSection . '</main>', $referenceLayout);
                }
                $referenceLayout = preg_replace('#<main\b#', '<main data-locations-initialized="true"', $referenceLayout, 1);
            }
            $locationsCss = asset('assets/landing-reference/classic-locations.css') . '?v=' . filemtime(public_path('assets/landing-reference/classic-locations.css'));
            $referenceLayout = str_replace('</head>', $deferredStylesheet($locationsCss) . '</head>', $referenceLayout);

            // Restore each page's original hero copy once, then let subsequent
            // builder edits remain authoritative through the saved marker.
            if (!str_contains($referenceLayout, 'data-hero-copy-restored')) {
                $originalTitle = trim((string) ($data['page_data']->page_image_title ?? ''));
                $originalDescription = trim((string) ($data['page_data']->page_image_description ?? ''));
                if ($originalTitle !== '') {
                    $referenceLayout = preg_replace_callback(
                        '#(<div\b[^>]*class="hero-copy"[^>]*>.*?<h1\b[^>]*>).*?(</h1>)#s',
                        fn ($match) => $match[1] . e($originalTitle) . $match[2], $referenceLayout, 1
                    );
                }
                if ($originalDescription !== '') {
                    $referenceLayout = preg_replace_callback(
                        '#(<div\b[^>]*class="hero-copy"[^>]*>.*?</h1>\s*<p\b[^>]*>).*?(</p>)#s',
                        fn ($match) => $match[1] . e($originalDescription) . $match[2], $referenceLayout, 1
                    );
                }
                $referenceLayout = preg_replace('#<main\b#', '<main data-hero-copy-restored="true"', $referenceLayout, 1);
            }
            $testimonialCss = asset('assets/landing-reference/classic-testimonials.css') . '?v=' . filemtime(public_path('assets/landing-reference/classic-testimonials.css'));
            $referenceLayout = str_replace('</head>', $deferredStylesheet($testimonialCss) . '</head>', $referenceLayout);

            $referenceLayout = str_replace(
                'src="/assets/landing-reference/app.js"',
                'src="/assets/landing-reference/app.js?v=' . filemtime(public_path('assets/landing-reference/app.js')) . '"',
                $referenceLayout
            );

            $referenceLayout = preg_replace_callback(
                '#(<div\\s+class="hero-visual"[^>]*>\\s*)(<img\\b[^>]*>)#i',
                fn (array $match) => $match[1] . $this->prioritizeLandingHeroImage($match[2], $heroSrcset, $heroSizes),
                $referenceLayout,
                1
            ) ?? $referenceLayout;
            // FAQ open/closed state can be toggled while editing the iframe.
            // It is transient UI state and must not make a saved public page
            // load with an answer permanently expanded. This also repairs
            // canvases saved before the builder-side safeguard existed.
            $referenceLayout = preg_replace_callback(
                '#<details\\b[^>]*>#i',
                static fn (array $match) => preg_replace("#\\s+open(?:\\s*=\\s*([\"']).*?\\1)?#i", '', $match[0]) ?? $match[0],
                $referenceLayout
            ) ?? $referenceLayout;
            $referenceLayout = $this->ensureLandingImageTitles($referenceLayout);

            $response = response($referenceLayout)->header('Content-Type', 'text/html; charset=UTF-8');
            // A non-responsive image can be safely preloaded from the HTTP
            // header. Responsive heroes use imagesrcset in the document head;
            // preloading the fallback URL as well would download two files.
            if ($heroSrcset === '') {
                $response->header('Link', '<' . $heroImage . '>; rel=preload; as=image; fetchpriority=high');
            }

            return $response;
        }

        // Legacy landing layouts use the shared Blade shell rather than the
        // standalone Classic document. Supply the same page-specific JSON-LD
        // there as well so every /city/* response exposes structured data.
        $legacyPage = $data['page_data'];
        $legacyImagePath = trim((string) ($legacyPage->page_image ?? ''));
        $legacyHeroImage = $legacyImagePath !== ''
            ? (str_starts_with($legacyImagePath, 'data:') || preg_match('#^https?://#i', $legacyImagePath) ? $legacyImagePath : asset($legacyImagePath))
            : asset('assets/og-logo.webp');
        $legacyCityName = trim((string) ($legacyPage->page_name ?? $legacyPage->page_slug ?? ''));
        $legacyCityName = ucwords(str_replace(['-', '_'], ' ', $legacyCityName ?: 'your city'));
        $data['landing_schema_markup'] = $this->landingPageSchemaMarkup(
            $legacyPage,
            Setting::first(),
            $legacyHeroImage,
            $legacyCityName
        );

        return view('front.landing_page', $data);
    }

    /** Add a useful fallback title to every image in the assembled Classic page. */
    private function ensureLandingImageTitles(string $html): string
    {
        return preg_replace_callback('#<img\b[^>]*>#i', static function (array $match): string {
            $tag = $match[0];
            if (preg_match('#\btitle\s*=#i', $tag)) {
                return $tag;
            }

            $title = 'YogIntra image';
            if (preg_match('#\balt\s*=\s*(["\'])(.*?)\1#is', $tag, $altMatch)) {
                $alt = trim(html_entity_decode($altMatch[2], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($alt !== '') {
                    $title = $alt;
                }
            }

            $attribute = ' title="' . e($title) . '"';

            return preg_replace('#\s*/?>$#', $attribute . '$0', $tag, 1) ?? $tag;
        }, $html) ?? $html;
    }

    /** Make the above-the-fold hero immediately loadable without altering its content. */
    private function prioritizeLandingHeroImage(string $tag, string $srcset = '', string $sizes = ''): string
    {
        $attributes = [
            'loading' => 'eager',
            'fetchpriority' => 'high',
            'decoding' => 'async',
        ];

        foreach ($attributes as $name => $value) {
            if (preg_match('#\\b' . preg_quote($name, '#') . '\\s*=#i', $tag)) {
                $tag = preg_replace(
                    "#\\b" . preg_quote($name, '#') . "\\s*=\\s*([\"']).*?\\1#i",
                    $name . '="' . $value . '"',
                    $tag,
                    1
                ) ?? $tag;
                continue;
            }

            $tag = preg_replace('#\\s*/?>$#', ' ' . $name . '="' . $value . '"$0', $tag, 1) ?? $tag;
        }

        if ($srcset !== '') {
            $responsiveAttributes = [
                'srcset' => $srcset,
                'sizes' => $sizes,
            ];
            foreach ($responsiveAttributes as $name => $value) {
                $tag = preg_replace('#\\s*/?>$#', ' ' . $name . '="' . e($value) . '"$0', $tag, 1) ?? $tag;
            }
        }

        return $tag;
    }

    /** Build canonical, language-alternate and structured data tags for a city page. */
    private function landingPageSeoMarkup(object $page, ?Setting $setting, string $heroImage, string $cityName): string
    {
        $slug = trim(strtolower((string) ($page->page_slug ?? '')), '/');
        $canonicalUrl = url('/city/' . $slug);

        return '<link rel="canonical" href="' . e($canonicalUrl) . '">' .
            '<link rel="alternate" hreflang="en-IN" href="' . e($canonicalUrl) . '">' .
            '<link rel="alternate" hreflang="x-default" href="' . e($canonicalUrl) . '">' .
            '<link rel="alternate" type="text/plain" title="YogIntra LLMs.txt" href="' . e(url('/llms.txt')) . '">' .
            $this->landingPageSchemaMarkup($page, $setting, $heroImage, $cityName);
    }

    /** Build server-rendered JSON-LD shared by Classic and legacy city pages. */
    private function landingPageSchemaMarkup(object $page, ?Setting $setting, string $heroImage, string $cityName): string
    {
        $slug = trim(strtolower((string) ($page->page_slug ?? '')), '/');
        $canonicalUrl = url('/city/' . $slug);
        $siteUrl = url('/');
        $pageTitle = trim((string) ($page->page_meta_title ?? $page->page_image_title ?? $page->page_name ?? 'YogIntra'));
        $description = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($page->page_meta_description ?? $page->page_image_description ?? ''))) ?? '');
        $organizationId = rtrim($siteUrl, '/') . '/#organization';
        $webPageId = $canonicalUrl . '#webpage';
        $serviceId = $canonicalUrl . '#service';
        $breadcrumbId = $canonicalUrl . '#breadcrumb';
        $logoPath = trim((string) ($setting?->app_sticky_logo ?? 'assets/og-logo.webp'));
        $logoUrl = preg_match('#^(?:https?:)?//#i', $logoPath) || str_starts_with($logoPath, 'data:')
            ? $logoPath
            : asset($logoPath);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => $organizationId,
                    'name' => trim((string) ($setting?->app_name ?? 'YogIntra')) ?: 'YogIntra',
                    'url' => $siteUrl,
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $logoUrl,
                    ],
                    'email' => filled($setting?->app_email) ? (string) $setting->app_email : null,
                    'telephone' => filled($setting?->app_mobile) ? (string) $setting->app_mobile : null,
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $webPageId,
                    'url' => $canonicalUrl,
                    'name' => $pageTitle,
                    'description' => $description,
                    'inLanguage' => 'en-IN',
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        '@id' => rtrim($siteUrl, '/') . '/#website',
                        'url' => $siteUrl,
                        'name' => 'YogIntra',
                    ],
                    'primaryImageOfPage' => [
                        '@type' => 'ImageObject',
                        'url' => $heroImage,
                    ],
                    'breadcrumb' => ['@id' => $breadcrumbId],
                    'mainEntity' => ['@id' => $serviceId],
                ],
                [
                    '@type' => 'Service',
                    '@id' => $serviceId,
                    'name' => $pageTitle,
                    'description' => $description,
                    'url' => $canonicalUrl,
                    'image' => $heroImage,
                    'serviceType' => 'Yoga classes and personalised yoga instruction',
                    'areaServed' => [
                        '@type' => 'Place',
                        'name' => $cityName,
                    ],
                    'provider' => ['@id' => $organizationId],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $breadcrumbId,
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $siteUrl],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => $cityName, 'item' => $canonicalUrl],
                    ],
                ],
            ],
        ];

        // Remove unavailable optional properties instead of emitting nulls.
        $schema['@graph'][0] = array_filter($schema['@graph'][0], static fn ($value) => $value !== null && $value !== '');
        $json = json_encode(
            $schema,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );

        return '<script type="application/ld+json">' . $json . '</script>';
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

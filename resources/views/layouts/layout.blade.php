<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $isLandingPage = request()->is('city/*');
        $isHomePage = request()->path() === '/';
        $deferNonCriticalStyles = $isLandingPage || $isHomePage;
        $canonicalUrl = url(strtolower(request()->path()));
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Meta Tags -->
    <link rel="canonical" href="{{ $canonicalUrl }}" />
    <link rel="alternate" hreflang="en-IN" href="{{ $canonicalUrl }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}" />
    <link rel="amphtml" href="{{ url(strtolower(request()->path())) }}/amp" />
    <title>@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')</title>
    <meta name="description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')">
    <meta name="keywords" content="@yield('meta_keywords', $app_setting->app_keywords ?? 'Yogintra')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="alternate" type="text/plain" title="YogIntra LLMs.txt" href="{{ url('/llms.txt') }}">

    <meta property="og:title" content="@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')" />
    <meta property="og:description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')" />
    <meta property="og:image" content="@yield('og_image', asset('assets/og-logo.webp'))" />
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="YogIntra" />
    <meta property="og:locale" content="en_IN" />

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@YogIntra">
    <meta name="twitter:title" content="@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')">
    <meta name="twitter:description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/og-logo.webp'))">

    <!-- Page-specific meta tags -->
    @stack('page_meta_tags')

    <meta name="author" content="YogIntra" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .skip-to-content {
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 10000;
            padding: 10px 16px;
            color: #fff;
            background: #075c66;
            border-radius: 4px;
            transform: translateY(-160%);
            transition: transform .15s ease;
        }
        .skip-to-content:focus { transform: translateY(0); color: #fff; outline: 3px solid #f6a623; outline-offset: 3px; }
    </style>

    <!-- FAVICON -->
    <link href="{{ asset($app_setting->fevicon) }}" rel="shortcut icon" type="image/png">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="144x144">

    <!-- Page-specific preloads (e.g., hero images) -->
    @stack('page_preloads')
    <link rel="preload" as="image" href="{{ asset($app_setting->app_sticky_logo) }}" fetchpriority="high">
    @unless ($deferNonCriticalStyles)
        <link rel="preload" as="font" href="{{ asset('assets/front/fonts/fontawesome-webfont3e6e.woff2') }}?v=4.7.0" type="font/woff2" crossorigin>
    @endunless

    <!-- FOR PWA MANIFEST -->
    <link rel="manifest" href="{{ asset('manifest.json')}}">

    {{-- These styles are render-critical. Loading them as print media caused a visible
       unstyled first paint and a very large cumulative layout shift. --}}
    <link href="{{ asset('assets/front/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    @if ($deferNonCriticalStyles)
        <link href="{{ asset('assets/front/css/css-plugin-collections.min.css')}}" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/front/css/css-plugin-collections.min.css')}}" rel="stylesheet"></noscript>
    @else
        <link href="{{ asset('assets/front/css/css-plugin-collections.min.css')}}" rel="stylesheet" type="text/css">
    @endif
    <link href="{{ asset('assets/front/css/menuzord-megamenu.min.css')}}" rel="stylesheet" type="text/css">
    <link id="menuzord-menu-skins" href="{{ asset('assets/front/css/menuzord-skins/menuzord-bottom-trace.min.css')}}" rel="stylesheet" type="text/css">
    @if ($deferNonCriticalStyles)
        <link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet"></noscript>
        <link href="{{ asset('assets/front/css/utility-classes.min.css') }}" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/front/css/utility-classes.min.css') }}" rel="stylesheet"></noscript>
    @else
        <link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/front/css/utility-classes.min.css') }}" rel="stylesheet" type="text/css">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    @unless(request()->is('yoga-center*'))<noscript><link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap" rel="stylesheet"></noscript>@endunless

    <link href="{{ asset('assets/front/css/style-main.min.css?l=123') }}" rel="stylesheet" type="text/css">
    @if (request()->segment(1) == 'pages')
        <link href="{{ asset('assets/front/css/preloader.min.css?xv=1') }}" rel="stylesheet" type="text/css">
    @endif
    @if ($isLandingPage)
        <link href="{{ asset('assets/front/css/custom-bootstrap-margin-padding.min.css') }}" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/front/css/custom-bootstrap-margin-padding.min.css') }}" rel="stylesheet"></noscript>
    @else
        <link href="{{ asset('assets/front/css/custom-bootstrap-margin-padding.min.css') }}" rel="stylesheet" type="text/css">
    @endif
    <link href="{{ asset('assets/front/css/colors/theme-skin-color-set1.min.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Critical CSS for FCP on Mobile -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        
        /* Mobile-first critical styles */
        @media (max-width: 767px) {
            html, body { width: 100%; height: 100%; }
            #home { min-height: 40vh; padding: 30px 15px !important; }
            .container { width: 100%; padding: 0 15px; max-width: 100%; }
            .row { display: flex; flex-wrap: wrap; margin: 0; }
            .col-md-12, .col-sm-12, .col-xs-12, [class^="col-"] { width: 100%; padding: 10px; }
            h1, h3, h5 { word-wrap: break-word; overflow-wrap: break-word; }
            img { max-width: 100%; height: auto; display: block; }
            
            /* Prevent overflow on mobile */
            body, html {
                overflow-x: hidden;
            }
            
            /* Remove horizontal scrolling */
            .row {
                margin-left: -10px;
                margin-right: -10px;
            }
            
            /* Ensure all images are responsive */
            img[width]:not([width="100%"]),
            img[height] {
                max-width: 100% !important;
                height: auto !important;
                width: auto !important;
            }
        }
    </style>

    <!-- Footer -->
    <style>
        .horizontal-list {
            list-style-type: none;
            padding: 0;
            margin-left:30px ;
            display: flex;
            font-size:20px;
        }

        .horizontal-list li {
            margin-right: 10px; 
        }

        .horizontal-list li:last-child {
            margin-right: 0;
        }

        @media only screen and (min-width : 320px) {
                .city_loc{
                text-align: left !important;
                }
                
            }

            /* Extra Small Devices, Phones */ 
            @media only screen and (min-width : 480px) {

            .city_loc{
                    text-align: left !important;
            }
            }

        .owl-carousel .owl-stage,
        .owl-carousel.owl-drag .owl-item{
            -ms-touch-action: auto;
                touch-action: auto;
        }
            .layer-overlay.overlay-dark-7::before {
            background-color: rgba(17, 17, 17, 0.1)!important;
        }
        .overlay-dark-7
        {
            background-position: top!important;
            height: 300px;
            background-repeat: no-repeat;
            background-size: cover!important;
        }
    </style>

    @stack('styles') {{-- For additional CSS in child views --}}

    <!-- Optional services are loaded only after the visitor grants consent. -->
        <script src="{{ asset('assets/front/js/consent-loaders.js') }}" defer></script>

    <!-- SCHEMA -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HealthAndBeautyBusiness",
        "name": "YogIntra",
        "image": "{{ asset('assets/og-logo.webp') }}",
        "url": "{{ url('/') }}",
        "@id": "{{ url('/') }}",
        "logo": "{{ asset('assets/og-logo.webp') }}",
        "description": "Yogintra - Your Trusted Source for Yoga Training and Wellness",
        "priceRange": "₹₹",
        "telephone": "+91-9867291573",
        "email": "{{ str_replace('@', '&#64;', str_replace('.', '&#46;', 'support@yogintra.com')) }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "postalCode": "",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "19.0760",
            "longitude": "72.8777"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday"
            ],
            "opens": "06:00",
            "closes": "20:00"
        },
        "sameAs": [
            "https://www.facebook.com/yogintra",
            "https://www.instagram.com/yogintra",
            "https://www.twitter.com/yogintra"
        ],
        "offers": {
            "@type": "AggregateOffer",
            "priceCurrency": "INR",
            "name": "Yoga Training Services",
            "description": "Professional yoga training services including personal training, group classes, and workshops"
        },
        "potentialAction": {
            "@type": "ReserveAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "{{ url('/contact') }}",
                "inLanguage": "en-US",
                "actionPlatform": [
                    "http://schema.org/DesktopWebPlatform",
                    "http://schema.org/IOSPlatform",
                    "http://schema.org/AndroidPlatform"
                ]
            },
            "result": {
                "@type": "Reservation",
                "name": "Yoga Session Booking"
            }
        }
    }
    </script>

</head>
<body data-contact-form-endpoint="{{ route('form.submit') }}">
    <a class="skip-to-content" href="#main-content">Skip to main content</a>
    @include('partials.navbar')
    <main id="main-content" class="main-content" tabindex="-1">
        @yield('content')
    </main>
    @include('partials.footer')

    <script src="{{ asset('assets/front/js/conversion-tracking.js') }}" defer></script>

    {{-- Keep dependent scripts together at the end of the document so they do not block first paint. --}}
    <script src="{{ asset('assets/front/js/jquery-2.2.4.min.js') }}"></script>
    @if (request()->is('service-details/*', 'service_details/*'))
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    @endif
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery-plugin-collection.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.min.js') }}"></script>
    @stack('scripts')

    <style>
        .cookie-banner {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            max-width: 480px;
            margin: auto;
            background: #1a73e8;
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            z-index: 1000000;
            display: none;
            font-size: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .cookie-banner a {
            color: #fff;
            text-decoration: underline;
        }

        .cookie-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 16px; }
        .cookie-banner button {
            background-color: #fff !important;
            border: 1px solid #fff;
            color: #1a73e8;
            padding: 9px 14px;
            margin: 0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .cookie-banner #cookieAcceptAll {
            background-color: #fff !important;
            border-color: #fff;
            color: #1a73e8;
        }

        .cookie-banner button.cookie-secondary { background: #fff !important; border-color: #fff; color: #1a73e8; }
        .cookie-banner button:hover,
        .cookie-banner button:focus {
            background-color: #eaf2ff !important;
            border-color: #eaf2ff;
            color: #1557b0;
            outline: 3px solid rgba(255,255,255,.72);
            outline-offset: 2px;
        }
        .cookie-banner #cookieAcceptAll:hover,
        .cookie-banner #cookieAcceptAll:focus { background-color: #eaf2ff !important; color: #1557b0; }
        .cookie-preferences { display: none; margin-top: 14px; border-top: 1px solid rgba(255,255,255,.25); padding-top: 12px; }
        .cookie-preferences.is-open { display: block; }
        .cookie-option { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin: 10px 0; }
        .cookie-option small { display: block; color: rgba(255,255,255,.8); }
        .cookie-option input { width: 18px; height: 18px; accent-color: #148795; }
    </style>

    <div class="cookie-banner" id="cookieBanner" role="dialog" aria-modal="true" aria-labelledby="cookieBannerTitle">
        <div class="cookie-text">
            <strong id="cookieBannerTitle">Your privacy choices</strong><br>
            We use essential cookies to run this site. With your permission, we also use analytics, marketing, and WhatsApp support tools. <a href="{{ url('/privacy-policy') }}" target="_blank" rel="noopener noreferrer">Read our privacy policy</a>.
        </div>
        <div class="cookie-actions">
            <button type="button" id="cookieAcceptAll">Accept all</button>
            <button type="button" class="cookie-secondary" id="cookieReject">Reject non-essential</button>
            <button type="button" class="cookie-secondary" id="cookieManage">Manage preferences</button>
        </div>
        <div class="cookie-preferences" id="cookiePreferences">
            <label class="cookie-option"><span><strong>Essential</strong><small>Required for security and core site functions.</small></span><input type="checkbox" checked disabled aria-label="Essential cookies are always enabled"></label>
            <label class="cookie-option"><span><strong>Analytics</strong><small>Helps us understand site usage.</small></span><input type="checkbox" id="cookieAnalytics" aria-label="Allow analytics cookies"></label>
            <label class="cookie-option"><span><strong>Marketing</strong><small>Allows Meta advertising measurement.</small></span><input type="checkbox" id="cookieMarketing" aria-label="Allow marketing cookies"></label>
            <label class="cookie-option"><span><strong>Functional</strong><small>Enables the WhatsApp chat widget.</small></span><input type="checkbox" id="cookieFunctional" aria-label="Allow functional cookies"></label>
            <div class="cookie-actions"><button type="button" id="cookieSave">Save preferences</button></div>
        </div>
    </div>

        <script src="{{ asset('assets/front/js/cookie-preferences.js') }}" defer></script>

    <!-- Message Box Trigger Button -->
    <style>
        #messageIcon {
            position: fixed;
            bottom: 90px;
            right: 20px;
            background-color: #1a73e8;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            animation: pulseAnimation 2s infinite;
            transition: background-color 0.3s ease;
        }

        #messageIcon:hover {
            background-color: #1557b0;
        }

        @media (max-width: 767px) {
            /* Keep support controls available without covering page CTAs or cards. */
            #messageIcon {
                right: 16px;
                bottom: 84px;
                width: 48px;
                height: 48px;
            }
            .tooltip-popup { display:none !important; }
            #wa-widget-send-button,
            .wa__btn_popup,
            .wa-widget-send-button {
                right: 16px !important;
                bottom: 18px !important;
            }
        }

        .tooltip-popup {
            position: fixed;
            bottom: 150px;
            right: 20px;
            background: #333;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            width: 200px;
            text-align: center;
        }

        .tooltip-popup::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 25px;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid #333;
        }

        .tooltip-popup.show {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        @keyframes pulseAnimation {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        #messageIcon i {
            font-size: 20px;
        }

        #messagePopup {
            position: fixed;
            bottom: 100px;
            right: 20px;
            background: white;
            width: 400px;
            max-width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            border-radius: 12px;
            padding: 25px;
            display: none;
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        }

        #messagePopup .form-step {
            margin-bottom: 20px;
        }

        #messagePopup .form-control {
            height: 44px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 8px 15px;
            font-size: 14px;
            margin-bottom: 15px;
            transition: border-color 0.3s;
            background-color: #fff;
        }

        #messagePopup .form-control:focus {
            border-color: #ffd700;
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }

        #messagePopup textarea.form-control {
            height: auto;
            min-height: 100px;
        }

        #messagePopup label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        #messagePopup .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: -12px;
            margin-bottom: 12px;
        }

        #messagePopup .btn {
            height: 44px;
            font-size: 15px;
            padding: 0 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }

        #messagePopup .btn-primary {
            background: #1a73e8;
            border-color: #1a73e8;
            color: #fff;
        }

        #messagePopup .btn-primary:hover {
            background: #1557b0;
            border-color: #1557b0;
        }

        /* Global Button Accessibility Improvements */
        .btn-success {
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
        }
        
        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
        }
        
        .btn-primary-dark {
            background-color: #d16100 !important;
            border-color: #d16100 !important;
            color: #ffffff !important;
        }
        
        .btn-primary-dark:hover,
        .btn-primary-dark:focus,
        .btn-primary-dark:active {
            background-color: #bf5600 !important;
            border-color: #bf5600 !important;
            color: #ffffff !important;
        }
        
        .btn-primary {
            background-color: #d16100 !important;
            border-color: #d16100 !important;
            color: #ffffff !important;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #bf5600 !important;
            border-color: #bf5600 !important;
            color: #ffffff !important;
        }

        /* Keep every visitor-facing action on the same primary-blue system. */
        body .btn,
        body .btn-dark,
        body .btn-theme-colored,
        body .btn-colored {
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
        }

        body .btn:hover,
        body .btn:focus,
        body .btn-dark:hover,
        body .btn-dark:focus,
        body .btn-theme-colored:hover,
        body .btn-theme-colored:focus,
        body .btn-colored:hover,
        body .btn-colored:focus {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #messagePopup .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            font-size: 22px;
            color: #666;
            z-index: 1;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
        }

        #messagePopup .close-btn:hover {
            background: #f5f5f5;
            color: #333;
        }

        /* The enquiry form already has its own field structure. Avoid nesting
           a second card's padding inside the popup, which made the mobile
           dialog unnecessarily tall and sparse. */
        #messagePopup {
            width: 390px;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 18px 45px rgba(15, 39, 45, .24);
        }
        #messagePopup .popup-content > h4 {
            margin: 2px 34px 18px !important;
            font-size: 25px !important;
            line-height: 1.25;
        }
        #messagePopup .embedded-form {
            margin: 0;
            padding: 0;
            background: transparent;
            border-radius: 0;
        }
        #messagePopup .form-step { margin-bottom: 0; }
        #messagePopup .form-group { margin-bottom: 16px; }
        #messagePopup .form-control {
            height: 48px;
            margin-bottom: 0;
            border-radius: 9px;
            padding: 10px 14px;
        }
        #messagePopup label { margin-bottom: 6px; }
        #messagePopup .btn { min-width: 104px; height: 46px; border-radius: 8px; }
        #messagePopup .close-btn { top: 9px; right: 9px; }
        
        @media (max-width: 480px) {
            #messagePopup {
                width: 95%;
                right: 2.5%;
                left: 2.5%;
                bottom: 80px;
                padding: 18px;
            }
            #messagePopup .popup-content > h4 { margin-bottom: 16px !important; }
        }

        /* Form step styling */
        #messagePopup .form-step {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        #messagePopup .form-step.active {
            display: block;
            opacity: 1;
        }

        #messagePopup .progress {
            height: 4px;
            margin-bottom: 20px;
            background-color: #f0f0f0;
            border-radius: 2px;
            overflow: hidden;
        }

        #messagePopup .progress-bar {
            background-color: #ffd700;
            transition: width 0.3s ease;
        }

        #messagePopup .step-indicators {
            margin-bottom: 25px;
            padding: 0;
            list-style: none;
            display: flex;
            justify-content: space-between;
        }

        #messagePopup .step {
            font-size: 14px;
            color: #666;
            position: relative;
            padding-bottom: 8px;
            cursor: default;
        }

        #messagePopup .step::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ddd;
            transition: background-color 0.3s;
        }

        #messagePopup .step.active {
            color: #333;
            font-weight: 500;
        }

        #messagePopup .step.active::after {
            background-color: #ffd700;
        }

        #messagePopup .form-group {
            margin-bottom: 20px;
        }

        #messagePopup .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        #messagePopup .invalid-feedback {
            display: none;
            margin-top: -12px;
            margin-bottom: 12px;
        }

        #messagePopup .form-control.is-invalid + .invalid-feedback {
            display: block;
        }

        #messagePopup select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 40px;
        }

        /* Uppercase display for specific popup inputs */
        #messagePopup #name,
        #messagePopup #country,
        #messagePopup #state,
        #messagePopup #city,
        #messagePopup #certification {
            text-transform: uppercase;
        }

        /* Success message styling */
        #messagePopup .success-message {
            text-align: center;
            padding: 30px 20px;
        }

        #messagePopup .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        #messagePopup .success-message h4 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        #messagePopup .success-message p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
        }

        .btn-warning {
            color: #fff;
            background-color: #de8200 !important;
            border-color: #de8200 !important;
        }
    </style>

    <div id="messageIcon">
        <i class="fa fa-comment"></i>
    </div>

    <div class="tooltip-popup">
        Enquire with us!
    </div>

    <div id="messagePopup">
        <div class="close-btn" onclick="toggleMessagePopup()">&times;</div>
        <div class="popup-content">
            <h4 class="text-center mb-20" style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 25px;">
                Get In Touch
            </h4>
            <div class="form-wrapper">
                <x-multi-step-form 
                    :form-type="'embed'" 
                    :source="request()->segment(2) ?? 'Quick Enquiry'" 
                />
            </div>
        </div>
    </div>

        <script src="{{ asset('assets/front/js/contact-popup-form.js') }}" defer></script>

</body>
</html>

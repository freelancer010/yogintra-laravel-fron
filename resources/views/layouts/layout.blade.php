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

    <!-- FAVICON -->
    <link href="{{ asset($app_setting->fevicon) }}" rel="shortcut icon" type="image/png">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="144x144">

    <!-- Page-specific preloads (e.g., hero images) -->
    @stack('page_preloads')
    <link rel="preload" as="image" href="{{ asset($app_setting->app_sticky_logo) }}" fetchpriority="high">
    @if ($isHomePage || !$deferNonCriticalStyles)
        <link rel="preload" as="font" href="{{ asset('assets/front/fonts/fontawesome-webfont3e6e.woff2') }}?v=4.7.0" type="font/woff2" crossorigin>
    @endif

    <!-- FOR PWA MANIFEST -->
    <link rel="manifest" href="{{ asset('manifest.json')}}">

    @if ($isHomePage)
        {{-- These overlays are rendered near the end of the document. Keep them
           out of normal flow before the deferred stylesheet has loaded. --}}
        <style id="home-overlay-critical">
            .cookie-banner,#messagePopup{position:fixed;display:none;z-index:1000000}
            #messageIcon,.tooltip-popup{position:fixed;z-index:9999}
            .cookie-banner{right:20px;bottom:20px;left:20px;max-width:480px;margin:auto}
            #messageIcon{right:20px;bottom:90px;width:50px;height:50px}
            .tooltip-popup{right:20px;bottom:150px}
            #messagePopup{right:20px;bottom:100px;max-width:90%;max-height:90vh}
            @media(min-width:768px){
                /* The homepage navigation overlays the hero on desktop. Reserve
                   that out-of-flow position before the deferred theme CSS arrives. */
                #header.home-mobile-hero-navigation{position:absolute;top:0;left:0;width:100%;z-index:1100;background:transparent}
                #header.home-mobile-hero-navigation .header-nav{position:absolute;top:0;left:0;right:0;width:100%;z-index:1101;background:transparent}
                #header.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .header-nav,#header.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .header-nav-wrapper,#header.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .menuzord{background:transparent!important;box-shadow:none!important}
                #header.home-mobile-hero-navigation .menuzord{position:relative;width:100%;min-height:75px;background:transparent}
                #header.home-mobile-hero-navigation .menuzord-brand{float:left;display:block;margin:10px 30px 0 0;line-height:1.3}
                #header.home-mobile-hero-navigation .menuzord-brand img.logo-default{display:block;width:205px;height:55px;object-fit:contain}
                #header.home-mobile-hero-navigation .menuzord-brand img.logo-scrolled-to-fixed{display:none}
                #header.home-mobile-hero-navigation .menuzord-menu{float:right;margin:0;padding:0;list-style:none}
                #header.home-mobile-hero-navigation .menuzord-menu>li{display:inline-block;float:left}
            }
            @media(max-width:767px){
                #messageIcon{right:16px;bottom:84px;width:48px;height:48px}.tooltip-popup{display:none!important}
                /* Keep the homepage's desktop menu from taking normal-flow space
                   before the deferred navigation stylesheet and script initialise. */
                #header.home-mobile-hero-navigation{position:absolute;top:0;left:0;width:100%;height:64px;z-index:1100;background:transparent}
                #header.home-mobile-hero-navigation .header-nav{position:fixed;top:0;left:0;right:0;width:100%;height:64px;z-index:1101;background:#fff;box-shadow:0 2px 12px rgba(10,49,59,.12)}
                #header.home-mobile-hero-navigation .header-nav-wrapper,#header.home-mobile-hero-navigation .ipad_header,#header.home-mobile-hero-navigation .menuzord{position:relative;width:100%;height:64px;min-height:64px;margin:0;padding:0;background:#fff}
                #header.home-mobile-hero-navigation .menuzord-brand{display:flex;align-items:center;height:64px;margin:0 0 0 18px;padding:0;line-height:0}
                #header.home-mobile-hero-navigation .menuzord-brand img.logo-default{display:block;width:155px;height:44px;max-width:calc(100vw - 104px);object-fit:contain;object-position:left center}
                #header.home-mobile-hero-navigation .menuzord-brand img.logo-scrolled-to-fixed,#header.home-mobile-hero-navigation .menuzord-menu{display:none}
                #header.home-mobile-hero-navigation.mobile-menu-open .header-nav-wrapper,#header.home-mobile-hero-navigation.mobile-menu-open .menuzord{height:auto}
            }
        </style>
    @endif

    {{-- Apply layout CSS before first paint; deferring this theme causes CLS. --}}
    @if ($isHomePage)
        <link href="{{ asset('assets/front/css/homepage.bundle.min.css') }}?v={{ filemtime(public_path('assets/front/css/homepage.bundle.min.css')) }}" rel="stylesheet">
        <link href="{{ asset('assets/landing-reference/global-footer.css') }}?v={{ filemtime(public_path('assets/landing-reference/global-footer.css')) }}" rel="stylesheet">
        <style id="home-navigation-state">
            @media(min-width:1001px){
                #header.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .header-nav,
                #header.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .header-nav-wrapper,
                #header.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .menuzord{background:transparent!important;box-shadow:none!important}
                #header.video-hero-navigation.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .menuzord-menu>li>a,
                #header.video-hero-navigation.home-mobile-hero-navigation:not(.mobile-hero-scrolled) .menuzord-menu>li>a>i{color:#fff!important}
                #header.home-mobile-hero-navigation.mobile-hero-scrolled .header-nav,
                #header.home-mobile-hero-navigation.mobile-hero-scrolled .header-nav-wrapper,
                #header.home-mobile-hero-navigation.mobile-hero-scrolled .menuzord{background:#fff!important}
                #header.video-hero-navigation.home-mobile-hero-navigation.mobile-hero-scrolled .menuzord-menu>li>a,
                #header.video-hero-navigation.home-mobile-hero-navigation.mobile-hero-scrolled .menuzord-menu>li>a>i{color:#222!important}
            }
        </style>
    @else
        <link href="{{ asset('assets/front/css/frontend.bundle.min.css') }}" rel="stylesheet" type="text/css">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    @unless(request()->is('yoga-center*'))<noscript><link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap" rel="stylesheet"></noscript>@endunless

    @if (request()->segment(1) == 'pages')
        <link href="{{ asset('assets/front/css/preloader.min.css?xv=1') }}" rel="stylesheet" type="text/css">
    @endif

    <!-- Critical CSS for FCP on Mobile -->


    <!-- Footer -->


    @stack('styles') {{-- For additional CSS in child views --}}

    <!-- Optional services are loaded only after the visitor grants consent. -->
        <script src="{{ asset('assets/front/js/consent-loaders.min.js') }}" defer></script>

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

    <script src="{{ asset('assets/front/js/conversion-tracking.min.js') }}" defer></script>

    {{-- On the homepage these dependent scripts retain their document order but
       defer until parsing completes, reducing main-thread work during FCP/LCP. --}}
    <script src="{{ asset('assets/front/js/jquery-2.2.4.min.js') }}" @if ($isHomePage) defer @endif></script>
    @if (request()->is('service-details/*', 'service_details/*'))
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    @endif
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}" @if ($isHomePage) defer @endif></script>
    <script src="{{ asset('assets/front/js/jquery-plugin-collection.min.js') }}?v={{ filemtime(public_path('assets/front/js/jquery-plugin-collection.min.js')) }}" @if ($isHomePage) defer @endif></script>
    <script src="{{ asset('assets/front/js/custom.min.js') }}" @if ($isHomePage) defer @endif></script>
    @stack('scripts')



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

        <script src="{{ asset('assets/front/js/cookie-preferences.min.js') }}" defer></script>

    <!-- Message Box Trigger Button -->


    <div id="messageIcon">
        <i class="fa fa-comment"></i>
    </div>

    <div class="tooltip-popup">
        Enquire with us!
    </div>

    <div id="messagePopup">
        <div class="close-btn" onclick="toggleMessagePopup()">&times;</div>
        <div class="popup-content">
            <div class="popup-title text-center mb-20" style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 25px;">
                Get In Touch
            </div>
            <div class="form-wrapper">
                <x-multi-step-form
                    :form-type="'embed'"
                    :source="request()->segment(2) ?? 'Quick Enquiry'"
                />
            </div>
        </div>
    </div>

        <script src="{{ asset('assets/front/js/contact-popup-form.min.js') }}" defer></script>

</body>
</html>

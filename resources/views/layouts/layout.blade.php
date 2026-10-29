<!DOCTYPE html>
<html lang="en" class="{{ request()->path() === '/' ? 'home-critical-loading' : '' }}">
<head>
    @php
        $isLandingPage = request()->is('city/*');
        $isHomePage = request()->path() === '/';
        $homeUsesVideoHero = $isHomePage
            && (($app_setting->hero_media_type ?? 'slider') === 'video')
            && filled($app_setting->hero_video ?? null);
        $deferNonCriticalStyles = $isLandingPage || $isHomePage;
        $canonicalUrl = url(strtolower(request()->path()));
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Meta Tags -->
    <link rel="canonical" href="{{ $canonicalUrl }}" />
    <link rel="alternate" hreflang="en-IN" href="{{ $canonicalUrl }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}" />
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
    @if (!$deferNonCriticalStyles)
        <link rel="preload" as="font" href="{{ asset('assets/front/fonts/fontawesome-webfont3e6e.woff2') }}?v=4.7.0" type="font/woff2" crossorigin>
    @endif

    @if ($isHomePage)
        {{-- These overlays are rendered near the end of the document. Keep them
           out of normal flow before the deferred stylesheet has loaded. --}}
        <style id="home-overlay-critical">
            main>section:not(#home):not(#home-intro){content-visibility:auto;contain-intrinsic-size:auto 900px}
            .skip-to-content{position:fixed;top:12px;left:12px;z-index:10000;padding:10px 16px;color:#fff;background:#075c66;border-radius:4px;transform:translateY(-160%)}
            .skip-to-content:focus{transform:translateY(0);color:#fff;outline:3px solid #f6a623;outline-offset:3px}
            .home-critical-loading .cookie-banner{display:none!important}
            .home-critical-loading .tooltip-popup{display:none!important}
            .cookie-banner,#messagePopup{position:fixed;display:none;z-index:1000000}
            #messageIcon,.tooltip-popup{position:fixed;z-index:9999}
            .cookie-banner{right:20px;bottom:20px;left:20px;max-width:480px;margin:auto}
            #messageIcon{right:20px;bottom:90px;width:50px;height:50px}
            .tooltip-popup{right:20px;bottom:150px}
            #messagePopup{right:20px;bottom:100px;max-width:90%;max-height:90vh}
            #header .home-native-menu-toggle{display:none}
            #header .home-submenu-toggle{display:none}
            #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>a:after{display:inline-block;width:7px;height:7px;margin:0 0 3px 8px;border-right:2px solid currentColor;border-bottom:2px solid currentColor;content:'';transform:rotate(45deg)}
            #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>a>.indicator{display:none!important}
            @media(min-width:1001px){
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
                #header.home-mobile-hero-navigation .menuzord-menu>li>a{display:block;padding:22px 10px;line-height:26px}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu{position:relative}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>ul.dropdown,#header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>ul.megamenu{position:absolute;top:100%;left:0;z-index:1200;display:none;min-width:220px;margin:0;padding:8px 0;border-top:3px solid #14757d;background:#fff;box-shadow:0 8px 22px rgba(10,49,59,.16);list-style:none}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu:hover>ul.dropdown,#header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu:focus-within>ul.dropdown,#header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu:hover>ul.megamenu,#header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu:focus-within>ul.megamenu{display:block!important;visibility:visible!important;opacity:1!important}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>ul>li{display:block;float:none;width:100%}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>ul>li>a{display:block;padding:10px 18px;color:#183c45!important;line-height:1.45;white-space:nowrap}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>ul>li>a:hover,#header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>ul>li>a:focus{background:#f1f7f6;color:#0b6d75!important}
            }
            @media(max-width:1000px){
                #messageIcon{right:16px;bottom:84px;width:48px;height:48px}.tooltip-popup{display:none!important}
                /* Keep the homepage's desktop menu from taking normal-flow space
                   before the deferred navigation stylesheet and script initialise. */
                #header.home-mobile-hero-navigation{position:absolute;top:0;left:0;width:100%;height:64px;z-index:1100;background:transparent}
                #header.home-mobile-hero-navigation .header-top{display:none}
                #header.home-mobile-hero-navigation .header-nav{position:fixed;top:0;left:0;right:0;width:100%;height:64px;z-index:1101;background:#fff;box-shadow:0 2px 12px rgba(10,49,59,.12)}
                #header.home-mobile-hero-navigation .header-nav-wrapper,#header.home-mobile-hero-navigation .ipad_header,#header.home-mobile-hero-navigation .menuzord{position:relative;width:100%;height:64px;min-height:64px;margin:0;padding:0;background:#fff}
                #header.home-mobile-hero-navigation .menuzord-brand{display:flex;align-items:center;width:185px;height:64px;margin:0 0 0 22px;padding:0;line-height:0}
                #header.home-mobile-hero-navigation .menuzord-brand img.logo-default{display:block;width:185px;height:48px;max-width:calc(100vw - 104px);object-fit:contain;object-position:left center}
                #header.home-mobile-hero-navigation .menuzord-brand img.logo-scrolled-to-fixed{display:none}
                #header.home-mobile-hero-navigation .menuzord-menu{display:block!important;clear:both;float:none;width:100%;max-height:0!important;margin:0;padding:0 16px;overflow:hidden;visibility:hidden;opacity:0;pointer-events:none;background:#fff!important;transform:translateY(-8px);transition:max-height .3s ease,opacity .22s ease,transform .3s ease,padding-bottom .3s ease,visibility 0s linear .3s}
                #header.home-mobile-hero-navigation .home-native-menu-toggle{display:block!important;position:absolute;top:0;right:8px;width:64px;height:64px;margin:0;padding:17px 0 0;border:0;background:transparent;text-decoration:none;cursor:pointer}
                #header.home-mobile-hero-navigation .home-native-menu-toggle em{display:block;width:28px;height:4px;margin:5px 18px 0;border-radius:4px;background:#084451}
                #header.home-mobile-hero-navigation .menuzord>.showhide{display:none!important}
                #header.home-mobile-hero-navigation.mobile-menu-open .header-nav,#header.home-mobile-hero-navigation.mobile-menu-open .header-nav-wrapper,#header.home-mobile-hero-navigation.mobile-menu-open .ipad_header,#header.home-mobile-hero-navigation.mobile-menu-open .menuzord{height:auto!important;background:#fff!important}
                #header.home-mobile-hero-navigation.mobile-menu-open .menuzord-menu{max-height:calc(100vh - 64px)!important;padding-bottom:16px;overflow-y:auto;visibility:visible;opacity:1;pointer-events:auto;box-shadow:0 8px 16px rgba(10,49,59,.12);transform:translateY(0);transition:max-height .3s ease,opacity .22s ease,transform .3s ease,padding-bottom .3s ease,visibility 0s}
                #header.home-mobile-hero-navigation.mobile-menu-open .menuzord-menu>li{display:block;float:none;width:100%}
                #header.home-mobile-hero-navigation.mobile-menu-open .menuzord-menu>li>a{display:block;padding:12px 52px 12px 8px;color:#222!important}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu{position:relative}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-has-submenu>a:after{display:none}
                #header.home-mobile-hero-navigation .menuzord-menu>li>a>.indicator{display:none!important}
                #header.home-mobile-hero-navigation .home-submenu-toggle{position:absolute;top:2px;right:0;display:flex!important;align-items:center;justify-content:center;width:44px;height:44px;padding:0;border:0;border-radius:6px;background:transparent;color:#084451;font-size:26px;font-weight:500;line-height:1;cursor:pointer;transition:background-color .2s ease,color .2s ease}
                #header.home-mobile-hero-navigation .home-submenu-toggle:hover{background:#edf6f5;color:#0b6d75}
                #header.home-mobile-hero-navigation .home-submenu-toggle:focus{outline:2px solid #14757d;outline-offset:-3px}
                #header.home-mobile-hero-navigation .menuzord-menu>li>ul.dropdown,#header.home-mobile-hero-navigation .menuzord-menu>li>ul.megamenu{position:static!important;display:block!important;float:none!important;width:100%!important;max-height:0!important;margin:0;padding:0 0 0 16px;overflow:hidden;visibility:hidden;opacity:0;pointer-events:none;background:#f5f9f9!important;box-shadow:none!important;transform:translateY(-6px);transition:max-height .3s ease,opacity .22s ease,transform .3s ease,padding .3s ease,margin .3s ease,visibility 0s linear .3s}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-submenu-open>ul.dropdown,#header.home-mobile-hero-navigation .menuzord-menu>li.home-submenu-open>ul.megamenu{max-height:480px!important;margin:0 0 6px;padding:4px 0 6px 16px;visibility:visible;opacity:1;pointer-events:auto;transform:translateY(0);transition:max-height .3s ease,opacity .22s ease,transform .3s ease,padding .3s ease,margin .3s ease,visibility 0s}
                #header.home-mobile-hero-navigation .menuzord-menu>li.home-submenu-open>ul>li>a{display:block;padding:10px 12px;color:#183c45!important}
                #header.home-mobile-hero-navigation.mobile-menu-open .home-native-menu-toggle em{opacity:0}
                #header.home-mobile-hero-navigation.mobile-menu-open .home-native-menu-toggle:before,#header.home-mobile-hero-navigation.mobile-menu-open .home-native-menu-toggle:after{content:'';position:absolute;top:30px;right:18px;width:28px;height:4px;border-radius:4px;background:#084451}
                #header.home-mobile-hero-navigation.mobile-menu-open .home-native-menu-toggle:before{transform:rotate(45deg)}
                #header.home-mobile-hero-navigation.mobile-menu-open .home-native-menu-toggle:after{transform:rotate(-45deg)}
            }
            @media(max-width:1000px) and (prefers-reduced-motion:reduce){
                #header.home-mobile-hero-navigation .menuzord-menu,#header.home-mobile-hero-navigation .menuzord-menu>li>ul.dropdown,#header.home-mobile-hero-navigation .menuzord-menu>li>ul.megamenu{transition:none!important}
            }
        </style>
    @endif

    {{-- The inline hero layout prevents unstyled content from entering the
       viewport while the large legacy theme downloads outside the critical path. --}}
    @if ($isHomePage)
        <link href="{{ asset('assets/front/css/homepage.bundle.min.css') }}?v={{ filemtime(public_path('assets/front/css/homepage.bundle.min.css')) }}" rel="stylesheet" media="print" onload="this.media='all';document.documentElement.classList.remove('home-critical-loading')" onerror="document.documentElement.classList.remove('home-critical-loading')">
        <link href="{{ asset('assets/landing-reference/global-footer.css') }}?v={{ filemtime(public_path('assets/landing-reference/global-footer.css')) }}" rel="stylesheet" media="print" onload="this.media='all'">
        <noscript>
            <style>main>section:not(#home):not(#home-intro){content-visibility:visible}</style>
            <link href="{{ asset('assets/front/css/homepage.bundle.min.css') }}?v={{ filemtime(public_path('assets/front/css/homepage.bundle.min.css')) }}" rel="stylesheet">
            <link href="{{ asset('assets/landing-reference/global-footer.css') }}?v={{ filemtime(public_path('assets/landing-reference/global-footer.css')) }}" rel="stylesheet">
        </noscript>
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

    @if ($isHomePage)
        <link rel="preload" as="font" href="{{ asset('assets/front/fonts/quicksand-600-700-latin.woff2') }}" type="font/woff2" crossorigin>
        <style id="home-font-faces">@font-face{font-family:"Dancing Script";font-style:normal;font-weight:700;font-display:optional;src:url("{{ asset('assets/front/fonts/dancing-script-700-latin.woff2') }}") format("woff2")}@font-face{font-family:"Philosopher";font-style:normal;font-weight:700;font-display:optional;src:url("{{ asset('assets/front/fonts/philosopher-700-latin.woff2') }}") format("woff2")}@font-face{font-family:"Quicksand";font-style:normal;font-weight:600;font-display:optional;src:url("{{ asset('assets/front/fonts/quicksand-600-700-latin.woff2') }}") format("woff2")}@font-face{font-family:"Quicksand";font-style:normal;font-weight:700;font-display:optional;src:url("{{ asset('assets/front/fonts/quicksand-600-700-latin.woff2') }}") format("woff2")}@font-face{font-family:"Roboto";font-style:normal;font-weight:400;font-display:optional;src:url("{{ asset('assets/front/fonts/roboto-400-latin.woff2') }}") format("woff2")}</style>
    @else
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap" onload="this.onload=null;this.rel='stylesheet'">
        @unless(request()->is('yoga-center*'))<noscript><link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap" rel="stylesheet"></noscript>@endunless
    @endif

    @if (request()->segment(1) == 'pages')
        <link href="{{ asset('assets/front/css/preloader.min.css?xv=1') }}" rel="stylesheet" type="text/css">
    @endif

    <!-- Critical CSS for FCP on Mobile -->


    <!-- Footer -->


    @stack('styles') {{-- For additional CSS in child views --}}

    <style id="site-whatsapp-float-styles">
        .site-float-whatsapp{position:fixed;right:20px;bottom:20px;z-index:9999;display:flex;width:54px;height:54px;align-items:center;justify-content:center;border-radius:50%;background:#16be45;color:#fff!important;text-decoration:none!important;box-shadow:0 5px 16px rgba(0,0,0,.28);transition:transform .2s ease,background-color .2s ease}
        .site-float-whatsapp:hover,.site-float-whatsapp:focus{background:#0da63a;color:#fff!important;transform:translateY(-2px)}
        .site-float-whatsapp i{display:block;width:1em;height:1em;font-size:27px;line-height:1;text-align:center;transform:translate(-1px,-1px)}
        .site-float-whatsapp .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        @media(max-width:767px){.site-float-whatsapp{right:16px;bottom:18px;width:50px;height:50px}}
    </style>

    <!-- Optional services are loaded only after the visitor grants consent. -->
        <script src="{{ asset('assets/front/js/consent-loaders.min.js') }}" defer></script>

    <!-- Local business data comes from the same Application Settings values shown in the footer. -->
    @php
        $businessContact = \App\Support\BusinessContact::fromSetting($app_setting);
        $businessLogoPath = trim((string) ($app_setting->app_sticky_logo ?? 'assets/og-logo.webp'));
        $businessLogoUrl = preg_match('#^(?:https?:)?//#i', $businessLogoPath)
            ? $businessLogoPath
            : asset($businessLogoPath);
        $businessSchema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'HealthAndBeautyBusiness',
            '@id' => rtrim(url('/'), '/') . '/#organization',
            'name' => trim((string) ($app_setting->app_name ?? 'YogIntra')) ?: 'YogIntra',
            'image' => $businessLogoUrl,
            'url' => url('/'),
            'logo' => $businessLogoUrl,
            'description' => trim((string) ($app_setting->app_meta_description ?? '')) ?: null,
            'priceRange' => '₹₹',
            'telephone' => $businessContact['telephone'] ?: null,
            'email' => $businessContact['email'] ?: null,
            'address' => $businessContact['postal_address'],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '06:00',
                'closes' => '20:00',
            ],
            'sameAs' => \App\Support\SocialMedia::urls($app_setting),
            'potentialAction' => [
                '@type' => 'ReserveAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/contact'),
                    'inLanguage' => 'en-IN',
                    'actionPlatform' => [
                        'https://schema.org/DesktopWebPlatform',
                        'https://schema.org/IOSPlatform',
                        'https://schema.org/AndroidPlatform',
                    ],
                ],
                'result' => ['@type' => 'Reservation', 'name' => 'Yoga Session Booking'],
            ],
        ], static fn ($value) => $value !== null && $value !== '' && $value !== []);
    @endphp
    <script type="application/ld+json">{!! json_encode($businessSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

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
    @unless($homeUsesVideoHero)
        <script src="{{ asset('assets/front/js/jquery-2.2.4.min.js') }}" @if ($isHomePage) defer @endif></script>
    @endunless
    @if (request()->is('service-details/*', 'service_details/*') || request()->routeIs('service.details'))
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    @endif
    @if ($homeUsesVideoHero)
        {{-- The video homepage does not need the 800 KB legacy plugin/theme
           runtime for its first screen. Load Owl only when a visitor approaches
           or interacts with the manual trainer/testimonial carousels. --}}
        <script
            id="homeLegacyLoader"
            src="{{ asset('assets/front/js/home-legacy-loader.min.js') }}?v={{ filemtime(public_path('assets/front/js/home-legacy-loader.min.js')) }}"
            data-jquery-src="{{ asset('assets/front/js/jquery-2.2.4.min.js') }}"
            data-plugin-src="{{ asset('assets/front/js/jquery-plugin-collection.min.js') }}?v={{ filemtime(public_path('assets/front/js/jquery-plugin-collection.min.js')) }}"
            defer
        ></script>
    @else
        <script src="{{ asset('assets/front/js/bootstrap.min.js') }}" @if ($isHomePage) defer @endif></script>
        <script src="{{ asset('assets/front/js/jquery-plugin-collection.min.js') }}?v={{ filemtime(public_path('assets/front/js/jquery-plugin-collection.min.js')) }}" @if ($isHomePage) defer @endif></script>
        <script src="{{ asset('assets/front/js/custom.min.js') }}" @if ($isHomePage) defer @endif></script>
    @endif
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

    <a class="site-float-whatsapp" href="https://api.whatsapp.com/send/?phone=919867291573&amp;text&amp;type=phone_number&amp;app_absent=0" target="_blank" rel="noopener noreferrer" aria-label="Chat with YogIntra on WhatsApp" title="Chat with YogIntra on WhatsApp">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
        <span class="sr-only">Chat with YogIntra on WhatsApp</span>
    </a>

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

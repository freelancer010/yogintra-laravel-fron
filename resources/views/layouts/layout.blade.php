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
    @unless ($deferNonCriticalStyles)
        <link rel="preload" as="font" href="{{ asset('assets/front/fonts/fontawesome-webfont3e6e.woff2') }}?v=4.7.0" type="font/woff2" crossorigin>
    @endunless

    <!-- FOR PWA MANIFEST -->
    <link rel="manifest" href="{{ asset('manifest.json')}}">

    {{-- A single ordered bundle avoids a cascade of legacy stylesheet requests. --}}
    <link href="{{ asset('assets/front/css/frontend.bundle.css') }}" rel="stylesheet" type="text/css">

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

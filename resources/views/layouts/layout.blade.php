<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Meta Tags -->
    <link rel="canonical" href="{{ url(strtolower(request()->path())) }}" />
    <link rel="amphtml" href="{{ url(strtolower(request()->path())) }}/amp" />
    <title>@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')</title>
    <meta name="description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')">
    <meta name="keywords" content="@yield('meta_keywords', $app_setting->app_keywords ?? 'Yogintra')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">

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

    <!-- FOR PWA MANIFEST -->
    <link rel="manifest" href="{{ asset('manifest.json')}}">

    {{-- These styles are render-critical. Loading them as print media caused a visible
       unstyled first paint and a very large cumulative layout shift. --}}
    <link href="{{ asset('assets/front/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/css-plugin-collections.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/menuzord-megamenu.min.css')}}" rel="stylesheet" type="text/css">
    <link id="menuzord-menu-skins" href="{{ asset('assets/front/css/menuzord-skins/menuzord-bottom-trace.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/utility-classes.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap">

    <link href="{{ asset('assets/front/css/style-main.min.css?l=123') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/preloader.min.css?xv=1') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/custom-bootstrap-margin-padding.min.css') }}" rel="stylesheet" type="text/css">
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
    <script>
        window.loadGoogleAnalytics = function () {
            if (window.googleAnalyticsLoaded) return;
            window.googleAnalyticsLoaded = true;
            window.dataLayer = window.dataLayer || [];
            window.gtag = function () { window.dataLayer.push(arguments); };
            window.gtag('js', new Date());
            window.gtag('config', 'G-8QW4B6YQ9G');

            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://www.googletagmanager.com/gtag/js?id=G-8QW4B6YQ9G';
            document.head.appendChild(script);
        };

        window.loadMetaPixel = function () {
            if (window.metaPixelLoaded) return;
            window.metaPixelLoaded = true;
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            window.fbq('init', '399354049700557');
            window.fbq('track', 'PageView');
        };

        window.loadWhatsAppWidget = function () {
            if (window.whatsAppWidgetLoaded) return;
            window.whatsAppWidgetLoaded = true;
            window.wa_btnSetting = {"btnColor":"#16BE45","ctaText":"","cornerRadius":40,"marginBottom":20,"marginLeft":20,"marginRight":20,"btnPosition":"right","whatsAppNumber":"919867291573","welcomeMessage":"Hello","zIndex":999999,"btnColorScheme":"light"};
            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js';
            script.onload = function () { window._waEmbed(window.wa_btnSetting); };
            document.body.appendChild(script);
        };
    </script>

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
<body>
    @include('partials.navbar')
    <div class="main-content">
        @yield('content')
    </div>
    @include('partials.footer')

    <script>
        window.addEventListener('load', function() {
            if (window.location.pathname === "/" && typeof window.gtag === 'function') {
                gtag('event', 'conversion', {
                    'send_to': 'AW-11419284283/kVoECMPr76YaELvmkcUq'
                });
            }
        });

        window.addEventListener('load', function() {
            if (window.location.pathname.includes('/thank_you') && typeof window.gtag === 'function') {
                gtag('event', 'conversion', {
                    'send_to': 'AW-11419284283/ZXcKCMDr76YaELvmkcUq'
                });
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('#wa-btn-wrapper') && typeof window.gtag === 'function') {
                gtag('event', 'conversion', {'send_to': 'AW-11419284283/TdtYCMbr76YaELvmkcUq'});
            }
        });
    </script>

    <script type="text/javascript">
        // Remove the general form submit handler as we're handling the multi-step form separately
    </script>

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
            background: #153f49;
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
            background-color: #1a73e8 !important;
            border: 1px solid #1a73e8;
            color: white;
            padding: 9px 14px;
            margin: 0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .cookie-banner button.cookie-secondary { background: transparent !important; border-color: rgba(255,255,255,.75); }
        .cookie-banner button:hover,
        .cookie-banner button:focus {
            background-color: #155fc0 !important;
        }
        .cookie-banner button.cookie-secondary:hover,
        .cookie-banner button.cookie-secondary:focus { background: rgba(255,255,255,.12) !important; }
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
            <label class="cookie-option"><span><strong>Essential</strong><small>Required for security and core site functions.</small></span><input type="checkbox" checked disabled></label>
            <label class="cookie-option"><span><strong>Analytics</strong><small>Helps us understand site usage.</small></span><input type="checkbox" id="cookieAnalytics"></label>
            <label class="cookie-option"><span><strong>Marketing</strong><small>Allows Meta advertising measurement.</small></span><input type="checkbox" id="cookieMarketing"></label>
            <label class="cookie-option"><span><strong>Functional</strong><small>Enables the WhatsApp chat widget.</small></span><input type="checkbox" id="cookieFunctional"></label>
            <div class="cookie-actions"><button type="button" id="cookieSave">Save preferences</button></div>
        </div>
    </div>

    <script>
        (function () {
            var consentCookie = 'yogintra_cookie_preferences';
            var maxAge = 60 * 60 * 24 * 365;
            var banner = document.getElementById('cookieBanner');
            var preferences = document.getElementById('cookiePreferences');

            function readConsent() {
                var match = document.cookie.match(new RegExp('(?:^|; )' + consentCookie + '=([^;]*)'));
                if (!match) return null;
                try { return JSON.parse(decodeURIComponent(match[1])); } catch (error) { return null; }
            }

            function applyConsent(consent) {
                if (consent.analytics) window.loadGoogleAnalytics();
                if (consent.marketing) window.loadMetaPixel();
                if (consent.functional) window.loadWhatsAppWidget();
            }

            function saveConsent(consent) {
                var secure = window.location.protocol === 'https:' ? '; Secure' : '';
                document.cookie = consentCookie + '=' + encodeURIComponent(JSON.stringify(consent)) + '; path=/; max-age=' + maxAge + '; SameSite=Lax' + secure;
                applyConsent(consent);
                banner.style.display = 'none';
            }

            var savedConsent = readConsent();
            if (savedConsent) {
                applyConsent(savedConsent);
            } else {
                banner.style.display = 'block';
            }

            document.getElementById('cookieAcceptAll').addEventListener('click', function () {
                saveConsent({ version: 1, analytics: true, marketing: true, functional: true });
            });
            document.getElementById('cookieReject').addEventListener('click', function () {
                saveConsent({ version: 1, analytics: false, marketing: false, functional: false });
            });
            document.getElementById('cookieManage').addEventListener('click', function () {
                preferences.classList.toggle('is-open');
            });
            document.getElementById('cookieSave').addEventListener('click', function () {
                saveConsent({
                    version: 1,
                    analytics: document.getElementById('cookieAnalytics').checked,
                    marketing: document.getElementById('cookieMarketing').checked,
                    functional: document.getElementById('cookieFunctional').checked
                });
            });
        }());
    </script>

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
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
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
            visibility: visible;
            transform: translateY(0);
        }

        @keyframes pulseAnimation {
            0% {
                transform: scale(1);
                box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 6px 12px rgba(0,0,0,0.4);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 4px 8px rgba(0,0,0,0.3);
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
            background: #ffd700;
            border-color: #ffd700;
            color: #000;
        }

        #messagePopup .btn-primary:hover {
            background: #e6c200;
            border-color: #e6c200;
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
        
        @media (max-width: 480px) {
            #messagePopup {
                width: 95%;
                right: 2.5%;
                left: 2.5%;
                bottom: 80px;
                padding: 20px;
            }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get form elements - only target the form inside the popup
            const form = document.querySelector('#messagePopup #multi-step-form');
            if (!form) return; // Exit if form is not in popup
            
            const steps = form.querySelectorAll('.form-step');
            const progressBar = form.querySelector('.progress-bar');
            const stepIndicators = form.querySelectorAll('.step-indicators .step');

            // Function to show step
            function showStep(stepNumber) {
                steps.forEach(step => {
                    step.classList.remove('active');
                    if(step.dataset.step === stepNumber.toString()) {
                        step.classList.add('active');
                    }
                });

                // Update progress bar
                // progressBar.style.width = ((stepNumber - 1) * 50) + '%';

                // Update step indicators
                stepIndicators.forEach(indicator => {
                    indicator.classList.remove('active');
                    if(parseInt(indicator.dataset.step) <= stepNumber) {
                        indicator.classList.add('active');
                    }
                });
            }

            // Uppercase transform for specific popup inputs
            function transformToUppercaseElement(el) {
                try {
                    const caret = el.selectionStart;
                    const val = el.value || '';
                    const newVal = val.toUpperCase();
                    el.value = newVal;
                    try { el.setSelectionRange(caret, caret); } catch (e) {}
                } catch (e) {
                    // ignore if element doesn't support selectionRange
                    el.value = (el.value || '').toUpperCase();
                }
            }

            ['#name', '#country', '#state', '#city', '#certification'].forEach(function(selector) {
                const input = form.querySelector(selector);
                if (input) {
                    input.addEventListener('input', function() { transformToUppercaseElement(this); });
                    input.addEventListener('keyup', function() { transformToUppercaseElement(this); });
                }
            });

            // Next button handler - only for popup form
            form.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentStep = this.closest('.form-step');
                    const nextStep = parseInt(currentStep.dataset.step) + 1;
                    
                    // Validate current step
                    const inputs = currentStep.querySelectorAll('input[required], select[required], textarea[required]');
                    let isValid = true;
                    
                    inputs.forEach(input => {
                        // Remove previous validation classes
                        input.classList.remove('is-invalid');
                        const feedback = input.parentNode.querySelector('.invalid-feedback');
                        if(feedback) feedback.remove();
                        
                        if(!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                            
                            // Add error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'This field is required.';
                            input.parentNode.appendChild(errorDiv);
                        } else if(input.type === 'email') {
                            // Email validation
                            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                            if(!emailRegex.test(input.value)) {
                                input.classList.add('is-invalid');
                                isValid = false;
                                
                                // Add error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback';
                                errorDiv.textContent = 'Please enter a valid email address.';
                                input.parentNode.appendChild(errorDiv);
                            }
                        } else if(input.type === 'number' && input.name === 'number') {
                            // Phone validation
                            const phoneRegex = /^\d{8,15}$/;
                            if(!phoneRegex.test(input.value)) {
                                input.classList.add('is-invalid');
                                isValid = false;
                                
                                // Add error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback';
                                errorDiv.textContent = 'Enter a valid phone number (8–15 digits).';
                                input.parentNode.appendChild(errorDiv);
                            }
                        }
                    });

                    if(isValid) {
                        showStep(nextStep);
                    }
                });
            });

            // Previous button handler - only for popup form
            form.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentStep = this.closest('.form-step');
                    const prevStep = parseInt(currentStep.dataset.step) - 1;
                    showStep(prevStep);
                });
            });

            // Note: Form submission is handled here for popup form
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate final step
                const finalStep = form.querySelector('.form-step.active');
                const inputs = finalStep.querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;
                
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                    const feedback = input.parentNode.querySelector('.invalid-feedback');
                    if(feedback) feedback.remove();
                    
                    if(!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'This field is required.';
                        input.parentNode.appendChild(errorDiv);
                    }
                });

                if(!isValid) return;

                // Get submit button
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...';

                // Prepare form data
                const formData = new FormData(form);
                formData.set('form_type', 'embed');

                // Submit via AJAX (robust error handling)
                // Clear previous form-level errors
                (function clearFormError(){
                    const prev = form.querySelector('.form-error');
                    if(prev) prev.remove();
                })();

                fetch('{{ route("form.submit") }}', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const text = await response.text().catch(() => '');
                    // If response not OK, surface status and any returned text
                    if (!response.ok) {
                        if (response.status === 419) {
                            throw new Error('Session expired or CSRF token missing. Please reload the page and try again.');
                        }
                        const snippet = text ? (text.length > 500 ? text.substring(0, 500) + '...' : text) : response.statusText;
                        throw new Error('Server error ' + response.status + ': ' + snippet);
                    }

                    // Ensure JSON
                    const contentType = response.headers.get('content-type') || '';
                    if (!contentType.includes('application/json')) {
                        const snippet = text ? (text.length > 500 ? text.substring(0, 500) + '...' : text) : contentType;
                        throw new Error('Expected JSON response but got: ' + snippet);
                    }

                    // Parse JSON
                    try {
                        return JSON.parse(text);
                    } catch (err) {
                        throw new Error('Invalid JSON response from server.');
                    }
                })
                .then(data => {
                    // Success path
                    showSuccessInPopup(data.message || 'Submitted successfully.');
                    // Reset form and close after 3 seconds
                    setTimeout(() => {
                        form.reset();
                        showStep(1);
                        toggleMessagePopup();
                    }, 3000);
                })
                .catch(error => {
                    console.error('Form submit error:', error);
                    // Show friendly error message inside the popup near the form
                    const errMsg = error && error.message ? error.message : 'Submission failed. Please try again.';
                    let errDiv = form.querySelector('.form-error');
                    if (!errDiv) {
                        errDiv = document.createElement('div');
                        errDiv.className = 'form-error alert alert-danger';
                        errDiv.style.marginBottom = '15px';
                        form.insertBefore(errDiv, form.firstChild);
                    }
                    errDiv.textContent = errMsg;
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
            
            // Add real-time email validation - only for popup form
            const emailInput = form.querySelector('input[type="email"]');
            if(emailInput) {
                emailInput.addEventListener('input', function() {
                    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                    const feedback = this.parentNode.querySelector('.invalid-feedback');
                    
                    // Remove previous validation
                    this.classList.remove('is-invalid');
                    if(feedback) feedback.remove();
                    
                    // Clean the input - remove unwanted characters
                    let value = this.value.replace(/[^a-zA-Z0-9.@_-]/g, '');
                    this.value = value;
                    
                    // Validate if not empty
                    if(value && !emailRegex.test(value)) {
                        this.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Please enter a valid email address.';
                        this.parentNode.appendChild(errorDiv);
                    }
                });
            }
            
            // Add real-time phone validation - only for popup form
            const phoneInput = form.querySelector('input[name="number"]');
            if(phoneInput) {
                phoneInput.addEventListener('input', function() {
                    const phoneRegex = /^\d{8,15}$/;
                    const feedback = this.parentNode.querySelector('.invalid-feedback');
                    
                    // Remove previous validation
                    this.classList.remove('is-invalid');
                    if(feedback) feedback.remove();
                    
                    // Validate if not empty
                    if(this.value && !phoneRegex.test(this.value)) {
                        this.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Enter a valid phone number (8–15 digits).';
                        this.parentNode.appendChild(errorDiv);
                    }
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Show tooltip after a short delay
            setTimeout(function() {
                document.querySelector('.tooltip-popup').classList.add('show');
                document.getElementById('messageIcon').style.animation = 'pulseAnimation 2s infinite';
            }, 2000);

            // Hide tooltip when clicking anywhere
            document.addEventListener('click', function() {
                document.querySelector('.tooltip-popup').classList.remove('show');
            });
        });

        // Add click handler for message icon and any elements with open-message-popup class
        document.getElementById('messageIcon').addEventListener('click', toggleMessagePopup);
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('open-message-popup') || e.target.closest('.open-message-popup')) {
                toggleMessagePopup();
                e.preventDefault();
            }
        });

        function toggleMessagePopup() {
            const popup = document.getElementById('messagePopup');
            const icon = document.getElementById('messageIcon');
            
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
            } else {
                popup.style.display = 'block';
                // Stop the pulse animation when popup is opened
                icon.style.animation = 'none';
            }
        }

        // Function to show success message in popup
        function showSuccessInPopup(message) {
            const popupContent = document.querySelector('#messagePopup .popup-content');
            popupContent.innerHTML = `
                <div class="success-message">
                    <div class="success-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <h4>Thank You!</h4>
                    <p>${message || 'Your enquiry has been submitted successfully. We\'ll get back to you soon.'}</p>
                </div>
            `;
        }
    </script>

</body>
</html>

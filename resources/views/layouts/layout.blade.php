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

    <meta property="og:title" content="@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')" />
    <meta property="og:description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')" />
    <meta property="og:image" content="@yield('og_image', asset('assets/og-logo.webp'))" />
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <meta name="author" content="YogIntra" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICON -->
    <link href="{{ asset($app_setting->fevicon) }}" rel="shortcut icon" type="image/png">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="144x144">

    <!-- FOR PWA MANIFEST -->
    <link rel="manifest" href="{{ asset('manifest.json')}}">

    <link href="{{ asset('assets/front/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/css-plugin-collections.min.css')}}" rel="stylesheet" media="all">    
    <link href="{{ asset('assets/front/css/menuzord-megamenu.min.css')}}" rel="stylesheet">
    <link id="menuzord-menu-skins" href="{{ asset('assets/front/css/menuzord-skins/menuzord-bottom-trace.min.css')}}" rel="stylesheet">

    <!-- FONTS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/front/css/elegant-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/icomoon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/ionicons.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/stroke-gap-icons.css') }}" media="all"> --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/utility-classes.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap">

    <!-- MAIN CSS -->
    <link href="{{ asset('assets/front/css/style-main.min.css?l=123') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('assets/front/css/preloader.min.css?xv=1') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/front/css/custom-bootstrap-margin-padding.min.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('assets/front/css/colors/theme-skin-color-set1.min.css') }}" rel="stylesheet" type="text/css">
    
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

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8QW4B6YQ9G"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8QW4B6YQ9G');
    </script>

    <!-- Meta Pixel Code -->
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '399354049700557');
                fbq('track', 'PageView');
            }, 3000);
        });
    </script>

    <noscript>
      <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=399354049700557&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->

    <script src="{{ asset('assets/front/js/jquery-2.2.4.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery-plugin-collection.min.js') }}"></script>

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
            if (window.location.pathname === "/") {
                gtag('event', 'conversion', {
                    'send_to': 'AW-11419284283/kVoECMPr76YaELvmkcUq'
                });
            }
        });

        window.addEventListener('load', function() {
            if (window.location.pathname.includes('/thank_you')) {
                gtag('event', 'conversion', {
                    'send_to': 'AW-11419284283/ZXcKCMDr76YaELvmkcUq'
                });
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('#wa-btn-wrapper')) {
                gtag('event', 'conversion', {'send_to': 'AW-11419284283/TdtYCMbr76YaELvmkcUq'});
            }
        });
    </script>

    <script type="text/javascript">
        // Remove the general form submit handler as we're handling the multi-step form separately
    </script>

    <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
    <script>
        var wa_btnSetting = {"btnColor":"#16BE45","ctaText":"","cornerRadius":40,"marginBottom":20,"marginLeft":20,"marginRight":20,"btnPosition":"right","whatsAppNumber":"919867291573","welcomeMessage":"Hello","zIndex":999999,"btnColorScheme":"light"};
        window.onload = () => {
            _waEmbed(wa_btnSetting);
        };
    </script>
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
            background: #2f2f2f;
            color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 9999;
            display: none;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            flex-wrap: wrap;
        }

        .cookie-banner a {
            color: #ffd700;
            text-decoration: underline;
        }

        .cookie-banner button {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 8px 16px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        @media (min-width: 576px) {
            .cookie-banner {
                flex-wrap: nowrap;
            }

            .cookie-banner button {
                margin-top: 0;
                margin-left: 20px;
            }
        }
    </style>

    <div class="cookie-banner" id="cookieBanner">
        <div class="cookie-text">
            This website uses cookies to ensure you get the best experience. 
            <a href="{{ url('/privacy-policy') }}" target="_blank"> Read our privacy policy</a>
        </div>
        <button onclick="acceptCookies()">Accept</button>
    </div>

    <script>
        function acceptCookies() {
            document.cookie = "cookie_consent=1; path=/; max-age=" + (60 * 60 * 24 * 365);
            document.getElementById('cookieBanner').style.display = 'none';
        }

        function checkCookieConsent() {
            const cookies = document.cookie.split(';').map(cookie => cookie.trim());
            const consent = cookies.find(cookie => cookie.startsWith('cookie_consent='));
            if (!consent) {
                document.getElementById('cookieBanner').style.display = 'flex';
            }
        }

        document.addEventListener('DOMContentLoaded', checkCookieConsent);
    </script>

    <!-- Message Box Trigger Button -->
    <style>
        #messageIcon {
            position: fixed;
            bottom: 90px;
            right: 20px;
            background-color: #ffd700;
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

                // Submit via AJAX
                fetch('{{ route("form.submit") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    showSuccessInPopup(data.message);
                    
                    // Reset form and close after 3 seconds
                    setTimeout(() => {
                        form.reset();
                        showStep(1);
                        toggleMessagePopup();
                    }, 3000);
                    // if(data.success) {
                    //     // Show success message in popup
                    // } else {
                    //     alert('Something went wrong. Please try again.');
                    // }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Network error. Please check your connection and try again.');
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

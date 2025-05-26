<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Meta Tags -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <meta name="description" content="{{ $app_setting->app_meta_description ?? '' }}" />
    <meta name="keywords" content="{{ $app_setting->app_keywords ?? '' }}" />
    
    <title>@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')</title>
    <meta name="description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')">
    <meta name="keywords" content="@yield('meta_keywords', $app_setting->app_keywords ?? 'Yogintra')">

    <meta property="og:title" content="@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')" />
    <meta property="og:description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')" />
    
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
    <link rel="stylesheet" href="{{ asset('assets/front/css/elegant-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/icomoon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/ionicons.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/stroke-gap-icons.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/utility-classes.min.css') }}">
    <link rel="preconnect" rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Philosopher:wght@700&family=Quicksand:wght@600;700&family=Roboto&display=swap">

    <!-- MAIN CSS -->
    <link href="{{ asset('assets/front/css/style-main.min.css?fff=nvjkdsk') }}" rel="stylesheet" type="text/css" media="all">
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
    </script>

    <noscript>
      <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=399354049700557&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->
    
    <!-- Custom Scripts -->
    <script src="{{ asset('assets/front/js/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery-plugin-collection.min.js') }}"></script>
    
    <script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Yogintra",
    "url": "https://yogintra.com/",
    "logo": "https://yogintra.com/uploads/6501ab36d6f70Rectrangular-logo-2.png",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-9867291573",
        "contactType": "Customer Service"
    }
    }

    {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "Yogintra",
    "image": "https://yogintra.com/assets/og-logo.jpg",
    "@id": "https://yogintra.com/",
    "url": "https://yogintra.com/",
    "telephone": "+91-9867291573",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "D-408 Shivlila Apt Mumbra devi colony road",
        "addressLocality": "Mumbai Thane",
        "addressRegion": "West Bengal",
        "postalCode": "400612",
        "addressCountry": "India"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": 19.186440995177897,
        "longitude": 73.04725068022144
    },
    "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday"
        ],
        "opens": "09:00",
        "closes": "20:00"
    }
    }
    </script>

</head>

<body>

    @include('partials.navbar') {{-- Include Navbar --}}

    <!-- Main Content -->
    <div class="main-content">
        @yield('content') {{-- Content from child views --}}
    </div>

    @include('partials.footer') {{-- Include Footer --}}

    <!-- Scripts -->     
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
        })
    </script>

    <!-- end wrapper -->
    <script type="text/javascript">
        $('form').submit(function() {
            $('button[type="submit"]').html('Processing....');
            $('button[type="submit"]').attr('disabled',true);
            $(".loader").show();
        });
    </script>

    <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
    <script>
        var wa_btnSetting = {"btnColor":"#16BE45","ctaText":"","cornerRadius":40,"marginBottom":20,"marginLeft":20,"marginRight":20,"btnPosition":"left","whatsAppNumber":"919867291573","welcomeMessage":"Hello","zIndex":999999,"btnColorScheme":"light"};
        window.onload = () => {
            _waEmbed(wa_btnSetting);
        };
    </script>
    <script src="{{ asset('assets/front/js/custom.min.js') }}"></script>
    @stack('scripts') {{-- For additional JS in child views --}}
</body>
</html>

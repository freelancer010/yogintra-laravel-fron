<div id="wrapper">
    <!-- Preloader -->
    @if (request()->segment(1) == 'pages')
        <div id="preloader">
            <div id="spinner">
                <div class="preloader-dot-loading">
                    <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
                </div>
            </div>
            <div id="disable-preloader" class="btn btn-default btn-sm">Disable Preloader</div>
        </div>
    @endif

    <!-- Header -->
    @php
        $videoHeroNavigation = request()->segment(1) === null
            && ($app_setting->hero_media_type ?? 'slider') === 'video'
            && filled($app_setting->hero_video);
        $homeMobileHeroNavigation = request()->segment(1) === null;
        $landingHeroNavigation = request()->is('city/*');
        $heroOverlayNavigation = $homeMobileHeroNavigation || $landingHeroNavigation;
    @endphp
    <header id="header" class="header header-floating {{ $videoHeroNavigation ? 'video-hero-navigation' : '' }} {{ $homeMobileHeroNavigation ? 'home-mobile-hero-navigation' : '' }} {{ $landingHeroNavigation ? 'landing-hero-navigation' : '' }}">
        <div class="header-top sm-text-center style-bordered">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
        <div class="header-nav navbar-scrolltofixed navbar-sticky-animated" style="z-index: 999; position: relative; top: 0px;">
            <div class="header-nav-wrapper">
                <div class="container ipad_header">
                    <nav id="menuzord-right" class="menuzord orange no-bg menuzord-responsive">
                        <a class="menuzord-brand switchable-logo pull-left flip mb-10" href="{{ url('/') }}" aria-label="YogIntra home page">
                            <img class="logo-default" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo" fetchpriority="high" decoding="async">
                            <img class="logo-scrolled-to-fixed" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo">
                            <span class="sr-only">YogIntra home page</span>
                        </a>
                        <ul class="menuzord-menu menuzord-right menuzord-indented scrollable" style="max-height: 400px;">
                            <li class="{{ request()->segment(1) == '' ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                            <li class="{{ in_array(request()->segment(1), ['about', 'gallery']) ? 'active' : '' }}">
                                <a href="{{ url('/about-us') }}">About</a>
                                <ul class="dropdown">
                                    <li><a href="{{ url('/about-us') }}">About</a></li>   
                                    <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                                </ul>
                            </li>
                            
                            <li class="{{ request()->segment(1) == 'blog' ? 'active' : '' }}">
                                <a href="{{ url('/blog') }}">Blog</a>
                            </li>

                            <li class="{{ request()->segment(1) == 'service' ? 'active' : '' }}">
                                <a href="{{ url('/yoga-center') }}">Yoga Services</a>
                                <ul class="dropdown">
                                    @foreach ($all_service as $service_menu)
                                        <li>
                                            <a href="{{ url($service_menu->service_cat_slug) }}">
                                                {{ $service_menu->service_cat_name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    <li>
                                        <a href="{{ url('/yoga-center') }}">Yoga Center</a>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="{{ request()->segment(1) == 'yoga-center' ? 'active' : '' }}">
                                <a href="{{ url('/yoga-center') }}">Yoga Center</a>
                            </li> --}}
                            <li class="{{ in_array(request()->segment(1), ['teacher-training-course', 'retreat', 'workshop']) ? 'active' : '' }}">
                                <a href="{{ url('/workshop') }}">Events</a>
                                <ul class="dropdown">
                                    <li><a href="{{ url('/teacher-training-course') }}">TTC</a></li>   
                                    <li><a href="{{ url('/retreat') }}">Retreat</a></li>
                                    <li><a href="{{ url('/workshop') }}">Workshop</a></li>
                                </ul>
                            </li>
                            <li class="{{ request()->segment(1) == 'trainers' ? 'active' : '' }}">
                                <a href="{{ url('/trainers') }}">Our Instructors</a>
                            </li>
                            <li class="{{ request()->segment(1) == 'become-yoga-trainer' ? 'active' : '' }}">
                                <a href="{{ url('/become-yoga-trainer') }}">Yoga Job</a>
                            </li>
                            <li class="{{ request()->segment(1) == 'contact' ? 'active' : '' }}">
                                <a href="{{ url('/contact') }}">Contact</a>
                            </li>
                            <li class="scrollable-fix"></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Styles -->
    <style>
        @media only screen and (max-width: 600px) {
            .header-nav-centered-logo nav.menuzord .menuzord-brand img {
                width: 190px !important;
            }
            .home-mobile-hero-navigation .menuzord-responsive .menuzord-brand {
                display:flex;
                align-items:center;
                height:64px;
                margin:0 0 0 22px !important;
            }
            .home-mobile-hero-navigation .menuzord-responsive .menuzord-brand img {
                width:185px !important;
                max-width:none !important;
                height:48px !important;
                object-fit:contain;
                object-position:left center;
            }
            .menuzord-responsive .showhide {
                width:64px;
                height:64px;
                margin-top:0;
                padding-top:17px;
                position:relative;
            }
            .menuzord-responsive .showhide em { width:28px; height:4px; margin:5px 18px 0; border-radius:4px; }
            .menuzord-responsive .menuzord-brand img { width:190px !important; height:auto !important; }
            #header {
                height: 70px !important;
            }
        }
        @media only screen and (max-width: 1000px) {
            .video-hero-navigation .menuzord-menu { background:#fff !important; }
            .video-hero-navigation .menuzord-menu > li > a,
            .video-hero-navigation .menuzord-menu > li > a > i,
            .video-hero-navigation .menuzord-responsive .showhide em { color:#222 !important; }
            .video-hero-navigation .menuzord-menu > li.active > a,
            .video-hero-navigation .menuzord-menu > li:hover > a { color:#00aab7 !important; }
        }
        #header {
            height: 90px;
        }
        .menuzord-brand {
            margin: 10px 30px 0 0;
        }
        .menuzord-menu > li > a {
            padding: 22px 10px;
        }
        .video-hero-navigation .menuzord-menu > li > a,
        .video-hero-navigation .menuzord-menu > li > a > i,
        .video-hero-navigation .menuzord-responsive .showhide em {
            color: #fff !important;
        }
        .video-hero-navigation .menuzord-menu > li.active > a,
        .video-hero-navigation .menuzord-menu > li:hover > a {
            color: #2ed0da !important;
        }
        .video-hero-navigation .menuzord-menu > li.active > a::after {
            background-color: #2ed0da !important;
        }
        .video-hero-navigation .header-nav.scroll-to-fixed-fixed .header-nav-wrapper,
        .video-hero-navigation .header-nav-wrapper.scroll-to-fixed-fixed {
            background: #fff !important;
        }
        .video-hero-navigation .header-nav.scroll-to-fixed-fixed .menuzord-menu > li > a,
        .video-hero-navigation .header-nav.scroll-to-fixed-fixed .menuzord-menu > li > a > i,
        .video-hero-navigation .header-nav.scroll-to-fixed-fixed .menuzord-responsive .showhide em,
        .video-hero-navigation .header-nav-wrapper.scroll-to-fixed-fixed .menuzord-menu > li > a,
        .video-hero-navigation .header-nav-wrapper.scroll-to-fixed-fixed .menuzord-menu > li > a > i,
        .video-hero-navigation .header-nav-wrapper.scroll-to-fixed-fixed .menuzord-responsive .showhide em {
            color: #222 !important;
        }
        .video-hero-navigation .menuzord-menu ul.dropdown { background: #fff; }
        .video-hero-navigation .menuzord-menu ul.dropdown li a { color: #183c45 !important; }
        .header.landing-hero-navigation {
            position:absolute !important;
            top:0;
            left:0;
            width:100%;
            z-index:1100;
            transition:background-color .2s ease, box-shadow .2s ease;
        }
        .landing-hero-navigation:not(.landing-hero-scrolled) .header-nav,
        .landing-hero-navigation:not(.landing-hero-scrolled) .header-nav-wrapper,
        .landing-hero-navigation:not(.landing-hero-scrolled) .menuzord {
            background:transparent !important;
            box-shadow:none !important;
        }
        .landing-hero-navigation .header-nav-wrapper,
        .landing-hero-navigation .menuzord {
            background:transparent !important;
            box-shadow:none !important;
        }
        .landing-hero-navigation .menuzord-menu > li > a,
        .landing-hero-navigation .menuzord-menu > li > a > i { color:#fff !important; }
        .landing-hero-navigation .menuzord-menu > li.active > a,
        .landing-hero-navigation .menuzord-menu > li:hover > a { color:#2ed0da !important; }
        .landing-hero-navigation.landing-hero-scrolled {
            background:#fff !important;
            box-shadow:0 2px 12px rgba(10,49,59,.12) !important;
        }
        .landing-hero-navigation.landing-hero-scrolled .header-nav,
        .landing-hero-navigation.landing-hero-scrolled .header-nav-wrapper,
        .landing-hero-navigation.landing-hero-scrolled .menuzord {
            background:#fff !important;
            box-shadow:none !important;
        }
        /* The legacy scroll plugin also fixes .header-nav. Keep it inside the
           already-fixed landing header so it cannot create a duplicate bar. */
        .landing-hero-navigation.landing-hero-scrolled .header-nav {
            position:relative !important;
            top:auto !important;
            left:auto !important;
            width:100% !important;
        }
        .landing-hero-navigation.landing-hero-scrolled .menuzord-menu > li > a,
        .landing-hero-navigation.landing-hero-scrolled .menuzord-menu > li > a > i { color:#183c45 !important; }
        @media only screen and (max-width: 1000px) {
            /* All non-home pages use a stable white mobile bar from the first
               paint. This prevents the scroll-to-fixed plugin from changing
               the header width or position only after the first scroll. */
            .header.header-floating:not(.home-mobile-hero-navigation) {
                position:relative !important;
                width:100% !important;
                height:64px !important;
                min-height:64px !important;
                background:#fff !important;
            }
            .header.header-floating:not(.home-mobile-hero-navigation) .header-nav {
                position:fixed !important;
                top:0 !important;
                left:0 !important;
                right:0 !important;
                width:100% !important;
                z-index:1101 !important;
            }
            .header.header-floating:not(.home-mobile-hero-navigation) .header-nav-wrapper,
            .header.header-floating:not(.home-mobile-hero-navigation) .menuzord {
                position:relative !important;
                top:auto !important;
                left:auto !important;
                right:auto !important;
                width:100% !important;
                min-height:64px !important;
                margin:0 !important;
                padding:0 !important;
                background:#fff !important;
                box-shadow:none !important;
            }
            .header.header-floating:not(.home-mobile-hero-navigation) .header-nav-wrapper .container,
            .header.header-floating:not(.home-mobile-hero-navigation) .header-nav-wrapper .container.ipad_header {
                width:100% !important;
                max-width:none !important;
                margin:0 !important;
                padding:0 !important;
            }
            .header.header-floating:not(.home-mobile-hero-navigation) .menuzord-responsive .menuzord-brand {
                display:flex;
                align-items:center;
                height:64px;
                margin:0 0 0 22px !important;
            }
            .header.header-floating:not(.home-mobile-hero-navigation) .menuzord-responsive .menuzord-brand img {
                width:185px !important;
                max-width:none !important;
                height:48px !important;
                object-fit:contain;
                object-position:left center;
            }
            .header.header-floating:not(.home-mobile-hero-navigation) .menuzord-responsive .showhide em {
                background:#084451 !important;
            }
            .video-hero-navigation .header-nav .menuzord-menu > li > a,
            .video-hero-navigation .header-nav .menuzord-menu > li > a > i,
            .video-hero-navigation .header-nav .menuzord-menu > li.active > a,
            .video-hero-navigation .header-nav .menuzord-menu > li:hover > a,
            .video-hero-navigation .header-nav .menuzord-responsive .showhide em {
                color:#222 !important;
            }

            .header.home-mobile-hero-navigation {
                position:absolute !important;
                top:0;
                left:0;
                width:100%;
                height:70px !important;
                z-index:1100;
                background:transparent !important;
                transition:background-color .2s ease, box-shadow .2s ease;
            }
            .home-mobile-hero-navigation .header-nav-wrapper,
            .home-mobile-hero-navigation .menuzord {
                background:transparent !important;
                box-shadow:none !important;
            }
            .home-mobile-hero-navigation .header-nav {
                position:fixed !important;
                top:0 !important;
                left:0 !important;
                right:0 !important;
                width:100% !important;
                z-index:1101 !important;
            }
            .home-mobile-hero-navigation .header-nav-wrapper .container,
            .home-mobile-hero-navigation .header-nav-wrapper .container.ipad_header,
            .home-mobile-hero-navigation .header-nav-wrapper .menuzord {
                width:100% !important;
                max-width:none !important;
                margin-left:0 !important;
                margin-right:0 !important;
                padding-left:0 !important;
                padding-right:0 !important;
            }
            .home-mobile-hero-navigation .menuzord-responsive .showhide em {
                background:#084451 !important;
            }
            .home-mobile-hero-navigation.mobile-menu-open .menuzord-responsive .showhide em { opacity:0; }
            .home-mobile-hero-navigation.mobile-menu-open .menuzord-responsive .showhide::before,
            .home-mobile-hero-navigation.mobile-menu-open .menuzord-responsive .showhide::after {
                content:'';
                position:absolute;
                top:31px;
                right:18px;
                width:28px;
                height:4px;
                border-radius:4px;
                background:#084451;
            }
            .home-mobile-hero-navigation.mobile-menu-open .menuzord-responsive .showhide::before { transform:rotate(45deg); }
            .home-mobile-hero-navigation.mobile-menu-open .menuzord-responsive .showhide::after { transform:rotate(-45deg); }
            .home-mobile-hero-navigation .menuzord-menu { background:#fff !important; }
            .home-mobile-hero-navigation.mobile-hero-scrolled,
            .home-mobile-hero-navigation.mobile-hero-scrolled .header-nav,
            .home-mobile-hero-navigation.mobile-hero-scrolled .header-nav-wrapper,
            .home-mobile-hero-navigation .header-nav.scroll-to-fixed-fixed,
            .home-mobile-hero-navigation .header-nav.scroll-to-fixed-fixed .header-nav-wrapper {
                background:#fff !important;
                box-shadow:0 2px 12px rgba(10,49,59,.12) !important;
            }
            .home-mobile-hero-navigation.mobile-hero-scrolled,
            .home-mobile-hero-navigation.mobile-hero-scrolled .header-nav,
            .home-mobile-hero-navigation.mobile-hero-scrolled .header-nav-wrapper,
            .home-mobile-hero-navigation .header-nav.scroll-to-fixed-fixed,
            .home-mobile-hero-navigation .header-nav.scroll-to-fixed-fixed .header-nav-wrapper {
                top:0 !important;
                margin-top:0 !important;
                transform:none !important;
            }
            .home-mobile-hero-navigation.mobile-hero-scrolled { position:fixed !important; }
        }
    </style>

    <style>
        @if (request()->segment(1) != '')
            .header-nav-wrapper {
                background-color: #fff;
            }
        @endif

        :root {
            --theme-color-1: {{ $visual_setting->color_1 }};
            --theme-color-2: {{ $visual_setting->color_2 }};
        }

        @media only screen and (max-width: 1000px) {
            .header.header-floating {
                position: relative;
                background-color: #fff;
            }
            .header.header-floating.home-mobile-hero-navigation {
                position:absolute;
                background-color:transparent;
            }
            .header.header-floating.landing-hero-navigation {
                position:absolute !important;
                background-color:transparent !important;
            }
            .header.header-floating.landing-hero-navigation .header-nav-wrapper,
            .header.header-floating.landing-hero-navigation .menuzord {
                background:transparent !important;
                box-shadow:none !important;
            }
            .header.header-floating.landing-hero-navigation .header-nav {
                position:fixed !important;
                top:0 !important;
                left:0 !important;
                right:0 !important;
                width:100% !important;
            }
            .header.header-floating.landing-hero-navigation .menuzord-responsive .showhide em {
                background:#084451 !important;
            }
        }

        @media only screen and (max-width: 1199px) and (min-width: 1000px) {
            .ipad_header {
                width: 1100px;
            }
            .menuzord-menu > li > a {
                padding: 22px 5px !important;
            }
            .menuzord-menu.menuzord-right {
                float: inherit;
            }
        }
    </style>
    @if ($heroOverlayNavigation)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const header = document.getElementById('header');
                const hero = document.getElementById('home');
                if (!header || !hero) return;
                const isLandingNavigation = header.classList.contains('landing-hero-navigation');
                const scrolledClass = isLandingNavigation ? 'landing-hero-scrolled' : 'mobile-hero-scrolled';
                const nav = header.querySelector('.header-nav');
                const navWrapper = header.querySelector('.header-nav-wrapper');
                const menu = header.querySelector('.menuzord');
                const updateMobileHeroNavigation = function () {
                    if (window.innerWidth > 1000 && !isLandingNavigation) {
                        header.classList.remove(scrolledClass);
                        [header, nav, navWrapper, menu].filter(Boolean).forEach(function (element) {
                            element.style.removeProperty('background-color');
                            element.style.removeProperty('box-shadow');
                        });
                        ['position', 'top', 'left', 'width'].forEach(function (property) {
                            header.style.removeProperty(property);
                            if (nav) nav.style.removeProperty(property);
                        });
                        return;
                    }
                    const scrolled = Math.max(
                        window.pageYOffset || 0,
                        document.documentElement.scrollTop || 0,
                        document.body.scrollTop || 0
                    ) > 12;
                    header.classList.toggle(scrolledClass, scrolled);
                    if (scrolled) {
                        header.style.setProperty('position', 'fixed', 'important');
                        header.style.setProperty('top', '0', 'important');
                        header.style.setProperty('left', '0', 'important');
                        header.style.setProperty('width', '100%', 'important');
                        if (nav && !isLandingNavigation) {
                            nav.style.setProperty('position', 'fixed', 'important');
                            nav.style.setProperty('top', '0', 'important');
                            nav.style.setProperty('left', '0', 'important');
                            nav.style.setProperty('width', '100%', 'important');
                            nav.style.setProperty('z-index', '1101', 'important');
                        }
                    } else {
                        header.style.removeProperty('position');
                        header.style.removeProperty('top');
                        header.style.removeProperty('left');
                        header.style.removeProperty('width');
                        if (nav) {
                            ['position', 'top', 'left', 'width', 'z-index'].forEach(function (property) {
                                nav.style.removeProperty(property);
                            });
                        }
                    }
                    [header, nav, navWrapper, menu].filter(Boolean).forEach(function (element) {
                        if (scrolled) {
                            element.style.setProperty('background-color', '#fff', 'important');
                            element.style.setProperty('box-shadow', element === header ? '0 2px 12px rgba(10,49,59,.12)' : 'none', 'important');
                        } else if (isLandingNavigation) {
                            element.style.setProperty('background-color', 'transparent', 'important');
                            element.style.setProperty('box-shadow', 'none', 'important');
                        } else {
                            element.style.removeProperty('background-color');
                            element.style.removeProperty('box-shadow');
                        }
                    });
                };
                updateMobileHeroNavigation();
                window.addEventListener('scroll', updateMobileHeroNavigation, { passive: true });
                document.addEventListener('scroll', updateMobileHeroNavigation, { passive: true, capture: true });
                window.addEventListener('resize', updateMobileHeroNavigation);
                (function watchMobileHeroNavigation() {
                    updateMobileHeroNavigation();
                    window.requestAnimationFrame(watchMobileHeroNavigation);
                }());
                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.home-mobile-hero-navigation .showhide, .landing-hero-navigation .showhide')) return;
                    header.classList.toggle('mobile-menu-open');
                }, true);
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const makeMobileMenuToggleCrawlable = function () {
                const toggle = document.querySelector('#menuzord-right > .showhide, #menuzord-right .showhide');
                if (!toggle) return false;
                if (/^javascript:/i.test(toggle.getAttribute('href') || '')) {
                    toggle.setAttribute('href', '#menuzord-right');
                }
                toggle.setAttribute('role', 'button');
                toggle.setAttribute('aria-label', 'Toggle navigation menu');
                toggle.setAttribute('aria-controls', 'menuzord-right');
                if (!toggle.querySelector('.sr-only')) {
                    const label = document.createElement('span');
                    label.className = 'sr-only';
                    label.textContent = 'Toggle navigation menu';
                    toggle.appendChild(label);
                }
                toggle.addEventListener('click', function (event) { event.preventDefault(); });
                return true;
            };

            if (makeMobileMenuToggleCrawlable()) return;
            const observer = new MutationObserver(function () {
                if (makeMobileMenuToggleCrawlable()) observer.disconnect();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
</div>

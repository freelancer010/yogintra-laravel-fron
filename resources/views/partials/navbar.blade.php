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
    <header id="header" class="header header-floating {{ $videoHeroNavigation ? 'video-hero-navigation' : '' }} {{ $homeMobileHeroNavigation ? 'home-mobile-hero-navigation' : '' }} {{ $landingHeroNavigation ? 'landing-hero-navigation' : '' }} {{ request()->segment(1) !== null ? 'non-home-navigation' : '' }}">
        <div class="header-top sm-text-center style-bordered">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
        <div class="header-nav navbar-scrolltofixed navbar-sticky-animated" style="z-index: 999; position: relative; top: 0px;">
            <div class="header-nav-wrapper">
                <div class="container ipad_header">
                    <nav id="menuzord-right" class="menuzord orange no-bg menuzord-responsive">
                        @if ($homeMobileHeroNavigation || $landingHeroNavigation)
                            <button type="button" class="{{ $homeMobileHeroNavigation ? 'home-native-menu-toggle' : 'landing-native-menu-toggle' }}" aria-label="Toggle navigation menu" aria-controls="{{ $homeMobileHeroNavigation ? 'home-navigation-menu' : 'landing-navigation-menu' }}" aria-expanded="false">
                                <em></em><em></em><em></em>
                                <span class="sr-only">Toggle navigation menu</span>
                            </button>
                        @endif
                        <a class="menuzord-brand switchable-logo pull-left flip mb-10" href="{{ url('/') }}" aria-label="YogIntra home page">
                            <img class="logo-default" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo" title="YogIntra Logo" fetchpriority="high" decoding="async">
                            <img class="logo-scrolled-to-fixed" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo" title="YogIntra Logo">
                            <span class="sr-only">YogIntra home page</span>
                        </a>
                        <ul @if ($homeMobileHeroNavigation) id="home-navigation-menu" @elseif ($landingHeroNavigation) id="landing-navigation-menu" @endif class="menuzord-menu menuzord-right menuzord-indented scrollable" style="max-height: 400px;">
                            <li class="{{ request()->segment(1) == '' ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                            <li class="home-has-submenu {{ in_array(request()->segment(1), ['about', 'gallery']) ? 'active' : '' }}">
                                <a href="{{ url('/about-us') }}">About</a>
                                <ul class="dropdown">
                                    <li><a href="{{ url('/about-us') }}">About</a></li>   
                                    <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                                </ul>
                            </li>
                            
                            <li class="{{ request()->segment(1) == 'blog' ? 'active' : '' }}">
                                <a href="{{ url('/blog') }}">Blog</a>
                            </li>

                            <li class="home-has-submenu {{ request()->segment(1) == 'service' ? 'active' : '' }}">
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
                            <li class="home-has-submenu {{ in_array(request()->segment(1), ['teacher-training-course', 'retreat', 'workshop']) ? 'active' : '' }}">
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
            :root{--theme-color-1:{{ $visual_setting->color_1 }};--theme-color-2:{{ $visual_setting->color_2 }};}
            .landing-native-menu-toggle{display:none}
            .landing-submenu-toggle{display:none}
            .landing-hero-navigation .menuzord-menu>li.home-has-submenu>a:after{display:inline-block;width:7px;height:7px;margin:0 0 3px 8px;border-right:2px solid currentColor;border-bottom:2px solid currentColor;content:'';transform:rotate(45deg)}
            @media only screen and (max-width:1000px){
                .landing-hero-navigation .landing-native-menu-toggle{position:absolute;top:0;right:8px;z-index:4;display:flex!important;width:56px;height:64px;flex-direction:column;align-items:center;justify-content:center;gap:5px;margin:0;padding:0;border:0;background:transparent;cursor:pointer}
                .landing-hero-navigation .landing-native-menu-toggle em{display:block!important;width:27px!important;height:3px!important;margin:0!important;border-radius:3px;background:#084451!important}
                .landing-hero-navigation .menuzord>.showhide{display:none!important}
                .landing-hero-navigation .menuzord-menu{display:none!important}
                .landing-hero-navigation.mobile-menu-open .menuzord-menu{display:block!important;width:100%!important}
                .landing-hero-navigation.mobile-menu-open .landing-native-menu-toggle em{opacity:0}
                .landing-hero-navigation.mobile-menu-open .landing-native-menu-toggle:before,.landing-hero-navigation.mobile-menu-open .landing-native-menu-toggle:after{content:'';position:absolute;top:30px;right:14px;width:27px;height:3px;border-radius:3px;background:#084451}
                .landing-hero-navigation.mobile-menu-open .landing-native-menu-toggle:before{transform:rotate(45deg)}
                .landing-hero-navigation.mobile-menu-open .landing-native-menu-toggle:after{transform:rotate(-45deg)}
                .landing-hero-navigation .menuzord-menu>li.home-has-submenu{position:relative}
                .landing-hero-navigation .menuzord-menu>li.home-has-submenu>a{padding-right:52px!important}
                .landing-hero-navigation .menuzord-menu>li.home-has-submenu>a:after{display:none}
                .landing-hero-navigation .landing-submenu-toggle{position:absolute;top:2px;right:4px;display:flex;width:44px;height:44px;align-items:center;justify-content:center;padding:0;border:0;border-radius:6px;background:transparent;color:#084451;cursor:pointer}
                .landing-hero-navigation .landing-submenu-toggle:after{width:9px;height:9px;border-right:2px solid currentColor;border-bottom:2px solid currentColor;content:'';transform:rotate(45deg);transition:transform .2s ease}
                .landing-hero-navigation .landing-submenu-toggle[aria-expanded=true]:after{transform:rotate(225deg)}
                .landing-hero-navigation .landing-submenu-toggle:focus{outline:2px solid #14757d;outline-offset:-3px}
                .landing-hero-navigation .menuzord-menu>li.home-has-submenu>ul.dropdown,.landing-hero-navigation .menuzord-menu>li.home-has-submenu>ul.megamenu{display:none!important;position:static!important;width:100%!important;background:#f5f9f9!important;box-shadow:none!important}
                .landing-hero-navigation .menuzord-menu>li.landing-submenu-open>ul.dropdown,.landing-hero-navigation .menuzord-menu>li.landing-submenu-open>ul.megamenu{display:block!important}
            }
        </style>
    @if ($heroOverlayNavigation)
                <script src="{{ asset('assets/front/js/navbar-hero.js') }}?v={{ filemtime(public_path('assets/front/js/navbar-hero.js')) }}" defer></script>
    @endif
        <script src="{{ asset('assets/front/js/navbar-accessibility.min.js') }}" defer></script>
</div>

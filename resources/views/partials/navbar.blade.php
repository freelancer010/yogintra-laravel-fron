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
                        <a class="menuzord-brand switchable-logo pull-left flip mb-10" href="{{ url('/') }}" aria-label="YogIntra home page">
                            <img class="logo-default" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo" title="YogIntra Logo" fetchpriority="high" decoding="async">
                            <img class="logo-scrolled-to-fixed" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo" title="YogIntra Logo">
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
        <style>:root{--theme-color-1:{{ $visual_setting->color_1 }};--theme-color-2:{{ $visual_setting->color_2 }};}</style>
    @if ($heroOverlayNavigation)
                <script src="{{ asset('assets/front/js/navbar-hero.js') }}" defer></script>
    @endif
        <script src="{{ asset('assets/front/js/navbar-accessibility.js') }}" defer></script>
</div>

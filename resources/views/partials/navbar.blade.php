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
    @endphp
    <header id="header" class="header header-floating {{ $videoHeroNavigation ? 'video-hero-navigation' : '' }}">
        <div class="header-top sm-text-center style-bordered">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
        <div class="header-nav navbar-scrolltofixed navbar-sticky-animated" style="z-index: 999; position: relative; top: 0px;">
            <div class="header-nav-wrapper">
                <div class="container ipad_header">
                    <nav id="menuzord-right" class="menuzord orange no-bg menuzord-responsive">
                        <a class="menuzord-brand switchable-logo pull-left flip mb-10" href="{{ url('/') }}">
                            <img class="logo-default" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo">
                            <img class="logo-scrolled-to-fixed" width="205" height="55" src="{{ asset($app_setting->app_sticky_logo) }}" alt="YogIntra Logo">
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
                                            <a href="{{ url('/service/' . $service_menu->service_cat_slug) }}">
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
                width: 180px !important;
            }
            .menuzord-responsive .showhide {
                margin-top: 0;
            }
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
        @media only screen and (max-width: 1000px) {
            .video-hero-navigation .header-nav .menuzord-menu > li > a,
            .video-hero-navigation .header-nav .menuzord-menu > li > a > i,
            .video-hero-navigation .header-nav .menuzord-menu > li.active > a,
            .video-hero-navigation .header-nav .menuzord-menu > li:hover > a,
            .video-hero-navigation .header-nav .menuzord-responsive .showhide em {
                color:#222 !important;
            }
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
</div>

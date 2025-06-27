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
    <header id="header" class="header header-floating">
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
                                <a href="#">About</a>
                                <ul class="dropdown">
                                    <li><a href="{{ url('/about') }}">About</a></li>   
                                    <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                                </ul>
                            </li>
                            
                            <li class="{{ request()->segment(1) == 'blog' ? 'active' : '' }}">
                                <a href="{{ url('/blog') }}">Blog</a>
                            </li>

                            <li class="{{ request()->segment(1) == 'service' ? 'active' : '' }}">
                                <a href="#">Yoga Services</a>
                                <ul class="dropdown">
                                    @foreach ($all_service as $service_menu)
                                        <li>
                                            <a href="{{ url('/service/' . $service_menu->service_cat_slug) }}">
                                                {{ $service_menu->service_cat_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="{{ request()->segment(1) == 'yoga-center' ? 'active' : '' }}">
                                <a href="{{ url('/yoga-center') }}">Yoga Center</a>
                            </li>
                            <li class="{{ in_array(request()->segment(2), ['teacher-training-course', 'retreat', 'workshop']) ? 'active' : '' }}">
                                <a href="#">Events</a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('ttc') }}">TTC</a></li>   
                                    <li><a href="{{ route('retreat.all') }}">Retreat</a></li>
                                    <li><a href="{{ route('workshop') }}">Workshop</a></li>
                                </ul>
                            </li>
                            <li class="{{ request()->segment(1) == 'trainers' ? 'active' : '' }}">
                                <a href="{{ url('/trainers') }}">Trainer</a>
                            </li>
                            <li class="{{ request()->segment(1) == 'become-yoga-trainer' ? 'active' : '' }}">
                                <a href="{{ url('/become-yoga-trainer') }}">Hire</a>
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
        #header {
            height: 90px;
        }
        .menuzord-brand {
            margin: 10px 30px 0 0;
        }
        .menuzord-menu > li > a {
            padding: 22px 10px;
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

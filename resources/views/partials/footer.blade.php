@php($businessContact = \App\Support\BusinessContact::fromSetting($app_setting))
<footer id="footer" class="{{ request()->is('/') ? 'landing-global-footer ' : '' }}footer bg-black-000">
    <div class="container pt-40 pb-0">
        <div class="row border-bottom-black">
            <div class="col-sm-6 col-md-3">
                <div class="widget dark mb-5">
                    <img class="mt-10 mb-20" width="246" height="66" alt="{{ $app_setting->app_name ?? 'YogIntra' }}" title="{{ $app_setting->app_name ?? 'YogIntra' }} Logo" loading="lazy" src="{{ asset($app_setting->app_footer_logo ?? 'uploads/6522371db10e06501ab36d6f70Rectrangular-logo-2.png') }}">
                    <p>{{ $app_setting->footer_about_us ?? 'YogIntra helps promote balanced physical, mental and spiritual wellbeing.' }}</p>
                </div>
                <div class="widget dark mb-0">
                    @php($socialLinks = \App\Support\SocialMedia::links($app_setting))
                    <ul class="styled-icons icon-dark icon-circled icon-sm">
                        @foreach($socialLinks as $social)
                            <li><a href="{{ $social['url'] }}" aria-label="Visit us on {{ $social['label'] }}"><i class="fa fa-{{ $social['icon'] }}" aria-hidden="true"></i><span class="sr-only">Visit YogIntra on {{ $social['label'] }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        <div class="col-sm-6 col-md-2">
                <div class="widget dark mb-0">
                    <div class="widget-title line-bottom footer-heading">Our Events</div>
                    <ul class="list-border">
                        <li><a href="{{ url('/teacher-training-course') }}">TTC</a></li>   
                        <li><a href="{{ url('/retreat') }}">Retreat</a></li>
                        <li><a href="{{ url('/workshop') }}">Workshop</a></li>
                        <li><a href="{{ url('become-yoga-trainer') }}">Hire</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="widget dark mb-0">
                    <div class="widget-title line-bottom footer-heading">Useful Links</div>
                    <ul class="list-border">
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ url('blog') }}">Blog</a></li>
                        <li><a href="{{ url('/locate-us') }}">Locate Us</a></li>
                        <li><a href="{{ url('contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="widget dark mb-0">
                    <div class="widget-title line-bottom footer-heading">Our Service</div>
                    <ul class="list-border">
                        <li><a href="{{ url('home-visit-yoga') }}">Home Visit Yoga</a></li>
                        <li><a href="{{ url('private-online-yoga') }}">Private Online Yoga</a></li>
                        <li><a href="{{ url('group-online-yoga') }}">Group Online Yoga</a></li>
                        <li><a href="{{ url('corporate-yoga') }}">Corporate Yoga</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark mb-0">
                    <div class="widget-title line-bottom footer-heading">Support</div>
                    <address class="opening-hours mb-0" style="font-style:normal" itemscope itemtype="https://schema.org/PostalAddress">
                        <ul class="list-border mt-5">
                            @if($businessContact['visible_address'])
                                <li class="m-0 pl-10 pr-10">
                                    <i class="fa fa-map-marker text-theme-colored mr-5" aria-hidden="true"></i>
                                    <a class="text-gray" href="{{ $businessContact['map_url'] }}" rel="nofollow noopener noreferrer" title="View {{ $app_setting->app_name ?? 'YogIntra' }} on Google Maps"><span itemprop="streetAddress">{{ $businessContact['visible_address'] }}</span></a>
                                    @if($businessContact['locality'])<meta itemprop="addressLocality" content="{{ $businessContact['locality'] }}">@endif
                                    @if($businessContact['region'])<meta itemprop="addressRegion" content="{{ $businessContact['region'] }}">@endif
                                    @if($businessContact['postal_code'])<meta itemprop="postalCode" content="{{ $businessContact['postal_code'] }}">@endif
                                    @if($businessContact['country'])<meta itemprop="addressCountry" content="{{ $businessContact['country'] }}">@endif
                                </li>
                            @endif
                            @if($businessContact['telephone'])
                                <li class="m-0 pl-10 pr-10">
                                    <i class="fa fa-phone text-theme-colored mr-5" aria-hidden="true"></i>
                                    <a class="text-gray" itemprop="telephone" href="tel:{{ $businessContact['telephone_href'] }}">{{ $businessContact['telephone'] }}</a>
                                </li>
                            @endif
                            @if($businessContact['email'])
                                <li class="m-0 pl-10 pr-10">
                                    <i class="fa fa-envelope-o text-theme-colored mr-5" aria-hidden="true"></i>
                                    <a class="text-gray" itemprop="email" href="mailto:{{ $businessContact['email'] }}">{{ $businessContact['email'] }}</a>
                                </li>
                            @endif
                        </ul>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright & Policies -->
    <div class="footer-bottom bg-black-000 mt-0 pt-20 pb-20">
        <hr>
        <div class="container pt-12 pb-0">
            <div class="row">
                <div class="col-md-6">
                    <p class="font-13 text-white m-0 text-center pb-10">
                        Copyright &copy;{{ date('Y') }} YogIntra. All Rights Reserved
                    </p>
                </div>
                <div class="col-md-6 text-center text-sm-right">
                    <ul>
                        <li style="display:inline-block" class="pr-10"><a class="text-white" href="{{ url('terms-and-condition') }}">Terms & Condition</a></li>
                        <li style="display:inline-block" class="pr-10">|</li>
                        <li style="display:inline-block" class="pr-10"><a class="text-white" href="{{ url('refund-policy') }}">Refund Policy</a></li>
                        <li style="display:inline-block" class="pr-10">|</li>
                        <li style="display:inline-block" class="pr-10"><a class="text-white" href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                        <li style="display:inline-block" class="pr-10">|</li>
                        <li style="display:inline-block" class="pr-10"><a class="text-white" href="{{ url('editorial-policy') }}">Editorial Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
{{-- <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a> --}}

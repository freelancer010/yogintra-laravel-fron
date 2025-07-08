<footer id="footer" class="footer bg-black-111" style="background-color:#000!important;">
    <div class="container pt-40 pb-0">
        <div class="row border-bottom-black">
            <div class="col-sm-6 col-md-3">
                <div class="widget dark mb-5">
                    <img class="mt-10 mb-20" width="246" height="66" alt="YogIntra" loading="lazy" src="{{ asset('uploads/6522371db10e06501ab36d6f70Rectrangular-logo-2.png') }}">
                    <p>YogIntra helps promote a balanced development of the physical, mental, and spiritual being.</p>
                </div>
                <div class="widget dark mb-0">
                    <ul class="styled-icons icon-dark icon-circled icon-sm">
                        <li><a href="https://www.facebook.com/yogintra" aria-label="Visit us on Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/yogintra" aria-label="Visit us on Instagram"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://www.linkedin.com/in/yog-intra-410a09240" aria-label="Visit us on LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="https://twitter.com/yogintra" aria-label="Visit us on Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UC04qAXsiUicHix2WChFPFvA" aria-label="Visit us on YouTube"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        <div class="col-sm-6 col-md-2">
                <div class="widget dark mb-0">
                    <h5 class="widget-title line-bottom">Our Events</h5>
                    <ul class="list-border">
                        <li><a href="{{ url('/teacher-training-course') }}">TTC</a></li>   
                        <li><a href="{{ url('/retreat') }}">Retreat</a></li>
                        <li><a href="{{ url('/workshop') }}">Workshop</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="widget dark mb-0">
                    <h5 class="widget-title line-bottom">Useful Links</h5>
                    <ul class="list-border">
                        <li><a href="{{ url('about') }}">About</a></li>
                        <li><a href="{{ url('become-yoga-trainer') }}">Hire</a></li>
                        <li><a href="{{ url('blog') }}">Blog</a></li>
                        <li><a href="{{ url('contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="widget dark mb-0">
                    <h5 class="widget-title line-bottom">Our Service</h5>
                    <ul class="list-border">
                        <li><a href="{{ url('service/home-visit-yoga') }}">Home Visit Yoga</a></li>
                        <li><a href="{{ url('service/private-online-yoga') }}">Private Online Yoga</a></li>
                        <li><a href="{{ url('service/group-online-yoga') }}">Group Online Yoga</a></li>
                        <li><a href="{{ url('service/corporate-yoga') }}">Corporate Yoga</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark mb-0">
                    <h5 class="widget-title line-bottom">Support</h5>
                    <div class="opening-hours">
                        <ul class="list-border mt-5">
                            <li class="m-0 pl-10 pr-10"> 
                                <i class="fa fa-map-marker text-theme-colored mr-5"></i> 
                                <a class="text-gray" href="#">D-408 Shivlila Apt, Mumbra Devi Colony Road, Diva East, Thane-400612</a> 
                            </li>
                            <li class="m-0 pl-10 pr-10"> 
                                <i class="fa fa-phone text-theme-colored mr-5"></i> 
                                <a class="text-gray" href="#">+91-9867291573</a> 
                            </li>
                            <li class="m-0 pl-10 pr-10"> 
                                <i class="fa fa-envelope-o text-theme-colored mr-5"></i> 
                                <a class="text-gray" href="mailto:support@yogintra.com">support@yogintra.com</a> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- City Locate Section -->
    <div class="footer-bottom" style="background-color: black;">
        <div class="container pt-0 pb-10">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="font-18 text-white-777 m-0 text-center pb-10 city_loc line-bottom" style="color: white;font-family: 'Open Sans', sans-serif !important;font-size: 18px;font-weight: 500;">
                        Locate Us
                    </h5>
                </div>
                <div class="col-md-12 text-center text-md-right city_loc">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($all_landing_page as $page)
                            <li style="display: inline-block; margin-right: 10px;">
                                <a href="{{ url('city/' . $page->page_slug) }}">{{ $page->page_name }}&nbsp;&nbsp;&nbsp;|</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright & Policies -->
    <div class="footer-bottom bg-black-222">
        <div class="container pt-12 pb-0">
            <div class="row">
                <div class="col-md-6">
                    <p class="font-13 text-black-777 m-0 text-center pb-10">
                        Copyright &copy;{{ date('Y') }} YogIntra. All Rights Reserved
                    </p>
                </div>
                <div class="col-md-6 text-center text-sm-right">
                    <ul>
                        <li style="display:inline-block" class="pr-10"><a href="{{ url('terms-and-condition') }}">Terms & Condition</a></li>
                        <li style="display:inline-block" class="pr-10">|</li>
                        <li style="display:inline-block" class="pr-10"><a href="{{ url('refund-policy') }}">Refund Policy</a></li>
                        <li style="display:inline-block" class="pr-10">|</li>
                        <li style="display:inline-block" class="pr-10"><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
{{-- <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a> --}}

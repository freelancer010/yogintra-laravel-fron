@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Gallery | YogIntra')
@section('meta_description', 'We are constantly raising awareness of detoxifying the mind and body from within. We guide you to improve your inner beauty and personality through yoga.')
@section('meta_keywords', 'Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')

@push('styles')
<style>
    .styled-icons .fa {
        line-height: 2.5;
    }
</style>
@endpush

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 55px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title text-white">Gallery</h2>
                    <ol class="breadcrumb text-center text-black mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="active text-gray">Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section>
    <div class="container">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12">

                    <!-- Portfolio Filter -->
                    <div class="portfolio-filter text-center mb-30">
                        <a href="#" class="active" data-filter="*">All</a>
                        @foreach ($all_category as $category)
                            @php $filterClass = 'cat-' . Str::slug($category->g_cat_name, '-'); @endphp
                            <a href="#" data-filter=".{{ $filterClass }}">{{ $category->g_cat_name }}</a>
                        @endforeach
                    </div>

                    <!-- Portfolio Gallery Grid -->
                    <div id="grid" class="gallery-isotope default-animation-effect grid-4 gutter clearfix">
                        @foreach ($all_gallery as $gallery)
                            @php
                                $isImage = $gallery->gallery_is_video_or_image == 1;
                                $categoryClass = $gallery->g_cat_name
                                    ? 'cat-' . Str::slug($gallery->g_cat_name, '-')
                                    : 'cat-uncategorized';
                            @endphp

                            <div class="gallery-item {{ $categoryClass }}">
                                <div class="thumb">
                                    @if ($isImage)
                                        <img style="height: 200px;" class="img-fullwidth" src="{{ asset($gallery->gallery_image) }}" alt="{{ $gallery->g_cat_name }}">
                                        <div class="overlay-shade"></div>
                                        <div class="icons-holder">
                                            <div class="icons-holder-inner">
                                                <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                    <a data-lightbox="image" href="{{ asset($gallery->gallery_image) }}"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="hover-link" data-lightbox="image" href="{{ asset($gallery->gallery_image) }}">View more</a>
                                        <h5 class="mt-10 text-center">{{ $gallery->g_cat_name }}</h5>
                                    @else
                                        @php
                                            $videoId = explode('?v=', $gallery->gallery_video)[1] ?? '';
                                            $videoThumbnail = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                                        @endphp
                                        <img style="height: 200px;" class="img-fullwidth" src="{{ $videoThumbnail }}" alt="YouTube Video">
                                        <div class="overlay-shade"></div>
                                        <div class="icons-holder">
                                            <div class="icons-holder-inner">
                                                <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                    <a class="popup-youtube" href="{{ $gallery->gallery_video }}"><i class="fa fa-youtube-play"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="mt-10 text-center">{{ $gallery->g_cat_name }}</h5>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/front/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/front/js/isotope.pkgd.min.js') }}"></script>

<script>
    $(document).ready(function () {
        var $gallery = $(".gallery-isotope");
        var $filterLinks = $(".portfolio-filter a");

        if ($gallery.length > 0) {
            $gallery.imagesLoaded(function () {
                $gallery.isotope({
                    itemSelector: '.gallery-item',
                    layoutMode: $gallery.hasClass("masonry") ? "masonry" : "fitRows",
                    filter: "*"
                });
            });
        }

        $filterLinks.on("click", function (e) {
            e.preventDefault();
            $filterLinks.removeClass("active");
            $(this).addClass("active");

            var filterValue = $(this).data("filter");
            $gallery.isotope({ filter: filterValue });
        });
    });
</script>
@endpush

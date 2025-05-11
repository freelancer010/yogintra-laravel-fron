@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', $service->page_meta_title ?? $service->service_cat_name . ' | YogIntra')
@section('meta_description', $service->page_meta_description ?? '')
@section('meta_keywords', $service->page_meta_keywords ?? '')

@push('styles')
<style type="text/css">
    .box-hover-effect:hover .effect-wrapper .text-holder-top-right {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
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
                    <h2 class="title text-white">Service</h2>
                    <ol class="breadcrumb text-center mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="active text-gray">Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Course Grid -->
<section>
    <div class="container pb-20">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <p>YogIntra provides One of the Best {{ $service->service_cat_name }} in India with our expertise, professional and experienced team of Trainers.</p>
                </div>
            </div>
        </div>

        <div class="section-content">
            <div class="row">
                @if ($all_service_data && count($all_service_data) > 0)
                    @foreach ($all_service_data as $service_data)
                        <div class="col-xs-12 col-sm-6 col-md-4 mb-30">
                            <div class="box-hover-effect thumb-cross-effect">
                                <div class="effect-wrapper">
                                    <div class="thumb">
                                        <img class="img-fullwidth" src="{{ asset($service_data->service_image) }}" alt="{{ $service_data->service_name }}">
                                    </div>
                                    <div class="text-holder text-holder-top-right">
                                        <a href="{{ url('/service-details/' . $service_data->service_slug) }}" class="btn btn-dark btn-theme-colored">View More</a>
                                    </div>
                                    <a class="hover-link" href="{{ url('/service-details/' . $service_data->service_slug) }}">View more</a>
                                </div>
                                <h3><a href="{{ url('/service-details/' . $service_data->service_slug) }}">{{ $service_data->service_name }}</a></h3>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-30 text-center">
                        <h2>No Data Found</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

@endpush

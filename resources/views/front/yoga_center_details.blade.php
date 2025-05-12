@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Best Yoga Center in India | YogIntra')
@section('meta_description', 'Yoga Training is a renowned Best Yoga Center in India. It offers various yoga classes, online yoga classes, or group yoga classes in India.')
@section('meta_keywords', 'Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, best yoga classes in Mumbai, Yoga Teacher Training Courses')

@push('styles')
@endpush

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title text-white">{{ \Illuminate\Support\Str::limit($center->center_name, 30, '...') }}</h2>
                    <ol class="breadcrumb text-center mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li><a href="{{ url('/yoga_center') }}" class="text-white">Yoga Center</a></li>
                        <li class="active text-gray">{{ \Illuminate\Support\Str::limit($center->center_name, 30, '...') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <!-- Image -->
            <div class="col-md-12">
                <img src="{{ asset($center->center_image) }}" alt="{{ $center->center_name }}" width="100%">
            </div>

            <!-- Contact Info Row -->
            <div class="col-md-12">
                <div class="row bg-light m-0">
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <div class="bg-light media border-bottom p-15 mb-20">
                                    <div class="media-left">
                                        <i class="pe-7s-home text-theme-colored font-24 mt-5"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-0">Location:</h5>
                                        <p>{{ $center->center_address }}, {{ $center->center_city }}, {{ $center->center_state }},
                                            {{ $center->center_country }}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <ul>
                            <li>
                                <div class="bg-light media border-bottom p-15 pb-0">
                                    <div class="media-left">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="media-body">
                                        <a class="d-flex" href="mailto:{{ $center->email_address }}">{{ $center->email_address }}</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="bg-light media border-bottom p-15 pb-0">
                                    <div class="media-left">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="media-body">
                                        <a class="d-flex" href="tel:{{ $center->mobile_number }}">{{ $center->mobile_number }}</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <div class="bg-light media border-bottom p-15 mb-20">
                            <ul>
                                <li>
                                    <h5>Share:</h5>
                                    <div class="styled-icons icon-sm icon-gray icon-circled">
                                        <a href="https://www.facebook.com/yogintra"><i class="fa fa-facebook"></i></a>
                                        <a href="https://twitter.com/yogintra"><i class="fa fa-twitter"></i></a>
                                        <a href="https://www.instagram.com/yogintra"><i class="fa fa-instagram"></i></a>
                                        <a href="https://www.linkedin.com/in/yogintra/"><i class="fa fa-linkedin"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="col-sm-12 mt-30">
                <p style="text-align:justify">{!! $center->center_description !!}</p>
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')

@endpush

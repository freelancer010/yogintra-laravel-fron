@extends('layouts.layout')

@section('meta_title', 'Contact Us - YogIntra')
@section('meta_description', 'Contact us directly or get a phone number and email address for a Yoga Class in India. Our YogIntra team is available for guidance to answer any questions!')
@section('meta_keywords', 'Contact Us, Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Yoga Teacher Training Courses, Best Yoga Classes in Mumbai.')

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px;height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="title text-white">Contact</h2>
          <ol class="breadcrumb text-center text-black mt-10">
            <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
            <li class="active text-gray">Contact</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Have Any Question -->
<section class="divider">
  <div class="container pt-60 pb-60">
    <div class="section-title mb-60">
      <div class="row">
        <div class="col-md-12">
          <div class="esc-heading small-border text-center">
            <h3>Have any Questions?</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="section-content">
      <div class="row">
        <div class="col-sm-12 col-md-4 text-center">
          <i class="fa fa-phone font-36 mb-10 text-theme-colored"></i>
          <h4>Call Us</h4>
          <h6 class="text-gray">Phone: {{ $app_setting->app_mobile }}</h6>
        </div>
        <div class="col-sm-12 col-md-4 text-center">
          <i class="fa fa-map-marker font-36 mb-10 text-theme-colored"></i>
          <h4>Address</h4>
          <h6 class="text-gray">{{ $app_setting->app_address }}</h6>
        </div>
        <div class="col-sm-12 col-md-4 text-center">
          <i class="fa fa-envelope font-36 mb-10 text-theme-colored"></i>
          <h4>Email</h4>
          <h6 class="text-gray">{{ $app_setting->app_email }}</h6>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Divider: Contact -->
<section class="divider bg-lighter">
  <div class="container">
    <div class="row pt-30">
      <div class="col-md-7">
        <h3 class="line-bottom mt-0 mb-30">Interested in discussing?</h3>
        @include('components.multi-step-form')
      </div>
      <div class="col-md-5">
        {!! $app_setting->map_iframe !!}
      </div>
    </div>
  </div>
</section>
@endsection


@push('styles')
<style>
  .form-step {
    display: none;
  }
  .form-step.active {
    display: block;
  }
</style>
@endpush

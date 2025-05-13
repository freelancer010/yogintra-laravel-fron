@extends('layouts.layout')

@section('meta_title', 'Yoga Teacher Jobs and Vacancies')
@section('meta_description', 'As YogIntra is one of the best Yoga Platforms, we are offering an opportunity to be a part of our organization.')
@section('meta_keywords', 'Yoga Teacher Training Jobs and Vacancies, Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="title text-white">Recruitment</h2>
          <ol class="breadcrumb text-center mt-10">
            <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
            <li class="active text-gray">Recruitment</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Become a Trainer Form -->
<section style="background-image: url('{{ asset('assets/front/images/pattern/p4.png') }}');">
  <div class="container">
    <div class="section-title text-center">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="section-3-title">
            <span class="">Become A Trainer</span>
          </div>
          <p>As YogIntra is one of the best Yoga Platform, we are offering a chance to be a part of our organization. You can show your interest by filling the form and Our Team will contact you after analyzing your eligibility.</p>
        </div>
      </div>
    </div>
    <div class="section-content">
      <div class="row">
        <div class="col-md-5">
          <img src="{{ asset('assets/coming_soon.png') }}" alt="Coming Soon">
        </div>
        <div class="col-md-7">
          @include('components.multi-step-form')
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

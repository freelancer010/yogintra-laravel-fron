@extends('layouts.layout')
@section('meta_title', 'Best Yoga Retreats In India - YogIntra')
@section('meta_description', 'YogIntra is the leading center for Best Yoga Retreats In India. We have a wide variety of online yoga classes.')
@section('meta_keywords', 'Best Yoga Retreats In India, Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="title text-white">Retreat</h2>
          <ol class="breadcrumb text-center text-black mt-10">
            <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
            <li class="active text-gray">Retreat</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

@if($all_event->count())
<!-- Section: Upcoming Events -->
<section id="upcoming-events" class="divider parallax layer-overlay overlay-white-8" data-bg-img="images/bg/bg1.jpg">
  <div class="container pb-0 pt-80">
    <div class="section-content">
      <div class="row">
        @foreach ($all_event as $event)
        <div class="col-xs-12 col-sm-6 col-md-6 sm-text-center mb-30 mb-sm-30">
          <div class="schedule-box bg-light mb-30 event-card-ag">
            <div class="thumb">
              <img class="img-fullwidth" alt="{{ $event->title }} Image" src="{{ asset($event->image) }}" style="height:300px;">
              <div class="overlay">
                <a href="{{ url('event/'.$event->link) }}"><i class="fa fa-calendar mr-5"></i></a>
              </div>
            </div>
            <div class="schedule-details clearfix p-15 pt-10" style="border-bottom: none!important;">
              <h5 class="font-16 title elipse-text-title"><a href="{{ url('event/'.$event->link) }}">{{ $event->title }}</a></h5>
              <ul class="list-inline font-11 mb-20">
                <li><i class="fa fa-calendar mr-5"></i> {{ \Carbon\Carbon::parse($event->date_time)->format('d-m-Y h:i A') }}</li>
                <li><i class="fa fa-map-marker mr-5"></i> {{ $event->event_location }}</li>
              </ul>
              <p class="elipse-text">{{ $event->short_content }}</p>
              <div class="mt-10">
                <a class="btn btn-dark btn-theme-colored btn-sm mt-10" href="{{ url('event/'.$event->link) }}">Register</a>
                <a class="btn btn-dark btn-sm mt-10" href="{{ url('event/'.$event->link) }}">Details</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

<section style="background-image: url('{{ asset('assets/front/images/pattern/p4.png') }}');">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <img src="{{ asset('assets/coming_soon.webp') }}">
      </div>
      <div class="col-md-7">
        <div class="mb-40">
          <h1 class="text-uppercase text-center font-38 mt-0"><span class="text-theme-colored">MORE retreat</span> COMING SOON</h1>
        </div>
        @include('components.multi-step-form', ['app_setting' => $app_setting])
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
@endpush

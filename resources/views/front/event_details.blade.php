@extends('layouts.layout')

@section('meta_title', $event->title)
@section('meta_description', $event->description)
@section('meta_keywords', $event->keyword)

@section('content')
<!-- Start main-content -->
<div class="main-content">
  <section class="inner-header divider parallax layer-overlay overlay-dark-7" style='background-image: url("{{ asset("assets/front/images/bg/bg6.jpg") }}"); background-position: 50% 45px;height: 300px;'>
    <div class="container pt-60 pb-60">
      <div class="section-content">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="title text-white">{{ \Illuminate\Support\Str::limit($event->title, 30, '...') }}</h2>
            <ol class="breadcrumb text-center mt-10">
              <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
              <li><a href="#" class="text-white">{{ $event->category }}</a></li>
              <li class="active text-gray">{{ \Illuminate\Support\Str::limit($event->title, 30, '...') }}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-theme-colored d-none">
    <div class="container pt-40 pb-40">
      <div class="row text-center">
        <div class="col-md-12">
          <h2 id="basic-coupon-clock" class="text-white"></h2>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        @include('front.pages.event_registration_form')
        <div class="col-md-8">
          <div class="event-img-holder"style="background:url('{{ asset($event->image) }}')" width="100%">
          </div>
          <div class="row mt-15">
            <div class="col-md-6 mt-20">
              <div class="bg-light media border-bottom p-15 mb-20">
                <div class="media-left">
                  <i class="pe-7s-pen text-theme-colored font-24 mt-5"></i>
                </div>
                <div class="media-body">
                  <h5 class="mt-0 mb-0">Topics:</h5>
                  <p>{{ $event->title }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-20">
              <div class="bg-light media border-bottom p-15 mb-20">
                <div class="media-left">
                  <i class="pe-7s-users text-theme-colored font-24 mt-5"></i>
                </div>
                <div class="media-body">
                  <h5 class="mt-0 mb-0">Host:</h5>
                  <p>{{ $event->event_host_by }}</p>
                </div>
              </div>
            </div>
 
            <div class="col-md-6 mt-20">
              <div class="bg-light media border-bottom p-15 mb-20">
                <div class="media-left">
                  <i class="pe-7s-home text-theme-colored font-24 mt-5"></i>
                </div>
                <div class="media-body">
                  <h5 class="mt-0 mb-0">Location:</h5>
                  <p>{{ $event->event_location }}, {{ $event->city }}, {{ $event->state }}, {{ $event->country }} - {{ $event->pin_code }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-20">
              <div class="bg-light media border-bottom p-15 mb-20">
                <div class="media-left">
                  <i class="pe-7s-date text-theme-colored font-24 mt-5"></i>
                </div>
                <div class="media-body">
                  <h5 class="mt-0 mb-0">Event Date:</h5>
                  <p>{{ \Carbon\Carbon::parse($event->date_time)->format('M d, Y h:i A') }} to {{ \Carbon\Carbon::parse($event->end_date_time)->format('M d, Y h:i A') }}</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 mt-20">
              <div class="bg-light media border-bottom p-15 mb-20">
                <div class="media-left">
                  <i class="pe-7s-date text-theme-colored font-24 mt-5"></i>
                </div>
                <div class="media-body">
                  <h5 class="mt-0 mb-0">Share:</h5>
                  <div class="styled-icons icon-sm icon-gray icon-circled">
                    <a href="https://www.facebook.com/yogintra"><i class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/yogintra"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.instagram.com/yogintra"><i class="fa fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/yogintra/"><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      
      <div class="row mt-60">
        <div class="col-sm-12 offset-sm-2">
          <h4 class="line-bottom mt-20 mb-20 text-theme-colored">All Details</h4>
          <ul id="myTab" class="nav nav-tabs boot-tabs">
            <li class="active"><a href="#small" data-toggle="tab">Description</a></li>
            <li><a href="#medium" data-toggle="tab">Pricing Details</a></li>
          </ul>
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="small">
              {!! $event->content !!}
            </div>
            <div class="tab-pane fade" id="medium">
              @include('partials.price-table')
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .styled-icons a .fa {
    line-height: 2.2;
  }
  .form_booking {
    background-color: #efefef;
    padding: 20px;
  }
  .event-img-holder {
    height: 73vh;
    background-size: cover !important;
    background-position: center !important;
    border-radius: 5px;
    background-repeat: no-repeat !important;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .media {
    box-shadow: 0px 0 10px #00000030;
    border-radius: 5px;
    border: 1px solid #ccc;
    border-bottom: 1px solid #ccc !important;
  }
</style>
<script>
  $(document).ready(function () {
    $('#basic-coupon-clock').countdown("{{ \Carbon\Carbon::parse($event->date_time)->format('Y/m/d H:i') }}", function (event) {
      $(this).html(event.strftime('%D days %H:%M:%S'));
    });

    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    $("#booking-form").submit(function (e) {
      e.preventDefault();
      var form = $(this);
      $.ajax({
        type: "POST",
        url: "{{ url('/submit-event-form') }}",
        data: form.serialize(),
        success: function (data) {
          window.location.href = "{{ url('/payment_for_event') }}";
        }
      });
    });
  });
</script>
@endpush
@endsection

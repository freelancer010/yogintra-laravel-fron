@extends('layouts.layout')

@section('meta_title', $event->title)
@section('meta_description', $event->description)
@section('meta_keywords', $event->keyword)
@section('og_image', asset($event->image))

@section('content')
<!-- Start main-content -->
<div class="main-content">
  <section class="inner-header image-sec divider parallax text-center responsive-image-margin">
    <img class="w-50" src="{{ asset($event->image) }}" />
    <h1 class="text-light mb-5 mt-15">{{ $event->title }}</h1>
  </section>
  
  <section>
    <div class="container">
      <div class="row mt-15">
        <div class="col-md-3 mt-20">
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
        <div class="col-md-3 mt-20">
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

        <div class="col-md-3 mt-20">
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
        <div class="col-md-3 mt-20">
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
      </div>      
      <div class="row">
        <div class="col-md-12">
          <div class="form_booking">
            <form id="booking-form" class="mb-0" name="booking-form" action="#" method="post" enctype="multipart/form-data">
              <h3 class="title text-theme-colored text-center mb-15">Registration Form</h3>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <input id="name" type="text" placeholder="Enter Name" name="register_name" required class="form-control">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input id="phone" type="text" placeholder="Enter Phone" name="register_phone" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input id="email" type="email" placeholder="Enter Email" name="register_email" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <select id="reg_ticket" onchange="get_price(this.value)" name="register_ticket" class="form-control" required>
                      <option value="">Select Ticket</option>
                      @if($event->Indian_stu_checkbox)
                      <option value="1">Indian Student</option>
                      @endif
                      @if($event->Foreign_stu_checkbox)
                      <option value="2">Foreigner Student</option>
                      @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input id="country" type="text" placeholder="Enter country" name="register_country" required class="form-control">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input id="state" type="text" placeholder="Enter state" name="register_state" required class="form-control">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <input id="city" type="text" placeholder="Enter city" name="register_city" required class="form-control">
                  </div>
                </div>

                @if ($event->addon_name && $event->Extra_addon_checkbox)
                  @php
                    $addonNames = json_decode($event->addon_name, true);
                    $addonPrices = json_decode($event->addon_price, true);
                    $addonCheckboxes = json_decode($event->Extra_addon_checkbox, true);
                  @endphp

                  @if (is_array($addonNames) && count($addonNames))
                    <div class="col-sm-12">
                      @foreach ($addonNames as $index => $name)
                        @if (!empty($addonCheckboxes[$index]))
                          <div class="form-group mb-0">
                            <label>
                              <input type="checkbox" class="addon-checkbox" name="register_addon[]" value="{{ $index }}" data-price="{{ $addonPrices[$index] }}">
                              {{ $name }} (+ ₹{{ $addonPrices[$index] }})
                            </label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  @endif
                @endif
                <div class="col-sm-12">
                  <hr>
                  <div class="price-holder">
                    <p>Main Price : </p>
                    <p>₹<b id="ttl_p1">0</b></p>
                  </div>
                  <div class="price-holder">
                    <p>Discount Price : </p>
                    <p>₹<b id="ttl_p2">0</b></p>
                  </div>
                  <div class="price-holder">
                    <p>Total Price : </p>
                    <p>₹<b id="ttl_p">0</b></p>
                  </div>
                  <input type="hidden" id="tpl">
                  <input type="hidden" id="tplMainAmt" name="ttl_amt">
                  <input type="hidden" name="event_id" value="{{ $event->id }}">
                  <input type="hidden" name="event_category" value="{{ $event->category }}">
                  <input type="hidden" name="event_name" value="{{ $event->title }}">
                </div>

                <div class="col-sm-12">
                  <div class="form-group text-center mb-0">
                    <button class="btn btn-dark btn-theme-colored btn-sm btn-block mt-20 pt-10 pb-10 text-uppercase" type="submit">Register now</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row mt-5">
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .price-holder {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0;
  }
  .styled-icons a .fa {
    line-height: 2.2;
  }
  .form_booking {
    background-color: #efefef;
    padding: 20px;
  }
  .h-70{
    height: 70vh;
  }
  .event-img-holder {
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
  hr {
    border-bottom: 2px solid #ccc !important;
    margin: 0 auto 10px auto !important;
  }

  .responsive-image-margin {
    margin-top: 100px;
  }

  @media (max-width: 768px) {
    .responsive-image-margin {
      margin-top: 0px;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(function () {

    $('input').on('input', function() {
      this.value = this.value.toUpperCase();
    });

    // Booking form submission
    $("#booking-form").submit(function(e) {
      e.preventDefault();
      let form = $(this);

      $.ajax({
        type: "POST",
        url: "{{ route('submit.event.form') }}", // Laravel named route
        data: form.serialize(),
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(data) {
          if (data.success && data.free != true) {
            window.location.href = "{{ route('payment.for.event') }}";
          } else {
            window.location.href = "{{ route('event.thankyou') }}";
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        }
      });
    });

    // Addon checkbox price update
    const checkboxes = document.querySelectorAll('.addon-checkbox');
    checkboxes.forEach(cb => cb.addEventListener('change', calculateTotalAmount));
  });

  let totalAmountMain = 0;

  function calculateTotalAmount() {
    let totalAmount = 0;
    document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
      totalAmount += parseFloat(cb.dataset.price);
    });
    totalAmountMain = totalAmount;

    let ticket_amt = parseFloat($('#tpl').val()) || 0;
    let sum = ticket_amt + totalAmount;

    $('#ttl_p').html(sum);
    $('#tplMainAmt').val(sum);
  }

  function get_price(e) {
    let main, discount, amount;
    if (e == 1) {
      main = @json($event->main_price);
      discount = @json($event->discount_price);
      amount = @json($event->ticket_price_indian);
    } else {
      main = @json($event->main_price);
      discount = @json($event->discount_price);
      amount = @json($event->ticket_price_foreigner);
    }

    amount = parseFloat(amount-discount); // ✅ force it to number

    $('#tpl').val(amount);
    $('#ttl_p').html(amount + totalAmountMain);
    $('#ttl_p1').html(main);
    $('#ttl_p2').html(discount);
    $('#tplMainAmt').val(amount + totalAmountMain);
  }

  function ajaxCall() {
    this.send = function(data, url, method, success, type = 'json') {
      $.ajax({
        url: url,
        type: method,
        data: data,
        success: success,
        error: function(xhr) {
          console.error(xhr.responseText);
        },
        dataType: type,
        timeout: 60000
      });
    }
  }
</script>
@endpush

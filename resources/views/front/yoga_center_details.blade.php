@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_description', $center->page_meta_description)
@section('meta_title', $center->page_title)
@section('meta_keywords', $center->page_keywords)

@push('styles')

  <style type="text/css">
    .styled-icons a .fa {
      line-height: 2.2;
    }

    .form_booking {
      background-color: #efefef;
      padding: 20px;
    }
  </style>
  <style>
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }
</style>
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
<script type="text/javascript">
  $("#booking-form").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
      type: "POST",
      url: "{{ url('/submit_event_form') }}",
      data: form.serialize(),
      success: function(data) {
        window.location.href = "{{ url('/payment_for_event') }}";
      }
    });
  });

  let totalAmountMain = 0;

  $(document).ready(function () {
    const checkboxes = document.querySelectorAll('.addon-checkbox');
    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener('change', function () {
        calculateTotalAmount();
      });
    });
  });

  function calculateTotalAmount() {
    let totalAmount = 0;
    const checkboxes = document.querySelectorAll('.addon-checkbox');
    checkboxes.forEach(function (checkbox) {
      if (checkbox.checked) {
        totalAmount += parseFloat(checkbox.getAttribute('data-price'));
      }
    });

    totalAmountMain = totalAmount;
    let ticket_amt = parseFloat($('#tpl').val()) || 0;
    let sum = totalAmount + ticket_amt;

    $('#ttl_p').html(sum);
    $('#tplMainAmt').val(sum);
  }

  function get_price(e) {
    let amount = e == 1 
      ? {{ $event->ticket_price_indian ?? 0 }} 
      : {{ $event->ticket_price_foreigner ?? 0 }};
    
    $('#tpl').val(amount);
    $('#ttl_p').html(amount + totalAmountMain);
    $('#tplMainAmt').val(amount + totalAmountMain);
  }

  // ----- AJAX Call Handler -----
  function ajaxCall() {
    this.send = function (data, url, method, success, type) {
      type = 'json';
      let successRes = function (data) {
        success(data);
      };
      let errorRes = function (xhr, ajaxOptions, thrownError) {
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      };
      jQuery.ajax({
        url: url,
        type: method,
        data: data,
        success: successRes,
        error: errorRes,
        dataType: type,
        timeout: 60000
      });
    }
  }

  // ----- Location Info API -----
  function locationInfo() {
    var rootUrl = "https://geodata.phplift.net/api/index.php";
    var call = new ajaxCall();

    this.getCities = function (id) {
      jQuery(".cities option:gt(0)").remove();
      var url = rootUrl + '?type=getCities&countryId=&stateId=' + id;
      jQuery('.cities').find("option:eq(0)").html("Please wait..");
      call.send({}, url, 'post', function (data) {
        jQuery('.cities').find("option:eq(0)").html("Select City");
        if (Object.keys(data['result']).length > 0) {
          jQuery.each(data['result'], function (key, val) {
            let option = `<option value='${val.name}'>${val.name}</option>`;
            jQuery('.cities').append(option);
          });
        }
        jQuery(".cities").prop("disabled", false);
      });
    };

    this.getStates = function (id) {
      jQuery(".states option:gt(0), .cities option:gt(0)").remove();
      var url = rootUrl + '?type=getStates&countryId=' + id;
      jQuery('.states').find("option:eq(0)").html("Please wait..");
      call.send({}, url, 'post', function (data) {
        jQuery('.states').find("option:eq(0)").html("Select State");
        jQuery.each(data['result'], function (key, val) {
          let option = `<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`;
          jQuery('.states').append(option);
        });
        jQuery(".states").prop("disabled", false);
      });
    };

    this.getCountries = function () {
      var url = rootUrl + '?type=getCountries';
      jQuery('.countries').find("option:eq(0)").html("Please wait..");
      call.send({}, url, 'post', function (data) {
        jQuery('.countries').find("option:eq(0)").html("Select Country");
        jQuery.each(data['result'], function (key, val) {
          let option = `<option value='${val.name}' countryid='${val.id}'>${val.name}</option>`;
          jQuery('.countries').append(option);
        });
      });
    };
  }

  jQuery(function () {
    var loc = new locationInfo();
    loc.getCountries();

    jQuery(".countries").on("change", function () {
      var countryId = jQuery("option:selected", this).attr('countryid');
      if (countryId != '') {
        loc.getStates(countryId);
      } else {
        jQuery(".states option:gt(0)").remove();
      }
    });

    jQuery(".states").on("change", function () {
      var stateId = jQuery("option:selected", this).attr('stateid');
      if (stateId != '') {
        loc.getCities(stateId);
      } else {
        jQuery(".cities option:gt(0)").remove();
      }
    });
  });
</script>
@endpush

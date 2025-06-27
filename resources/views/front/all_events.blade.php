@php use Illuminate\Support\Str; @endphp
@extends('layouts.layout')



@section('meta_title', 'Yoga Teacher Training Courses | Global Certification')
@section('meta_description', 'The Association for Yoga and Meditation has provided you with the Top Yoga Teacher Training in India.')
@section('meta_keywords', 'Yoga Teacher Training courses,  Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, best yoga classes in Mumbai')



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



@section('content')

<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title text-white">Yoga Teacher Training Course</h2>
                    <ol class="breadcrumb text-center text-black mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="active text-gray">TTC</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@if($all_event->count())
<section id="upcoming-events" style="margin-top:60px">
    <div class="container pb-0 pt-0">
        <div class="section-content">
            <div class="row">
                @foreach ($all_event as $event)
                    <div class="col-xs-12 col-sm-6 col-md-6 sm-text-center mb-30 mb-sm-30">
                        <div class="schedule-box bg-light mb-30 event-card-ag">
                            <div class="thumb">
                                <img class="img-fullwidth" src="{{ asset($event->image) }}" alt="" style="height: 300px;">
                                <div class="overlay">
                                    <a href="{{ url('workshop/' . $event->link) }}"><i class="fa fa-calendar mr-5"></i></a>
                                </div>
                            </div>
                            <div class="schedule-details clearfix p-15 pt-5">
                                <h5 class="font-16 title elipse-text-title">
                                    <a href=" 
                                        @if($event->category == 'TTC') 
                                            {{url('teacher-training-course/' . $event->link)}}
                                        @elseif($event->category == 'Retreat') 
                                            {{url('retreat/' . $event->link)}}
                                        @else
                                            {{url('workshop/' . $event->link) }}
                                        @endif
                                        "
                                    >{{ $event->title }}</a>
                                </h5>
                                <ul class="list-inline font-11 mb-20">
                                    <li><i class="fa fa-calendar mr-5"></i> {{ date('d-m-Y h:i A', strtotime($event->date_time)) }}</li>
                                    <li><i class="fa fa-map-marker mr-5"></i> {{ $event->event_location }}</li>
                                </ul>
                                <p class="elipse-text">{{ $event->short_content }}</p>
                                <div class="mt-10">
                                    <a href="{{ url('workshop/' . $event->link) }}" class="btn btn-dark btn-theme-colored btn-sm mt-10">Register</a>
                                    <a href="{{ url('workshop/' . $event->link) }}" class="btn btn-dark btn-sm mt-10">Details</a>
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

@include('partials.coming-soon-form', ['form_title' => 'MORE YOGA TEACHER TRAINING COURSE'])

@endsection



@push('scripts')
<script type="text/javascript">
$("#multi-step-form").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    $.ajax({
        type: "POST",
        url: '{{ url("home/submit_contact_form") }}',
        data: form.serialize(),
        success: function(data) {
            console.log(data);
            if(data == 1) {
                window.location = "{{ url('thank_you') }}";
            } else {
                alert('Data Submission Failed');
            }
        }
    });
});

function ajaxCall() {
    this.send = function(data, url, method, success, type) {
        type = 'json';
        var successRes = function(data) {
            success(data);
        }
        var errorRes = function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
        $.ajax({
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

function locationInfo() {
    var rootUrl = "https://geodata.phplift.net/api/index.php";
    var call = new ajaxCall();
    this.getCities = function(id) {
        $(".cities option:gt(0)").remove();
        var url = rootUrl + '?type=getCities&countryId=&stateId=' + id;
        var method = "post";
        var data = {};
        $('.cities').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.cities').find("option:eq(0)").html("Select City");
            if(Object.keys(data['result']).length > 0) {
                $.each(data['result'], function(key, val) {
                    var option = `<option value='${val.name}'>${val.name}</option>`;
                    $('.cities').append(option);
                });
            }
            $(".cities").prop("disabled", false);
        });
    };

    this.getStates = function(id) {
        $(".states option:gt(0)").remove();
        $(".cities option:gt(0)").remove();
        var url = rootUrl + '?type=getStates&countryId=' + id;
        var method = "post";
        var data = {};
        $('.states').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.states').find("option:eq(0)").html("Select State");
            $.each(data['result'], function(key, val) {
                var option = `<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`;
                $('.states').append(option);
            });
            $(".states").prop("disabled", false);
        });
    };

    this.getCountries = function() {
        var url = rootUrl + '?type=getCountries';
        var method = "post";
        var data = {};
        $('.countries').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            $('.countries').find("option:eq(0)").html("Select Country");
            $.each(data['result'], function(key, val) {
                var option = `<option value='${val.name}' countryid='${val.id}'>${val.name}</option>`;
                $('.countries').append(option);
            });
        });
    };
}

$(function() {
    var loc = new locationInfo();
    loc.getCountries();
    $(".countries").on("change", function() {
        var countryId = $("option:selected", this).attr('countryid');
        if(countryId !== '') {
            loc.getStates(countryId);
        } else {
            $(".states option:gt(0)").remove();
        }
    });
    $(".states").on("change", function() {
        var stateId = $("option:selected", this).attr('stateid');
        if(stateId !== '') {
            loc.getCities(stateId);
        } else {
            $(".cities option:gt(0)").remove();
        }
    });
});

$(document).ready(function () {
    var currentStep = 1;

    $(".next").click(function () {
        if (validateStep(currentStep)) {
            $("#step-" + currentStep).removeClass("active");
            currentStep++;
            $("#step-" + currentStep).addClass("active");
        }
    });

    $(".prev").click(function () {
        $("#step-" + currentStep).removeClass("active");
        currentStep--;
        $("#step-" + currentStep).addClass("active");
    });

    function validateStep(step) {
        var isValid = true;
        $(".form-group").removeClass("has-error");
        $(".error-message").remove();

        if (step === 1) {
            var name = $("#name").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            if (!name) {
                isValid = false;
                $("#name").closest(".form-group").addClass("has-error")
                       .append('<div class="error-message">Please enter your name.</div>');
            }
            if (!phone) {
                isValid = false;
                $("#phone").closest(".form-group").addClass("has-error")
                       .append('<div class="error-message">Please enter your phone number.</div>');
            }
            if (!email) {
                isValid = false;
                $("#email").closest(".form-group").addClass("has-error")
                       .append('<div class="error-message">Please enter your email address.</div>');
            }
        } else if (step === 2) {
            var country = $("#country").val();
            var state = $("#state").val();
            var city = $("#city").val();
            if (!country) {
                isValid = false;
                $("#country").closest(".form-group").addClass("has-error")
                             .append('<div class="error-message">Please select your country.</div>');
            }
            if (!state) {
                isValid = false;
                $("#state").closest(".form-group").addClass("has-error")
                           .append('<div class="error-message">Please select your state.</div>');
            }
            if (!city) {
                isValid = false;
                $("#city").closest(".form-group").addClass("has-error")
                          .append('<div class="error-message">Please select your city.</div>');
            }
        } else if (step === 3) {
            var message = $("#message").val();
            if (!message) {
                isValid = false;
                $("#message").closest(".form-group").addClass("has-error")
                             .append('<div class="error-message">Please enter a message.</div>');
            }
        }
        return isValid;
    }
});
</script>
@endpush

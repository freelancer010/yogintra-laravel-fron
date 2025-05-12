@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Best Yoga Center in India | YogIntra')
@section('meta_description', 'Yoga Training is a renowned Best Yoga Center in India. It offers various yoga classes, online yoga classes, or group yoga classes in India.')
@section('meta_keywords', 'Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, best yoga classes in Mumbai, Yoga Teacher Training Courses')

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
                    <h2 class="title text-white">All Yoga Center</h2>
                    <ol class="breadcrumb text-center text-black mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="active text-gray">Yoga Center</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

@if($all_center && count($all_center) > 0)
<!-- Section: Upcoming Events -->
<section id="upcoming-events">
    <div class="container pb-0 pt-30">
        <div class="section-content">
            <div class="row">
                @foreach ($all_center as $center)
                    <div class="col-xs-12 col-sm-6 col-md-6 sm-text-center mb-30 mb-sm-30">
                        <div class="schedule-box maxwidth500 bg-light mb-30">
                            <div class="thumb">
                                <img class="img-fullwidth" alt="{{ $center->center_name }}" src="{{ asset($center->center_image) }}" style="height:300px;">
                                <div class="overlay">
                                    <a href="{{ url('/yoga-center/' . $center->center_slug) }}"><i class="fa fa-calendar mr-5"></i></a>
                                </div>
                            </div>
                            <div class="schedule-details clearfix p-15 pt-10">
                                <h5 class="font-16 title">
                                    <a href="{{ url('/yoga-center/' . $center->center_slug) }}">{{ $center->center_name }}</a>
                                </h5>
                                <ul class="list-inline font-11 mb-20" style="margin-bottom: 10px !important;">
                                    <li style="font-size:15px;">{{ $center->mobile_number }}</li>
                                    <li style="font-size:15px;">{{ $center->email_address }}</li>
                                </ul>

                                <div class="thumb">
                                    <div class="overlay1">
                                        {!! $center->map_link !!}
                                    </div>
                                </div>

                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($center->center_description), 70, '...') }}</p>
                                <div class="mt-10">
                                    <a href="{{ url('/yoga-center/' . $center->center_slug) }}" class="btn btn-dark btn-sm mt-10">Details</a>
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


@endsection

@push('scripts')
<script>
    // AJAX Submit
    $("#multi-step-form").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: "POST",
            url: "{{ url('/submit-contact-form') }}", // Laravel route
            data: form.serialize(),
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    window.location.href = "{{ url('/thank-you') }}";
                } else {
                    alert("Data submission failed.");
                }
            }
        });
    });

    // AJAX Helper
    function ajaxCall() {
        this.send = function (data, url, method, success, type = 'json') {
            $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: type,
                success: success,
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },
                timeout: 60000
            });
        }
    }

    // Location Info API
    function locationInfo() {
        const rootUrl = "https://geodata.phplift.net/api/index.php";
        const call = new ajaxCall();

        this.getCountries = function () {
            call.send({}, rootUrl + "?type=getCountries", "POST", function (data) {
                $(".countries").find("option:eq(0)").html("Select Country");
                $.each(data.result, function (key, val) {
                    $(".countries").append(`<option value="${val.name}" countryid="${val.id}">${val.name}</option>`);
                });
            });
        };

        this.getStates = function (countryId) {
            $(".states option:gt(0)").remove();
            $(".cities option:gt(0)").remove();
            $(".states").find("option:eq(0)").html("Please wait...");
            call.send({}, rootUrl + "?type=getStates&countryId=" + countryId, "POST", function (data) {
                $(".states").find("option:eq(0)").html("Select State");
                $.each(data.result, function (key, val) {
                    $(".states").append(`<option value="${val.name}" stateid="${val.id}">${val.name}</option>`);
                });
            });
        };

        this.getCities = function (stateId) {
            $(".cities option:gt(0)").remove();
            $(".cities").find("option:eq(0)").html("Please wait...");
            call.send({}, rootUrl + "?type=getCities&stateId=" + stateId, "POST", function (data) {
                $(".cities").find("option:eq(0)").html("Select City");
                $.each(data.result, function (key, val) {
                    $(".cities").append(`<option value="${val.name}">${val.name}</option>`);
                });
            });
        };
    }

    // Location Dropdown Events
    $(function () {
        const loc = new locationInfo();
        loc.getCountries();

        $(".countries").on("change", function () {
            const countryId = $("option:selected", this).attr("countryid");
            if (countryId) loc.getStates(countryId);
            else $(".states option:gt(0), .cities option:gt(0)").remove();
        });

        $(".states").on("change", function () {
            const stateId = $("option:selected", this).attr("stateid");
            if (stateId) loc.getCities(stateId);
            else $(".cities option:gt(0)").remove();
        });
    });

    // Multi-Step Form Logic
    $(document).ready(function () {
        let currentStep = 1;

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
            let isValid = true;
            $(".form-group").removeClass("has-error");
            $(".error-message").remove();

            if (step === 1) {
                if (!$("#name").val()) {
                    isValid = false;
                    showError("#name", "Please enter your name.");
                }
                if (!$("#phone").val()) {
                    isValid = false;
                    showError("#phone", "Please enter your phone number.");
                }
                if (!$("#email").val()) {
                    isValid = false;
                    showError("#email", "Please enter your email address.");
                }
            } else if (step === 2) {
                if (!$("#country").val()) {
                    isValid = false;
                    showError("#country", "Please select your country.");
                }
                if (!$("#state").val()) {
                    isValid = false;
                    showError("#state", "Please select your state.");
                }
                if (!$("#city").val()) {
                    isValid = false;
                    showError("#city", "Please select your city.");
                }
            } else if (step === 3) {
                if (!$("#message").val()) {
                    isValid = false;
                    showError("#message", "Please enter a message.");
                }
            }

            return isValid;
        }

        function showError(selector, message) {
            $(selector).closest(".form-group").addClass("has-error");
            $(selector).after(`<div class="error-message">${message}</div>`);
        }
    });
</script>

@endpush

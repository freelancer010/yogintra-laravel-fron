@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Yogintra service details')
@section('meta_description', 'Yogintra service details')
@section('meta_keywords', '')

@push('styles')
<style>
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }
    #conti_btn
    {
        display: none;
    }
    .calendar-frame {
        border: 2px solid #ccc; 
        padding: 20px; 
        border-radius: 10px; 
        background-color: #fff; 
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
        .sss {
        display: flex;
        justify-content: center;
        align-items: center;
    
    }
    .calendar {
        text-align: center;
        margin: 20px;
    }

    .date-picker {
        margin-bottom: 20px;
    }

    .time-slot {
        display: inline-block;
        padding: 1px 10px;
        margin: 5px;
        border: 1px solid #ccc;
        cursor: pointer;
        color:#000;
    }

    .selected {
        background-color: #007bff;
        color: #fff;
    }
    .date-picker input
    {
        display: none;
    }
    .am-service-gallery{
        min-height: 500px;
        background-position: center top;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .am-service-title {
        margin-left:20px;
    }
    .am-service-header {
        margin-bottom: 48px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 10px 30px;
        border-bottom: 2px solid #ccc;
    }
    .am-service-image {
        display: inline-block;
        vertical-align: middle;
        border-radius: 50%;
        width: 100%;
        max-width: 136px;
        height: 135px;
    }
    .am-service-data
    {
        display: inline-block;
        vertical-align: middle;
        padding: 0 16px;
        flex: 1;
        width: 100%;
        margin-bottom:50px;
    }
    .am-service-image img
    {
        width: 100%;
        border-radius: 50%;
        height: 100%;
    }
    .am-service {
        background: #fff;
        background-color: rgb(255, 255, 255);
        margin: -180px auto 50px auto;
        position: relative;
        padding: 25px;
        z-index: 3;
        box-shadow: 0 10px 10px #99680750;
        border-radius: 20px;
        width: 60%;
    }
    
    .am-service-price {
        font-size: 26px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #f9c347, #ffb347);
        color: #ffffff;
        box-shadow: 0 4px 6px #00000090;
        border-radius: 0 20px 0 31px;
        font-weight: bold;
        font-family: sans-serif;
        letter-spacing: 1px;
        position: absolute;
        top: 0;
        right: 0;
        text-align: center;
    }

    .am-data i {
        text-align: center;
        padding: 30px;
        background: var(--theme-color-2) !important;
        color: #ffffff;
        border-radius: 50%;
        font-size: 25px;
    }

    @media (max-width: 768px) {
        .am-service {
            padding: 16px;
            width: 90%;
        }
    }

    @media only screen and (max-width: 600px) {
        .am-service-header
        {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg8.jpg') }}'); background-position: 50% -47px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title text-white">{{ \Illuminate\Support\Str::limit($service->service_name, 50) }}</h2>
                    <ol class="breadcrumb text-center mt-10">
                        <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li><a class="text-white" href="{{ url('/service/' . $service->service_cat_slug) }}">{{ $service->service_cat_name }}</a></li>
                        <li class="active text-gray">{{ $service->service_name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Description Intro -->
<div class="container">
    <div class="section-title text-center pb-0 pt-50">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="mt-0 line-height-3 text-center">
                    YogIntra provides One of the Best 
                    <span class="text-theme-colored2">{{ $service->service_cat_name }}</span> 
                    in India with our expertise, professional and experienced team of Trainers.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Service Content -->
<div class="">
    <div class="section-title pb-0 pt-0">
        <div class="row">
            <div class="am-service-gallery" style="background-image: url('{{ asset('assets/service_details.webp')}}')" alt="{{ $service->service_name }}"></div>
            <div class="am-service">
                <div class="row">
                    <div class="am-service-header">
                        <div class="am-service-image">
                            <img class="" src="{{ asset($service->service_image) }}" alt="{{ $service->service_name }}">
                        </div>
                        <div class="am-service-title">
                            <h2 class="text-theme-colored line-bottom text-theme-colored mb-5 p-0">{{ $service->service_name }}</h2>
                        </div>
                    </div>
                    <div class="row text-center mt-5 am-service-data">
                        <div class="col-lg-4 mb-5 col-sm-6 col-xsm-12 am-data">
                            <i class="fa fa-users"></i><br>
                            <small>Capacity</small><br><strong>{{ $service->service_capacity }}</strong>
                        </div>
                        <div class="col-lg-4 mb-5 col-sm-6 col-xsm-12 am-data">
                            <i class="fa fa-clock-o"></i><br>
                            <small>Duration</small><br><strong>{{ $service->service_duration }} hr</strong>
                        </div>
                        <div class="col-lg-4 mb-5 col-sm-12 col-xsm-12 am-data">
                            <i class="fa fa-list"></i><br>
                            <small>Category</small><br><strong>{{ $service->service_cat_name }}</strong>
                        </div>
                    </div>
                    <div class="am-service-price">
                        INR {{ number_format($service->service_price) }}.00
                    </div>

                    <div class="text-center mb-50">
                        {!! $service->service_description !!}
                    </div>                    
                    <div class="col-md-12 mt-10 text-center mb-15">
                        <button class="btn btn-lg btn-warning" onclick="booking_modal()" style="border-radius: 30px;">Book Your Class</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book Now</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
            @include('components.multi-step-form', ['app_setting' => $app_setting])
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
$(function() {
    $(".date-picker").datepicker({
        onSelect: function(dateText, instance) {
            console.log("Selected date: " + dateText);
        }
    });
});

function booking_modal() {
  $('#booking_modal').modal('show');
}
  
function loadTimeSlots(e) {

    const dateInput = document.getElementById('date');
    const timeSlotsContainer = document.getElementById('time-slots');
    
    const selectedDate = dateInput.value;


    timeSlotsContainer.innerHTML = '';

    const openingTime = 7; 
    const closingTime = 19; 

    for (let hour = openingTime; hour <= closingTime; hour++) {
        const startTime = (hour % 12 === 0) ? 12 : hour % 12; // Convert to 12-hour format
        const amPm = (hour < 12) ? 'AM' : 'PM';
        const endTime = ((hour + 1) % 12 === 0) ? 12 : (hour + 1) % 12; // Convert to 12-hour format
        const timeSlot = document.createElement('div');
        timeSlot.className = 'time-slot';
        timeSlot.textContent = `${startTime} ${amPm} - ${endTime} ${amPm}`;
        
        timeSlot.addEventListener('click', () => selectTimeSlot(timeSlot));
        
        timeSlotsContainer.appendChild(timeSlot);
    }
}

function selectTimeSlot(selectedTimeSlot) {
    const timeSlots = document.querySelectorAll('.time-slot');
    timeSlots.forEach(slot => slot.classList.remove('selected'));

    selectedTimeSlot.classList.add('selected');
     $('#conti_btn').show();
}
</script>
@endpush

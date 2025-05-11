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
        min-height: 256px;
        background-image: linear-gradient(90deg, rgba(219, 164, 53, 0.65) 0%, #dba435 100%);
    }
    .am-service-header {
        position: relative;
        margin-bottom: 48px;
        display: flex;
        align-items: flex-start;
        justify-content: space-around;
    }
    .am-service-image {
        display: inline-block;
        vertical-align: middle;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        max-width: 100px;
    }
    .am-service-data
    {
        display: inline-block;
        vertical-align: middle;
        padding: 0 16px;
        flex: 1;
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
        margin: -60px 5% 0;
        position: relative;
        padding: 24px;
        z-index: 3;
    }
    .am-service-price {
        display: inline-block;
        position: absolute;
        top: 0;
        right: 0;
        padding: 16px 24px;
        border-radius: 30px;
        background-color: #dba435;
        color: #5c420e;
        font-size: 24px;
        line-height: 1.2;
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
<div class="container">
    <div class="section-title pb-0 pt-0">
        <div class="row">
            <div class="am-service-gallery"></div>
            <div class="am-service">
                <div class="row">
                    <div class="am-service-header">
                        <div class="am-service-image">
                            <img class="" src="{{ asset($service->service_image) }}" alt="{{ $service->service_name }}">
                        </div>
                        <div class="am-service-data">
                            <h2 class="text-theme-colored line-bottom text-theme-colored mb-5">{{ $service->service_name }}</h2>
                            <div class="mt-0">
                                <span class="text-theme-colored2">Capacity :</span> {{ $service->service_capacity }} | 
                                <span class="text-theme-colored2">Duration :</span> {{ $service->service_duration }} hr
                            </div>
                        </div>
                        <div class="am-service-price">
                            INR {{ number_format($service->service_price) }}.00
                        </div>
                    </div>

                    <div class="text-center mb-50">
                        {!! $service->service_description !!}
                    </div>

                    <div>
                        <table class="table borderless">
                            <tr>
                                <td width="30%">Category :</td>
                                <td>{{ $service->service_cat_name }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Duration :</td>
                                <td>{{ $service->service_duration }} hr</td>
                            </tr>
                            <tr>
                                <td width="30%">Capacity :</td>
                                <td>{{ $service->service_capacity }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12 mt-10 text-center">
                        <button class="btn btn-success" onclick="booking_modal()">Book Now</button>
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
                <form id="multi-step-form" method="post">
                    <!-- Step 1 -->
                    <div class="form-step active" id="step-1">
                        <div class="form-group">
                            <label for="name">Your Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="text" class="form-control" name="number" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email ID:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <button class="btn btn-primary next" type="button">Next</button>
                    </div>

                    <!-- Step 2 -->
                    <div class="form-step" id="step-2">
                        <div class="form-group">
                            <label>Select Country:</label>
                            <select class="form-control countries" name="country" required>
                                <option value="">Select A Country</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select State:</label>
                            <select class="form-control states" name="state" required>
                                <option value="">Select your Country First</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select City:</label>
                            <select class="form-control cities" name="city" required>
                                <option value="">Select your State First</option>
                            </select>
                        </div>
                        <button class="btn btn-primary prev" type="button">Previous</button>
                        <button class="btn btn-primary next" type="button">Next</button>
                    </div>

                    <!-- Step 3 -->
                    <div class="form-step" id="step-3">
                        <input type="hidden" name="service" value="{{ $service->service_name }}">
                        <div class="form-group d-none">
                            <label>Call Request Time From:</label>
                            <input type="time" class="form-control" name="call-from">
                        </div>
                        <div class="form-group d-none">
                            <label>To:</label>
                            <input type="time" class="form-control" name="call-to">
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea class="form-control" name="message" rows="4" required></textarea>
                        </div>
                        <button class="btn btn-primary prev" type="button">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
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

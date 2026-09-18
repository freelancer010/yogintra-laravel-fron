@php
    use Illuminate\Support\Str;

    $serviceDescription = trim(preg_replace('/\s+/', ' ', strip_tags($service->service_description ?? '')));
    $serviceMetaDescription = Str::limit($serviceDescription ?: $service->service_name, 160, '');
@endphp

@extends('layouts.layout')

@section('meta_title', $service->service_name)
@section('meta_description', $serviceMetaDescription)
@section('meta_keywords', $service->service_name . ', yoga service, YogIntra')

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
        min-height: 420px;
        background-position: center top;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .am-service-title {
        margin-left:20px;
    }
    .am-service-header {
        margin-bottom: 34px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 4px 4px 25px;
        border-bottom: 1px solid #dbe7e8;
    }
    .am-service-image {
        display: inline-block;
        vertical-align: middle;
        border-radius: 50%;
        width: 100%;
        max-width: 112px;
        height: 112px;
        padding: 5px;
        background: #e7f5f5;
        box-shadow: 0 8px 18px rgba(15,124,135,.16);
    }
    .am-service-data
    {
        display: inline-block;
        vertical-align: middle;
        padding: 0 16px;
        flex: 1;
        width: 100%;
        margin-bottom:26px;
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
        width: min(920px, calc(100% - 32px));
        border: 1px solid #e4eeee;
    }
    
    .am-service-price {
        font-size: 21px;
        padding: 13px 22px;
        background: linear-gradient(135deg, #f2a12b, #db8506);
        color: #ffffff;
        box-shadow: 0 4px 6px #00000090;
        border-radius: 0 19px 0 18px;
        font-weight: bold;
        font-family: sans-serif;
        letter-spacing: 1px;
        position: static;
        text-align: center;
    }

    .am-data i {
        text-align: center;
        display: inline-flex;
        width: 76px;
        height: 76px;
        align-items: center;
        justify-content: center;
        padding: 0;
        background: var(--theme-color-2) !important;
        color: #ffffff;
        border-radius: 50%;
        font-size: 25px;
    }
    .service-intro { max-width:760px; margin:0 auto; color:#567078; font-size:17px; }
    .service-fact { padding:17px 10px; border:1px solid #e0edef; border-radius:12px; background:#fbfefe; transition:transform .18s ease, box-shadow .18s ease; }
    .service-fact:hover { transform:translateY(-3px); box-shadow:0 10px 20px rgba(19,78,86,.1); }
    .service-fact small { display:block; margin:10px 0 3px; color:#698087; font-weight:700; letter-spacing:.03em; }
    .service-fact strong { color:#17434c; font-size:16px; }
    .service-description { max-width:none; margin:0; padding:21px 22px; border-left:4px solid #0f7c87; border-radius:0 12px 12px 0; background:#f4fafb; color:#506b72; font-size:16px; line-height:1.8; text-align:left; }
    .service-description p { margin-bottom:14px; }
    .service-description p:last-child { margin-bottom:0; }
    .service-description-label { display:block; margin-bottom:8px; color:#0f6570; font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
    .service-book-button { min-width:174px; padding:13px 25px; border:0; border-radius:999px !important; background:#0f7c87 !important; color:#fff !important; font-weight:800; box-shadow:0 9px 18px rgba(15,124,135,.23); transition:transform .18s ease, box-shadow .18s ease; }
    .service-book-button:hover { background:#0b6570 !important; transform:translateY(-2px); box-shadow:0 12px 22px rgba(15,124,135,.3); }
    .service-purchase-layout { display:grid; grid-template-columns:minmax(0,1fr) 310px; gap:28px; align-items:start; }
    .service-purchase-details { display:grid; gap:24px; min-width:0; }
    .service-purchase-details .am-service-data { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; margin:0; }
    .service-purchase-details .am-service-data > [class*="col-"] { width:auto; max-width:none; margin:0 !important; padding:0; }
    .service-order-summary { padding:24px; border:1px solid #cfe3e6; border-radius:16px; background:linear-gradient(155deg,#f6fcfc,#fff); box-shadow:0 14px 28px rgba(16,76,85,.12); }
    .service-order-summary > small { display:block; margin-bottom:8px; color:#5b777e; font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
    .service-order-summary h3 { margin:0 0 18px; color:#153f49; font-size:19px; line-height:1.35; }
    .service-order-summary .am-service-price { display:block; margin:0 -25px 20px; border-radius:0; text-align:left; }
    .service-order-line { display:flex; justify-content:space-between; gap:12px; margin:10px 0; color:#58727a; font-size:13px; }
    .service-order-line strong { color:#183f48; text-align:right; }
    .service-order-summary hr { margin:18px 0; border:0; border-top:1px solid #dce8ea; }
    .service-order-summary .service-book-button { width:100%; margin-top:12px; }
    .service-secure-note { display:block; margin-top:14px; color:#698087; font-size:11px; line-height:1.5; text-align:center; }
    .service-trust-row { display:flex; flex-wrap:wrap; justify-content:center; gap:7px; margin-top:15px; }
    .service-trust-row span { padding:5px 8px; border-radius:999px; background:#e7f4f4; color:#17636d; font-size:10px; font-weight:800; }

    @media (max-width: 768px) {
        .inner-header { height:180px !important; background-position:center !important; }
        .inner-header .container { padding-top:35px !important; padding-bottom:25px !important; }
        .inner-header .title { margin:0; font-size:26px; line-height:1.2; }
        .service-page-intro { padding:24px 18px 4px; }
        .service-page-intro .section-title { padding-top:0 !important; }
        .service-intro { margin:0; font-size:15px; line-height:1.7; }
        .am-service {
            padding: 16px;
            width: calc(100% - 24px);
            margin:20px auto 32px;
        }
        .am-service-gallery { display:none; min-height:0; }
        .am-service-header { align-items:flex-start; gap:13px; margin-bottom:22px; padding-bottom:18px; }
        .am-service-image { flex:0 0 78px; width:78px; height:78px; }
        .am-service-title { margin-left:0; padding-top:7px; text-align:left; }
        .am-service-title h2 { font-size:26px; line-height:1.2; }
        .am-service-price { position:static; display:inline-block; margin:-3px 0 20px; border-radius:999px; }
        .service-purchase-layout { grid-template-columns:1fr; gap:20px; }
        .service-purchase-details .am-service-data { grid-template-columns:repeat(2, minmax(0, 1fr)); gap:14px; }
        .service-purchase-details .am-service-data > [class*="col-"] { float:none !important; width:100% !important; max-width:100% !important; }
        .service-purchase-details .am-service-data > :nth-child(1) { grid-column:1; }
        .service-purchase-details .am-service-data > :nth-child(2) { grid-column:2; }
        .service-purchase-details .am-service-data > :nth-child(3) { grid-column:1 / -1; }
        .service-fact { display:flex; min-height:170px; flex-direction:column; align-items:center; justify-content:center; padding:20px 12px; border-color:#d9e9eb; background:#fff; box-shadow:0 10px 20px rgba(20, 81, 90, .09); text-align:center; }
        .am-data i { width:58px; height:58px; font-size:20px; }
        .service-fact small { margin:9px 0 2px; }
        .service-fact strong { margin-top:0; font-size:18px; }
        .service-order-summary .am-service-price { margin:0 -25px 20px; border-radius:0; }
    }

    @media only screen and (max-width: 600px) {
        .am-service-header
        {
            flex-direction: row;
            align-items: center;
            text-align:left;
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
                    <h1 class="title text-white">{{ \Illuminate\Support\Str::limit($service->service_name, 50) }}</h1>
                    <ol class="breadcrumb text-center mt-10">
                        <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li><a class="text-white" href="{{ url($service->service_cat_slug) }}">{{ $service->service_cat_name }}</a></li>
                        <li class="active text-gray">{{ $service->service_name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Description Intro -->
<div class="container service-page-intro">
    <div class="section-title text-center pb-0 pt-50">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="mt-0 line-height-3 text-center service-intro">
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
                    <div class="service-purchase-layout">
                    <div class="service-purchase-details">
                    <div class="row text-center mt-5 am-service-data">
                        <div class="col-lg-4 mb-5 col-sm-6 col-xsm-12 am-data service-fact">
                            <i class="fa fa-users"></i><br>
                            <small>Capacity</small><br><strong>{{ $service->service_capacity }}</strong>
                        </div>
                        <div class="col-lg-4 mb-5 col-sm-6 col-xsm-12 am-data service-fact">
                            <i class="fa fa-clock-o"></i><br>
                            <small>Duration</small><br><strong>{{ $service->service_duration }} hr</strong>
                        </div>
                        <div class="col-lg-4 mb-5 col-sm-12 col-xsm-12 am-data service-fact">
                            <i class="fa fa-list"></i><br>
                            <small>Category</small><br><strong>{{ $service->service_cat_name }}</strong>
                        </div>
                    </div>
                    <div class="service-description">
                        <span class="service-description-label">About this service</span>
                        {!! app(\App\Support\HtmlSanitizer::class)->sanitize($service->service_description) !!}
                    </div>
                    </div>
                    <aside class="service-order-summary" aria-label="Booking summary">
                        <small>Your booking</small>
                        <h3>{{ $service->service_name }}</h3>
                        <div class="am-service-price">INR {{ number_format($service->service_price) }}.00</div>
                        <div class="service-order-line"><span>Duration</span><strong>{{ $service->service_duration }} hr</strong></div>
                        <div class="service-order-line"><span>Category</span><strong>{{ $service->service_cat_name }}</strong></div>
                        <hr>
                        <div class="service-order-line"><span>Total payable</span><strong>INR {{ number_format($service->service_price) }}.00</strong></div>
                        <button class="btn btn-lg btn-warning service-book-button" onclick="booking_modal()">Continue to booking</button>
                        <small class="service-secure-note"><i class="fa fa-lock" aria-hidden="true"></i> Secure booking. You will confirm your details before payment.</small>
                        <div class="service-trust-row"><span>Flexible scheduling</span><span>Booking support</span></div>
                    </aside>
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

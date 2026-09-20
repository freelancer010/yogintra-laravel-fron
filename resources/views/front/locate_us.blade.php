@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'locate YogIntra- Home Yoga and Online Yoga Classes Across India')
@section('meta_description', 'Find Home Yoga and Corporate Yoga Classes near you across India. Discover all our Yoga Trainer\'s in Mumbai, Delhi, Bangalore, Pune and more cities' )
@section('meta_keywords', 'Home Yoga, Online Yoga, Corporate Yoga, 1 to 1 Yoga, Private Yoga, Yoga Trainers, Female Yoga Trainers, Yoga near me, YogaIntra Locations, Yoga Classes in India, Best Yoga Centers, Yoga Studios' )

@push('styles')
<style>
    .locate-us-section {
        padding: 60px 0;
    }

    .cities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 60px;
    }

    .city-card {
        background: linear-gradient(135deg, #176a71 0%, #0f4651 100%);
        color: white;
        padding: 25px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80px;
    }

    .city-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(23, 106, 113, 0.3);
        text-decoration: none;
        color: white;
    }

    .city-card span {
        font-size: 22px;
        font-weight: 500;
    }

    .center-card {
        transition: all 0.3s ease;
        height: 100%;
    }

    .center-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .center-image {
        height: 300px;
        overflow: hidden;
        position: relative;
    }

    .center-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .center-card:hover .center-image img {
        transform: scale(1.05);
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .center-card:hover .overlay {
        opacity: 1;
    }

    .overlay a {
        display: inline-block;
        width: 60px;
        height: 60px;
        background-color: #176a71;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        transition: background-color 0.3s ease;
    }

    .overlay a:hover {
        background-color: #0f4651;
        text-decoration: none;
    }

    .location-heading {
        font-size: 36px;
        font-weight: 600;
        color: #222;
        margin-bottom: 40px;
        text-align: center;
        position: relative;
    }

    .location-heading::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #176a71;
    }

    .locate-us-section.container {
        padding: 30px 0;
    }
    .section-subtitle {
        font-size: 18px;
        color: #666;
        margin-top: 30px;
        margin-bottom: 40px;
        text-align: center;
    }

    .center-info {
        padding: 20px;
    }

    .center-name {
        font-size: 18px;
        font-weight: 600;
        color: #222;
        margin-bottom: 10px;
    }

    .center-contact {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
    }

    .center-contact i {
        color: #176a71;
        width: 20px;
        margin-right: 8px;
    }

    .btn-details {
        background-color: #176a71;
        color: white;
        padding: 8px 20px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .btn-details:hover {
        background-color: #0f4651;
        text-decoration: none;
    }

    .no-centers {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    @media (max-width: 768px) {
        .location-heading {
            font-size: 24px;
        }

        .center-image {
            height: 250px;
        }

        .cities-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .city-card {
            padding: 15px;
            min-height: 70px;
        }

        .city-card span {
            font-size: 14px;
        }
    }

    .locate-us-section { padding: 78px 0 88px; background: linear-gradient(180deg, #f6fbfa 0%, #fff 100%); }
    .location-intro { max-width: 760px; margin: 0 auto 42px; }
    .location-eyebrow { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 13px; color: #14757d; font-size: 12px; font-weight: 800; letter-spacing: .11em; text-transform: uppercase; }
    .location-eyebrow i { font-size: 15px; }
    .location-heading { margin-bottom: 16px; color: #084451; font-size: 38px; font-weight: 800; line-height: 1.22; }
    .location-heading::after { display: none; }
    .section-subtitle { max-width: 650px; margin: 0 auto; color: #55737a; font-size: 16px; line-height: 1.7; }
    .cities-grid { grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 18px; margin: 0; }
    .city-card { min-height: 142px; padding: 24px; align-items: flex-start; justify-content: flex-start; flex-direction: column; border: 1px solid #d8e9e8; border-radius: 0; background: #fff; color: #084451; box-shadow: 0 8px 22px rgba(8, 68, 81, .07); }
    .city-card-icon { display: flex; align-items: center; justify-content: center; width: 42px; height: 42px; margin-bottom: 15px; color: #fff; background: #14757d; font-size: 19px; }
    .city-card-title { color: #084451; font-size: 19px; font-weight: 800; line-height: 1.25; }
    .city-card-landmark { display: block; margin-top: 5px; color: #6d858b; font-size: 12px; line-height: 1.35; }
    .city-card .city-card-action { display: block; margin-top: auto; color: #14757d; font-size: 12px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
    .city-card .city-card-action::after { content: ' \f178'; font-family: FontAwesome; }
    .city-card:hover, .city-card:focus { color: #084451; transform: translateY(-4px); border-color: #14757d; box-shadow: 0 14px 28px rgba(8, 68, 81, .14); }
    .city-card:hover .city-card-title, .city-card:focus .city-card-title { color: #084451; }
    .no-locations { max-width: 680px; margin: 0 auto; padding: 30px; border: 1px dashed #adcfd0; color: #55737a; text-align: center; }
    @media (max-width: 768px) { .locate-us-section { padding: 52px 0 62px; }.location-heading { font-size: 29px; }.cities-grid { grid-template-columns: 1fr; gap: 14px; }.city-card { min-height: 128px; }.city-card span { font-size: 18px; } }
</style>
@endpush

@section('content')

<!-- Section: Inner Header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="title text-white">Locate Us</h1>
                    <ol class="breadcrumb text-center text-black mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="active text-gray">Locate Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Cities -->
<section class="locate-us-section">
    <div class="container">
        <div class="section-content">
            <div class="location-intro text-center">
                <p class="location-eyebrow"><i class="fa fa-map-marker" aria-hidden="true"></i> Find YogIntra near you</p>
                <h2 class="location-heading">Yoga Guidance, Wherever You Are</h2>
                <p class="section-subtitle">Explore YogIntra’s city pages to discover home yoga, online classes, corporate programmes, and local wellness support available near you.</p>
            </div>

            @if($all_landing_page && count($all_landing_page) > 0)
                @php
                    $cityLandmarks = [
                        'mumbai' => ['Gateway of India', 'fa-ship'],
                        'delhi' => ['India Gate', 'fa-university'],
                        'new-delhi' => ['India Gate', 'fa-university'],
                        'bangalore' => ['Bengaluru Palace', 'fa-building-o'],
                        'bengaluru' => ['Bengaluru Palace', 'fa-building-o'],
                        'pune' => ['Shaniwar Wada', 'fa-university'],
                        'chennai' => ['Marina Beach', 'fa-ship'],
                        'hyderabad' => ['Charminar', 'fa-university'],
                        'kolkata' => ['Victoria Memorial', 'fa-university'],
                        'jaipur' => ['Hawa Mahal', 'fa-building-o'],
                        'ahmedabad' => ['Sabarmati Ashram', 'fa-home'],
                        'noida' => ['Okhla Bird Sanctuary', 'fa-tree'],
                        'gurgaon' => ['Kingdom of Dreams', 'fa-building-o'],
                        'gurugram' => ['Kingdom of Dreams', 'fa-building-o'],
                        'lucknow' => ['Bara Imambara', 'fa-university'],
                        'indore' => ['Rajwada Palace', 'fa-building-o'],
                        'kochi' => ['Fort Kochi', 'fa-ship'],
                    ];
                @endphp
                <div class="cities-grid">
                    @foreach ($all_landing_page as $city)
                        @php
                            $cityKey = Str::slug($city->page_name);
                            $landmark = $cityLandmarks[$cityKey] ?? ['YogIntra local services', 'fa-map-marker'];
                        @endphp
                        <a href="{{ url('city/' . $city->page_slug) }}" class="city-card" aria-label="Explore YogIntra services in {{ $city->page_name }}">
                            <span class="city-card-icon" aria-hidden="true"><i class="fa {{ $landmark[1] }}"></i></span>
                            <span class="city-card-title">{{ $city->page_name }}</span>
                            <small class="city-card-landmark">{{ $landmark[0] }}</small>
                            <small class="city-card-action">Explore services</small>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="no-locations">New YogIntra locations are being added. Please contact us to find the best class or instructor for you.</p>
            @endif
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Add smooth scroll behavior
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.city-card');
        cards.forEach((card, index) => {
            card.style.animation = `fadeInUp 0.6s ease ${index * 0.05}s forwards`;
        });

        const centerCards = document.querySelectorAll('.center-card');
        centerCards.forEach((card, index) => {
            card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s forwards`;
        });
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

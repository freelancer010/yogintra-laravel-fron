@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Locate YogIntra - Yoga Centers Across India')
@section('meta_description', 'Find YogIntra yoga centers and classes near you across India. Discover all our yoga training centers in Mumbai, Delhi, Bangalore, Pune and more cities.')
@section('meta_keywords', 'Yoga centers near me, YogIntra locations, Yoga classes in India, Best yoga centers, Yoga studios')

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

    .container {
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
            <div class="row mb-40">
                <div class="col-md-12">
                    <h2 class="location-heading">Our Service Locations</h2>
                    <p class="section-subtitle">
                        Discover YogIntra's presence across multiple cities in India. Click on any city to explore our services and offerings in that location.
                    </p>
                </div>
            </div>

            @if($all_landing_page && count($all_landing_page) > 0)
                <div class="cities-grid">
                    @foreach ($all_landing_page as $city)
                        <a href="{{ url('city/' . $city->page_slug) }}" class="city-card">
                            <span>{{ $city->page_name }}</span>
                        </a>
                    @endforeach
                </div>
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


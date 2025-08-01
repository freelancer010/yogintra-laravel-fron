@extends('layouts.layout')

@section('meta_title', $trainer['name'] . ' - Personal Yoga Trainer')
@section('meta_description', 'Meet ' . $trainer['name'] . ', a certified personal yoga trainer in ' . $trainer['city'] . ', ' . $trainer['state'] . '. Learn about their experience, education, and available yoga packages.')
@section('meta_keywords', $trainer['name'] . ', yoga trainer, personal yoga instructor, yoga trainer in ' . $trainer['city'] . ', Yoga Trainers, Certified Yoga Instructors, Experienced Yoga Teachers, Best Yoga Trainers in India, Professional Yoga Coaches, Yoga Near me, Best Yoga Instructors, Yoga Expert, Male Yoga Trainers, Female Yoga Trainers, Yoga Instructors for Men, Yoga Teachers for Women, Yoga Trainers in Mumbai, Yoga Trainers in Delhi, Yoga Trainers in Pune, Yoga Trainers in Bangalore, Yoga Trainers in Noida, Yoga Trainers Near me')
@section('og_image', $api . '/' . $trainer['profile_image'])

@section('content')
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg8.jpg') }}'); height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="title text-white">Trainer Profile</h2>
          <ol class="breadcrumb text-center mt-10">
            <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
            <li><a class="text-white" href="{{ url('/trainers') }}">Trainers</a></li>
            <li class="active text-gray">{{ $trainer['name'] }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced Trainer Profile Section -->
<section class="trainer-profile-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
  <div class="container">
    <!-- Main Profile Card -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-12">
        <div class="trainer-profile-card shadow-lg">
          <div class="row g-0">
            <!-- Profile Image -->
            <div class="col-md-4">
              <div class="profile-image-container">
                <img src="{{ $api }}/{{ $trainer['profile_image'] }}" alt="{{ $trainer['name'] }}" class="profile-image">
                <div class="profile-badge">
                  <i class="fa fa-star"></i>
                  <span>Certified</span>
                </div>
              </div>
            </div>
            
            <!-- Profile Info -->
            <div class="col-md-8">
              <div class="profile-content">
                <div class="profile-header">
                  <h1 class="trainer-name">{{ $trainer['name'] }}</h1>
                  <p class="trainer-subtitle">Professional Yoga Instructor</p>
                </div>
                
                <div class="profile-stats">
                  <div class="row">
                    <div class="col-6 col-md-3">
                      <div class="stat-item">
                        <div class="stat-icon age-icon">
                          <i class="fa fa-birthday-cake"></i>
                        </div>
                        <div class="stat-content">
                          <span class="stat-value">{{ $age }}</span>
                          <span class="stat-label">Years Old</span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-6 col-md-3">
                      <div class="stat-item">
                        <div class="stat-icon experience-icon">
                          <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="stat-content">
                          <span class="stat-value">{{ $trainer['experience'] }}</span>
                          <span class="stat-label">Experience</span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-6 col-md-3">
                      <div class="stat-item">
                        <div class="stat-icon education-icon">
                          <i class="fa fa-graduation-cap"></i>
                        </div>
                        <div class="stat-content">
                          <span class="stat-value">Certified</span>
                          <span class="stat-label">Education</span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-6 col-md-3">
                      <div class="stat-item">
                        <div class="stat-icon location-icon">
                          <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="stat-content">
                          <span class="stat-value">{{ $trainer['city'] }}</span>
                          <span class="stat-label">{{ $trainer['state'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Details Cards -->
    <div class="row">
      <!-- Education Card -->
      <div class="col-md-6 mb-4">
        <div class="detail-card h-100">
          <div class="card-header">
            <i class="fa fa-graduation-cap card-icon"></i>
            <h4>Education & Qualification</h4>
          </div>
          <div class="card-body">
            <p class="education-text">{{ strtolower($trainer['Education']) }}</p>
            <div class="qualification-badges">
              <span class="badge certification-badge">
                <i class="fa fa-certificate"></i> Certified Instructor
              </span>
              <span class="badge yoga-badge">
                <i class="fa fa-leaf"></i> Yoga Specialist
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Package Card -->
      <div class="col-md-6 mb-4">
        <div class="detail-card h-100">
          <div class="card-header">
            <i class="fa fa-gift card-icon"></i>
            <h4>Training Package</h4>
          </div>
          <div class="card-body">
            <div class="package-info">
              <div class="package-price">
                <span class="price-text">{{ $trainer['package'] }}</span>
              </div>
              <p class="package-description">
                Personalized yoga sessions tailored to your fitness level and goals.
              </p>
              <ul class="package-features">
                <li><i class="fa fa-check"></i> One-on-one training</li>
                <li><i class="fa fa-check"></i> Customized workout plans</li>
                <li><i class="fa fa-check"></i> Flexible scheduling</li>
                <li><i class="fa fa-check"></i> Progress tracking</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="cta-section text-center">
          <h3 class="cta-title">Ready to Start Your Yoga Journey?</h3>
          <p class="cta-subtitle">Book a session with {{ $trainer['name'] }} and transform your wellness routine</p>
          
          <div class="cta-buttons">
            <a href="{{ url('/contact') }}" class="btn btn-primary btn-book">
              <i class="fa fa-calendar-check-o"></i> 
              <span>Book a Session</span>
            </a>
            <a href="{{ url('/trainers') }}" class="btn btn-primary btn-browse">
              <i class="fa fa-arrow-left"></i>
              <span>Browse Other Trainers</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
  /* Main Profile Card */
  .trainer-profile-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  /* Profile Image */
  .profile-image-container {
    position: relative;
    height: 100%;
    min-height: 400px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .profile-image {
    width: 100%;
    max-width: 280px;
    height: 350px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #ddd;
  }

  .profile-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #FF8C00;
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
  }

  /* Profile Content */
  .profile-content {
    padding: 40px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .profile-header {
    margin-bottom: 30px;
    text-align: left;
  }

  .trainer-name {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
  }

  .trainer-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
    font-weight: 500;
    margin: 0;
  }

  /* Profile Stats */
  .profile-stats {
    margin-top: 20px;
  }

  .stat-item {
    text-align: center;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 20px;
    color: white;
  }

  .age-icon { background: #FF8C00; }
  .experience-icon { background: #FF7F50; }
  .education-icon { background: #FFA500; }
  .location-icon { background: #FF6347; }

  .stat-content {
    text-align: center;
    width: 100%;
  }

  .stat-value {
    display: block;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.2;
    margin-bottom: 2px;
  }

  .stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
    display: block;
  }

  /* Detail Cards */
  .detail-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .detail-card .card-header {
    background: #f8f9fa;
    color: #2c3e50;
    padding: 20px;
    border: none;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .card-icon {
    font-size: 24px;
    color: #FF8C00;
  }

  .detail-card h4 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
  }

  .detail-card .card-body {
    padding: 25px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 200px;
  }

  .education-text {
    font-size: 1.1rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 500;
  }

  .qualification-badges {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: auto;
  }

  .certification-badge {
    background: #FF8C00;
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    border: none;
    font-weight: 500;
  }

  .yoga-badge {
    background: #FFA500;
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    border: none;
    font-weight: 500;
  }

  /* Package Info */
  .package-info {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .package-price {
    margin-bottom: 15px;
  }

  .price-text {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FF8C00;
  }

  .package-description {
    color: #6c757d;
    margin-bottom: 20px;
    line-height: 1.6;
  }

  .package-features {
    list-style: none;
    padding: 0;
    margin: 0;
    margin-top: auto;
  }

  .package-features li {
    padding: 6px 0;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .package-features .fa-check {
    color: #FF8C00;
    font-weight: bold;
  }

  /* Call to Action */
  .cta-section {
    background: white;
    padding: 50px 40px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    margin-top: 40px;
    text-align: center;
  }

  .cta-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
    line-height: 1.3;
  }

  .cta-subtitle {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 40px;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    align-items: center;
  }

  .btn-book {
    background: #FF8C00;
    border: none;
    padding: 15px 30px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 25px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    min-width: 200px;
  }

  .btn-book:hover {
    background: #e07b00;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
  }

  .btn-browse {
    background: transparent;
    border: 2px solid #FF8C00;
    color: #FF8C00;
    padding: 15px 30px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    min-width: 200px;
  }

  .btn-browse:hover {
    background: #FF8C00;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .trainer-name {
      font-size: 2rem;
      text-align: center;
    }

    .profile-header {
      text-align: center;
    }

    .profile-content {
      padding: 30px 20px;
    }

    .profile-image-container {
      min-height: 300px;
    }

    .profile-image {
      height: 250px;
    }

    .cta-section {
      padding: 40px 25px;
      margin-top: 30px;
    }

    .cta-title {
      font-size: 1.6rem;
      margin-bottom: 15px;
    }

    .cta-subtitle {
      margin-bottom: 30px;
      font-size: 0.95rem;
    }

    .cta-buttons {
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    .btn-book, .btn-browse {
      width: 100%;
      max-width: 280px;
      justify-content: center;
      padding: 14px 25px;
    }

    .qualification-badges {
      justify-content: center;
    }

    .profile-stats .row {
      text-align: center;
    }
  }

  @media (max-width: 576px) {
    .profile-stats .col-6 {
      margin-bottom: 20px;
    }

    .stat-item {
      margin-bottom: 10px;
    }

    .cta-section {
      padding: 30px 20px;
    }

    .cta-title {
      font-size: 1.4rem;
    }

    .detail-card .card-body {
      padding: 20px;
    }

    .btn-book, .btn-browse {
      padding: 12px 20px;
      font-size: 0.95rem;
    }
  }

  /* Grid alignment fixes */
  .row.g-0 {
    margin: 0;
  }

  .row.g-0 > * {
    padding: 0;
  }

  .profile-stats .row > div {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Ensure equal height cards */
  .row.mb-4 {
    display: flex;
    align-items: stretch;
  }

  .row.mb-4 > div {
    display: flex;
  }

  /* Ensure cards in the details row have equal heights */
  .detail-card {
    min-height: 280px;
  }
</style>
@endpush

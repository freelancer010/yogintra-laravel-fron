@extends('layouts.amp-layout')

@section('meta_title', 'YogIntra - Professional Yoga Training & Wellness Center')
@section('meta_description', 'Transform your life with professional yoga training at YogIntra. Expert instructors, personalized programs, and holistic wellness approach.')
@section('meta_keywords', 'yoga training, yoga classes, wellness center, meditation, fitness, health, Mumbai yoga')

@section('content')
<!-- Hero Section -->
<section class="amp-hero">
    <div class="container">
        <h1>Transform Your Life with Yoga</h1>
        <p>Professional yoga training and wellness programs designed for your journey to better health and inner peace.</p>
        <a href="#contact" class="amp-btn">Start Your Journey</a>
    </div>
</section>

<!-- About Section -->
<section class="amp-section">
    <div class="container">
        <h2>Welcome to YogIntra</h2>
        <p>At YogIntra, we believe yoga is more than just physical exercise—it's a pathway to holistic wellness. Our experienced instructors guide you through personalized yoga programs that cater to your individual needs and goals.</p>
        
        <div class="amp-grid">
            <div class="amp-card">
                <amp-img src="{{ asset('assets/front/images/yoga-1.jpg') }}" 
                         alt="Hatha Yoga" 
                         width="300" 
                         height="200">
                </amp-img>
                <h3>Hatha Yoga</h3>
                <p>Perfect for beginners, focusing on basic postures and breathing techniques.</p>
            </div>
            
            <div class="amp-card">
                <amp-img src="{{ asset('assets/front/images/yoga-2.jpg') }}" 
                         alt="Vinyasa Yoga" 
                         width="300" 
                         height="200">
                </amp-img>
                <h3>Vinyasa Yoga</h3>
                <p>Dynamic flow sequences that build strength and flexibility.</p>
            </div>
            
            <div class="amp-card">
                <amp-img src="{{ asset('assets/front/images/yoga-3.jpg') }}" 
                         alt="Meditation" 
                         width="300" 
                         height="200">
                </amp-img>
                <h3>Meditation</h3>
                <p>Mindfulness practices for mental clarity and emotional balance.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="amp-section" style="background: #f8f9fa;">
    <div class="container">
        <h2>Our Services</h2>
        <div class="amp-grid">
            <div class="amp-card">
                <h3>Personal Training</h3>
                <p>One-on-one sessions tailored to your specific needs and goals.</p>
            </div>
            
            <div class="amp-card">
                <h3>Group Classes</h3>
                <p>Join our community in energizing group yoga sessions.</p>
            </div>
            
            <div class="amp-card">
                <h3>Online Sessions</h3>
                <p>Practice yoga from the comfort of your home with our virtual classes.</p>
            </div>
            
            <div class="amp-card">
                <h3>Workshops</h3>
                <p>Deep-dive into specific aspects of yoga with our specialized workshops.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="amp-section" id="contact">
    <div class="container">
        <h2>Get In Touch</h2>
        <form method="post" 
              action-xhr="{{ route('contact.submit') }}" 
              class="amp-form">
            @csrf
            
            <div class="amp-form-group">
                <label for="name">Full Name *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       required>
            </div>
            
            <div class="amp-form-group">
                <label for="email">Email Address *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       required>
            </div>
            
            <div class="amp-form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       required>
            </div>
            
            <div class="amp-form-group">
                <label for="service">Interested Service</label>
                <select id="service" name="service">
                    <option value="">Select a service</option>
                    <option value="personal-training">Personal Training</option>
                    <option value="group-classes">Group Classes</option>
                    <option value="online-sessions">Online Sessions</option>
                    <option value="workshops">Workshops</option>
                </select>
            </div>
            
            <div class="amp-form-group">
                <label for="message">Message</label>
                <textarea id="message" 
                          name="message" 
                          placeholder="Tell us about your yoga goals and any specific requirements..."></textarea>
            </div>
            
            <input type="hidden" name="source" value="AMP Homepage">
            
            <button type="submit" class="amp-submit-btn">Send Message</button>
            
            <!-- Success Response -->
            <div submit-success>
                <template type="amp-mustache">
                    <div class="amp-success">
                        <p>Thank you for your message! We'll get back to you within 24 hours.</p>
                    </div>
                </template>
            </div>
            
            <!-- Error Response -->
            <div submit-error>
                <template type="amp-mustache">
                    <div class="amp-error">
                        <p>Sorry, there was an error sending your message. Please try again or call us directly.</p>
                    </div>
                </template>
            </div>
        </form>
        
        <div style="text-align: center; margin-top: 30px;">
            <p><strong>Call Us:</strong> <a href="tel:+919867291573">+91-9867291573</a></p>
            <p><strong>Email:</strong> <a href="mailto:support@yogintra.com">support@yogintra.com</a></p>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="amp-section" style="background: #ffd700; color: #333;">
    <div class="container">
        <h2>Why Choose YogIntra?</h2>
        <div class="amp-grid">
            <div class="amp-card" style="background: rgba(255,255,255,0.9);">
                <h3>Certified Instructors</h3>
                <p>Learn from experienced, certified yoga professionals with years of practice.</p>
            </div>
            
            <div class="amp-card" style="background: rgba(255,255,255,0.9);">
                <h3>Personalized Approach</h3>
                <p>Every program is tailored to your individual needs and fitness level.</p>
            </div>
            
            <div class="amp-card" style="background: rgba(255,255,255,0.9);">
                <h3>Holistic Wellness</h3>
                <p>We focus on physical, mental, and spiritual well-being.</p>
            </div>
            
            <div class="amp-card" style="background: rgba(255,255,255,0.9);">
                <h3>Flexible Scheduling</h3>
                <p>Choose from various time slots that fit your busy lifestyle.</p>
            </div>
        </div>
    </div>
</section>
@endsection

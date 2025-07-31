@extends('layouts.amp-layout')

@section('meta_title', 'Contact YogIntra - Get in Touch for Yoga Training')
@section('meta_description', 'Contact YogIntra for personalized yoga training, group classes, and wellness programs. Call +91-9867291573 or fill our contact form.')
@section('meta_keywords', 'contact yoga instructor, yoga training Mumbai, yoga classes booking, wellness consultation')

@section('content')
<!-- Contact Hero Section -->
<section class="amp-hero" style="background: linear-gradient(135deg, #333 0%, #555 100%); color: #fff;">
    <div class="container">
        <h1>Contact YogIntra</h1>
        <p>Ready to start your yoga journey? Get in touch with our expert instructors today.</p>
    </div>
</section>

<!-- Contact Information -->
<section class="amp-section">
    <div class="container">
        <h2>Get In Touch</h2>
        
        <div class="amp-grid">
            <div class="amp-card">
                <h3>📞 Call Us</h3>
                <p><strong>Phone:</strong> <a href="tel:+919867291573">+91-9867291573</a></p>
                <p>Available: Monday to Sunday<br>6:00 AM - 8:00 PM</p>
            </div>
            
            <div class="amp-card">
                <h3>✉️ Email Us</h3>
                <p><strong>Email:</strong> <a href="mailto:support@yogintra.com">support@yogintra.com</a></p>
                <p>We respond within 24 hours</p>
            </div>
            
            <div class="amp-card">
                <h3>📍 Location</h3>
                <p><strong>Service Area:</strong> Mumbai & Surrounding Areas</p>
                <p>Home visits and studio classes available</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="amp-section" style="background: #f8f9fa;">
    <div class="container">
        <h2>Send Us a Message</h2>
        <form method="post" 
              action-xhr="{{ route('form.submit') }}" 
              class="amp-form">
            @csrf
            
            <div class="amp-form-group">
                <label for="name">Full Name *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       required
                       placeholder="Enter your full name">
            </div>
            
            <div class="amp-form-group">
                <label for="email">Email Address *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       required
                       placeholder="Enter your email address">
            </div>
            
            <div class="amp-form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       required
                       placeholder="Enter your phone number">
            </div>
            
            <div class="amp-form-group">
                <label for="service">Interested Service</label>
                <select id="service" name="service">
                    <option value="">Select a service</option>
                    <option value="personal-training">Personal Training</option>
                    <option value="group-classes">Group Classes</option>
                    <option value="online-sessions">Online Sessions</option>
                    <option value="workshops">Workshops</option>
                    <option value="teacher-training">Teacher Training Course</option>
                    <option value="corporate-yoga">Corporate Yoga</option>
                    <option value="therapy-yoga">Therapy Yoga</option>
                </select>
            </div>
            
            <div class="amp-form-group">
                <label for="experience">Yoga Experience Level</label>
                <select id="experience" name="experience">
                    <option value="">Select your level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                    <option value="instructor">Instructor</option>
                </select>
            </div>
            
            <div class="amp-form-group">
                <label for="location">Preferred Location</label>
                <select id="location" name="location">
                    <option value="">Select location</option>
                    <option value="home-visit">Home Visit</option>
                    <option value="studio">Studio</option>
                    <option value="online">Online</option>
                    <option value="outdoor">Outdoor</option>
                </select>
            </div>
            
            <div class="amp-form-group">
                <label for="message">Message</label>
                <textarea id="message" 
                          name="message" 
                          placeholder="Tell us about your yoga goals, any health conditions, preferred timings, or any specific requirements..."></textarea>
            </div>
            
            <input type="hidden" name="source" value="AMP Contact Page">
            
            <button type="submit" class="amp-submit-btn">Send Message</button>
            
            <!-- Success Response -->
            <div submit-success>
                <template type="amp-mustache">
                    <div class="amp-success">
                        <p><strong>Thank you for your message!</strong></p>
                        <p>We'll get back to you within 24 hours with detailed information about our yoga programs.</p>
                    </div>
                </template>
            </div>
            
            <!-- Error Response -->
            <div submit-error>
                <template type="amp-mustache">
                    <div class="amp-error">
                        <p><strong>Oops! Something went wrong.</strong></p>
                        <p>Please try again or call us directly at <a href="tel:+919867291573">+91-9867291573</a></p>
                    </div>
                </template>
            </div>
        </form>
    </div>
</section>

<!-- FAQ Section -->
<section class="amp-section">
    <div class="container">
        <h2>Frequently Asked Questions</h2>
        
        <div class="amp-grid">
            <div class="amp-card">
                <h3>Do you offer home visits?</h3>
                <p>Yes! We provide personalized yoga sessions at your home across Mumbai and surrounding areas.</p>
            </div>
            
            <div class="amp-card">
                <h3>What's included in a session?</h3>
                <p>Each session includes warm-up, yoga poses, breathing exercises, relaxation, and personalized guidance.</p>
            </div>
            
            <div class="amp-card">
                <h3>Do I need prior experience?</h3>
                <p>Not at all! We welcome complete beginners and tailor sessions to your current fitness level.</p>
            </div>
            
            <div class="amp-card">
                <h3>How long are the sessions?</h3>
                <p>Standard sessions are 60-90 minutes, but we can customize duration based on your needs.</p>
            </div>
            
            <div class="amp-card">
                <h3>What equipment do I need?</h3>
                <p>Just comfortable clothes! We provide yoga mats and any other necessary equipment.</p>
            </div>
            
            <div class="amp-card">
                <h3>Can I book online sessions?</h3>
                <p>Yes! We offer virtual yoga sessions via video call for your convenience.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="amp-section" style="background: #ffd700; color: #333;">
    <div class="container" style="text-align: center;">
        <h2>Ready to Start Your Yoga Journey?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 30px;">Join thousands who have transformed their lives with YogIntra</p>
        
        <div style="margin-bottom: 20px;">
            <a href="tel:+919867291573" class="amp-btn" style="background: #333; color: #fff; margin: 10px;">
                📞 Call Now
            </a>
            <a href="https://wa.me/919867291573" class="amp-btn" style="background: #25D366; color: #fff; margin: 10px;">
                💬 WhatsApp
            </a>
        </div>
        
        <p><strong>Quick Response Guaranteed!</strong><br>
        We typically respond within 2 hours during business hours.</p>
    </div>
</section>
@endsection

<!DOCTYPE html>
<html ⚡ lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

    <!-- AMP Required Scripts -->
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    
    <!-- AMP Component Scripts (add as needed) -->
    <script async custom-element="amp-img" src="https://cdn.ampproject.org/v0/amp-img-0.1.js"></script>
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>

    <!-- Dynamic Meta Tags -->
    <link rel="canonical" href="{{ url(strtolower(request()->path())) }}" />
    <title>@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')</title>
    <meta name="description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')">
    <meta name="keywords" content="@yield('meta_keywords', $app_setting->app_keywords ?? 'Yogintra')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('meta_title', $app_setting->app_meta_title ?? 'YogIntra')" />
    <meta property="og:description" content="@yield('meta_description', $app_setting->app_meta_description ?? 'Yogintra')" />
    <meta property="og:image" content="@yield('og_image', asset('assets/og-logo.webp'))" />
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <meta name="author" content="YogIntra" />

    <!-- AMP HTML Canonical Link -->
    <link rel="amphtml" href="{{ url()->current() }}/amp">
    
    <!-- FAVICON -->
    <link href="{{ asset($app_setting->fevicon ?? 'favicon.ico') }}" rel="shortcut icon" type="image/png">

    <!-- AMP Boilerplate CSS -->
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>

    <!-- Custom AMP CSS -->
    <style amp-custom>
        /* YogIntra AMP Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        .amp-header {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .amp-header .logo {
            height: 60px;
            width: auto;
        }

        .amp-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .amp-nav-links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 30px;
        }

        .amp-nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .amp-nav-links a:hover {
            color: #ffd700;
        }

        /* Main Content */
        .amp-main {
            min-height: 60vh;
            padding: 40px 0;
        }

        /* Hero Section */
        .amp-hero {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4a 100%);
            padding: 60px 0;
            text-align: center;
            color: #333;
        }

        .amp-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .amp-hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .amp-btn {
            display: inline-block;
            background: #333;
            color: #fff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .amp-btn:hover {
            background: #555;
        }

        /* Content Sections */
        .amp-section {
            padding: 60px 0;
        }

        .amp-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }

        .amp-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        /* Grid Layout */
        .amp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .amp-card {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .amp-card h3 {
            color: #333;
            margin-bottom: 15px;
        }

        /* Footer */
        .amp-footer {
            background: #333;
            color: #fff;
            padding: 40px 0;
            text-align: center;
        }

        .amp-footer p {
            margin: 0;
            opacity: 0.8;
        }

        /* Contact Form */
        .amp-form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .amp-form-group {
            margin-bottom: 20px;
        }

        .amp-form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .amp-form-group input,
        .amp-form-group textarea,
        .amp-form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .amp-form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .amp-submit-btn {
            background: #ffd700;
            color: #333;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .amp-nav-links {
                display: none;
            }
            
            .amp-hero h1 {
                font-size: 2rem;
            }
            
            .amp-section h2 {
                font-size: 2rem;
            }
            
            .container {
                padding: 0 10px;
            }
        }

        /* AMP specific styles */
        amp-img {
            background-color: #f8f9fa;
        }

        /* Success/Error messages */
        .amp-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .amp-error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HealthAndBeautyBusiness",
        "name": "YogIntra",
        "image": "{{ asset('assets/og-logo.webp') }}",
        "url": "{{ url('/') }}",
        "@id": "{{ url('/') }}",
        "logo": "{{ asset('assets/og-logo.webp') }}",
        "description": "Yogintra - Your Trusted Source for Yoga Training and Wellness",
        "priceRange": "₹₹",
        "telephone": "+91-9867291573",
        "email": "support@yogintra.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "postalCode": "",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "19.0760",
            "longitude": "72.8777"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday"
            ],
            "opens": "06:00",
            "closes": "20:00"
        },
        "sameAs": [
            "https://www.facebook.com/yogintra",
            "https://www.instagram.com/yogintra",
            "https://www.twitter.com/yogintra"
        ]
    }
    </script>
</head>

<body>
    <!-- AMP Header -->
    <header class="amp-header">
        <div class="container">
            <nav class="amp-nav">
                <div class="amp-logo">
                    <amp-img src="{{ asset($app_setting->logo ?? 'uploads/6501ab36d6f70Rectrangular-logo-2.png') }}" 
                             alt="YogIntra Logo" 
                             width="200" 
                             height="60" 
                             class="logo">
                    </amp-img>
                </div>
                <ul class="amp-nav-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about') }}">About</a></li>
                    <li><a href="{{ url('/services') }}">Services</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="amp-main">
        @yield('content')
    </main>

    <!-- AMP Footer -->
    <footer class="amp-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} YogIntra. All rights reserved.</p>
            <p>Your Trusted Source for Yoga Training and Wellness</p>
        </div>
    </footer>

    <!-- AMP Analytics -->
    <amp-analytics type="gtag" data-credentials="include">
        <script type="application/json">
        {
            "vars": {
                "gtag_id": "G-8QW4B6YQ9G",
                "config": {
                    "G-8QW4B6YQ9G": {
                        "groups": "default"
                    }
                }
            }
        }
        </script>
    </amp-analytics>
</body>
</html>

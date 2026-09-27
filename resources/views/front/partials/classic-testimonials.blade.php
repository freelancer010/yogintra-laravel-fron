<section class="section classic-testimonials" id="testimonials">
    <div class="wrap">
        <div class="section-top">
            <div>
                <div class="eyebrow">OUR COMMUNITY</div>
                <h2>Real experiences.<br><em>Meaningful connections.</em></h2>
            </div>
            <p>Hear from people who have made YogIntra part of their practice.</p>
        </div>
        <div class="classic-testimonials-grid">
            @foreach ($testimonials as $testimonial)
                <article class="classic-testimonial-card">
                    <blockquote>{{ $testimonial->test_description }}</blockquote>
                    <div class="classic-testimonial-person">
                        @if ($testimonial->test_image)
                            <img src="{{ asset($testimonial->test_image) }}" alt="{{ $testimonial->test_name }}" width="56" height="56" loading="lazy" decoding="async">
                        @endif
                        <div>
                            <h3>{{ $testimonial->test_name }}</h3>
                            @if ($testimonial->test_position)
                                <p>{{ $testimonial->test_position }}</p>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

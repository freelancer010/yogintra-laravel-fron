<section id="locations" class="section classic-locations">
    <div class="wrap">
        <div class="section-top">
            <div><div class="eyebrow">FIND YOUR LOCAL PRACTICE</div><h2>Yoga classes<br><em>across India.</em></h2></div>
            <div><p>Looking for yoga classes near you in India?</p><p>Explore online and personalised sessions in your location. Visit a city page to learn more and enquire about availability.</p></div>
        </div>
        <ul class="classic-locations-grid">
            @foreach ($locations as $location)
                <li><a href="{{ url('/city/' . $location->page_slug) }}">{{ $location->page_name }}</a></li>
            @endforeach
        </ul>
        <a class="button" href="{{ url('/contact') }}">Find yoga classes in your city <span aria-hidden="true">↗</span></a>
    </div>
</section>

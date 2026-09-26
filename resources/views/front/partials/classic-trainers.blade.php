@if ($trainers->isNotEmpty())
<section class="classic-trainers section" id="trainers">
    <div class="wrap">
        <div class="section-top classic-trainers-heading">
            <div>
                <div class="eyebrow">MEET YOUR GUIDES</div>
                <h2>Practice with<br><em>experienced instructors.</em></h2>
            </div>
            <p>Get thoughtful, instructor-led guidance from yoga professionals who support your pace, goals and wellbeing.</p>
        </div>

        <div class="classic-trainers-grid">
            @foreach ($trainers as $trainer)
                @php
                    $details = (array) $trainer;
                    $birthYear = !empty($details['dob'] ?? null) ? \Carbon\Carbon::parse($details['dob'])->year : null;
                    $age = $birthYear ? now()->year - $birthYear : null;
                    $location = collect([$details['city'] ?? null, $details['state'] ?? null])->filter()->implode(', ');
                    $image = !empty($details['profile_image'] ?? null)
                        ? rtrim($api, '/') . '/' . ltrim($details['profile_image'], '/')
                        : asset('assets/landing-reference/guidance.webp');
                @endphp
                <article class="classic-trainer-card">
                    <img src="{{ $image }}" alt="YogIntra instructor {{ $details['name'] ?? 'Instructor' }}" loading="lazy" width="480" height="520">
                    <div class="classic-trainer-card__body">
                        <h3>{{ $details['name'] ?? 'YogIntra Instructor' }}</h3>
                        @if ($age)
                            <p>Age {{ $age }}</p>
                        @endif
                        @if ($location)
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $location }}</span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <a class="text-link classic-trainers-link" href="{{ url('/trainers') }}">Meet all instructors <span>↗</span></a>
    </div>
</section>
@endif

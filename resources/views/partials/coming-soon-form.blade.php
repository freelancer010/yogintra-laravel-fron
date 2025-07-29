<section style='background-image: url("{{ asset('assets/front/images/pattern/p4.png') }}");'>
    <div class="container">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2"></div>
            </div>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ asset('assets/coming_soon.webp') }}" alt="Coming Soon">
                </div>
                <div class="col-md-7">
                    <div class="mb-40">
                        <h2 class="text-uppercase text-center font-38 mt-0">
                            <span class="text-theme-colored">{{ $form_title ?? 'MORE EVENTS' }}</span> COMING SOON
                        </h2>
                    </div>
                    @include('components.multi-step-form', ['app_setting' => $app_setting])
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .form-step { display: none; }
    .form-step.active { display: block; }
</style>
@endpush

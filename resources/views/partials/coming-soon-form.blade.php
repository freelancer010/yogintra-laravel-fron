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
                    <img src="{{ asset('assets/coming_soon.png') }}" alt="Coming Soon">
                </div>
                <div class="col-md-7">
                    <div class="mb-40">
                        <h1 class="text-uppercase text-center font-38 mt-0">
                            <span class="text-theme-colored">{{ $form_title ?? 'MORE EVENTS' }}</span> COMING SOON
                        </h1>
                    </div>
                    <form id="multi-step-form" method="post">
                        @csrf
                        <!-- Step 1 -->
                        <div class="form-step active" id="step-1">
                            <div class="form-group"><label>Your Name:</label><input type="text" name="name" class="form-control" required></div>
                            <div class="form-group"><label>Phone Number:</label><input type="text" name="number" class="form-control" required></div>
                            <div class="form-group"><label>Email ID:</label><input type="email" name="email" class="form-control" required></div>
                            <button class="btn btn-primary next" type="button">Next</button>
                        </div>
                        <!-- Step 2 -->
                        <div class="form-step" id="step-2">
                            <div class="form-group"><label>Select Country:</label><select class="form-control countries" name="country" required><option value="">Select A Country</option></select></div>
                            <div class="form-group"><label>Select State:</label><select class="form-control states" name="state" required><option value="">Select your Country First</option></select></div>
                            <div class="form-group"><label>Select City:</label><select class="form-control cities" name="city" required><option value="">Select your state first</option></select></div>
                            <button class="btn btn-primary prev" type="button">Previous</button>
                            <button class="btn btn-primary next" type="button">Next</button>
                        </div>
                        <!-- Step 3 -->
                        <div class="form-step" id="step-3">
                            <div class="form-group"><label>Service Menu:</label>
                                <select class="form-control" name="class" required>
                                    @foreach (\DB::table('service_category')->get() as $service)
                                        <option value="{{ $service->service_cat_name }}">{{ $service->service_cat_name }}</option>
                                    @endforeach
                                    <option value="Yoga Center">Yoga Center</option>
                                    <option value="TTC">TTC</option>
                                    <option value="Retreat">Retreat</option>
                                    <option value="Workshop">Workshop</option>
                                </select>
                            </div>
                            <div class="form-group d-none"><label>Call Request Time From:</label><input type="time" class="form-control" name="call-from"></div>
                            <div class="form-group d-none"><label>To:</label><input type="time" class="form-control" name="call-to"></div>
                            <div class="form-group"><label>Message:</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
                            <button class="btn btn-primary prev" type="button">Previous</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
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

@extends('layouts.admin')

@section('title', 'Application Setting')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0 text-dark">Application Setting</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @include('admin.partials.flash')
        <div class="card card-default">
          <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab">General</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="logo-tab" data-toggle="tab" href="#logo" role="tab">Logo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab">Payment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="htmlhead-tab" data-toggle="tab" href="#htmlhead" role="tab">HTML Head</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab">Social Media</a>
            </li>
          </ul>

          <div class="card-body">
            <div class="tab-content" id="settingsTabContent">
              {{-- General --}}
              <div class="tab-pane fade show active" id="general" role="tabpanel">
                <form id="generalForm" method="POST" action="{{ route('admin.setting.update', ['type' => 'general']) }}" enctype="multipart/form-data">
                  @csrf
                  @include('admin.settings.partials.general', ['setting' => $setting])
                  <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success">Save General Settings</button>
                  </div>
                </form>
              </div>

              {{-- Contact --}}
              <div class="tab-pane fade" id="contact" role="tabpanel">
                <form id="contactForm" method="POST" action="{{ route('admin.setting.update', ['type' => 'contact']) }}" enctype="multipart/form-data">
                  @csrf
                  @include('admin.settings.partials.contact', ['setting' => $setting])
                  <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success">Save Contact Settings</button>
                  </div>
                </form>
              </div>

              {{-- Logo --}}
              <div class="tab-pane fade" id="logo" role="tabpanel">
                <form id="logoForm" method="POST" action="{{ route('admin.setting.update', ['type' => 'logo']) }}" enctype="multipart/form-data">
                  @csrf
                  @include('admin.settings.partials.logo', ['setting' => $setting])
                  <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success">Save Logo Settings</button>
                  </div>
                </form>
              </div>

              {{-- Payment --}}
              <div class="tab-pane fade" id="payment" role="tabpanel">
                <form id="paymentForm" method="POST" action="{{ route('admin.setting.update', ['type' => 'payment']) }}" enctype="multipart/form-data">
                  @csrf
                  @include('admin.settings.partials.payment', ['setting' => $setting])
                  <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success">Save Payment Settings</button>
                  </div>
                </form>
              </div>

              {{-- HTML Head --}}
              <div class="tab-pane fade" id="htmlhead" role="tabpanel">
                <form id="htmlheadForm" method="POST" action="{{ route('admin.setting.update', ['type' => 'htmlhead']) }}" enctype="multipart/form-data">
                  @csrf
                  @include('admin.settings.partials.htmlhead', ['setting' => $setting])
                  <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success">Save HTML Head Settings</button>
                  </div>
                </form>
              </div>

              {{-- Social Media --}}
              <div class="tab-pane fade" id="social" role="tabpanel">
                <form id="socialForm" method="POST" action="{{ route('admin.setting.update', ['type' => 'social']) }}" enctype="multipart/form-data">
                  @csrf
                  @include('admin.settings.partials.social', ['setting' => $setting])
                  <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-success">Save Social Media Settings</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  function previewImage(input, id) {
    if (input.files && input.files[0]) {
      let reader = new FileReader();
      reader.onload = e => document.getElementById(id).src = e.target.result;
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Maintain active tab after form submission
  $(document).ready(function() {
    // Get active tab from URL hash or localStorage
    let activeTab = window.location.hash || localStorage.getItem('activeSettingsTab') || '#general';
    
    // Show the active tab
    $('a[href="' + activeTab + '"]').tab('show');
    
    // Save the active tab to localStorage when changed
    $('#settingsTabs a').on('click', function (e) {
      localStorage.setItem('activeSettingsTab', $(this).attr('href'));
    });

    // Keep active tab after form submission
    if (window.location.search.includes('updated=true')) {
      let tab = localStorage.getItem('activeSettingsTab');
      if (tab) {
        $('a[href="' + tab + '"]').tab('show');
      }
    }

    // Add loading state to submit buttons
    $('form').on('submit', function() {
      $(this).find('button[type="submit"]').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
      );
    });
  });
</script>
@endpush

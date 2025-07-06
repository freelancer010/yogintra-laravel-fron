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
      <form method="POST" action="{{ url('admin/setting/update-application-setting') }}" enctype="multipart/form-data">
        @csrf

        <div class="card card-default">
          <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="#logo" data-toggle="tab">Logo</a></li>
            <li class="nav-item"><a class="nav-link" href="#payment" data-toggle="tab">Payment</a></li>
            <li class="nav-item"><a class="nav-link" href="#htmlhead" data-toggle="tab">HTML Head</a></li>
            <li class="nav-item"><a class="nav-link" href="#social" data-toggle="tab">Social Media</a></li>
          </ul>

          <div class="card-body">
            <div class="tab-content">

              {{-- General --}}
              <div class="tab-pane active" id="general">
                @include('admin.settings.partials.general', ['setting' => $setting])
              </div>

              {{-- Contact --}}
              <div class="tab-pane" id="contact">
                @include('admin.settings.partials.contact', ['setting' => $setting])
              </div>

              {{-- Logo --}}
              <div class="tab-pane" id="logo">
                @include('admin.settings.partials.logo', ['setting' => $setting])
              </div>

              {{-- Payment --}}
              <div class="tab-pane" id="payment">
                @include('admin.settings.partials.payment', ['setting' => $setting])
              </div>

              {{-- HTML Head --}}
              <div class="tab-pane" id="htmlhead">
                @include('admin.settings.partials.htmlhead', ['setting' => $setting])
              </div>

              {{-- Social Media --}}
              <div class="tab-pane" id="social">
                @include('admin.settings.partials.social', ['setting' => $setting])
              </div>

            </div>

            <div class="mt-3 text-right">
              <button type="submit" class="btn btn-success">Save Settings</button>
            </div>

          </div>
        </div>
      </form>
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
</script>
@endpush

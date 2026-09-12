@extends('layouts.admin') {{-- Update this if your layout file is named differently --}}

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">All Slider</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Front Setting</a></li>
            <li class="breadcrumb-item active">All Slider</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
            @include('admin.partials.flash')

      <div class="card card-default mb-3">
        <div class="card-header"><h3 class="card-title">Hero media</h3></div>
        <div class="card-body">
          <form action="{{ route('admin.front.hero-media.update') }}" method="POST" enctype="multipart/form-data" id="hero-media-form">
            @csrf
            @method('PUT')
            <div class="d-flex flex-wrap align-items-center" style="gap:16px;">
              <div class="btn-group hero-media-switch" role="group" aria-label="Hero media type">
                <label class="btn btn-outline-primary mb-0 {{ ($heroSetting->hero_media_type ?? 'slider') === 'slider' ? 'active' : '' }}">
                  <input type="radio" name="hero_media_type" value="slider" autocomplete="off" {{ ($heroSetting->hero_media_type ?? 'slider') === 'slider' ? 'checked' : '' }}> <i class="fas fa-images"></i> Image slider
                </label>
                <label class="btn btn-outline-primary mb-0 {{ ($heroSetting->hero_media_type ?? 'slider') === 'video' ? 'active' : '' }}">
                  <input type="radio" name="hero_media_type" value="video" autocomplete="off" {{ ($heroSetting->hero_media_type ?? 'slider') === 'video' ? 'checked' : '' }}> <i class="fas fa-video"></i> Video
                </label>
              </div>
              <div class="hero-video-control flex-grow-1" id="hero-video-control">
                <input type="file" name="hero_video" id="hero_video" accept="video/mp4,video/webm,video/ogg,video/quicktime" class="d-none">
                <label for="hero_video" class="btn btn-outline-primary btn-sm mb-0"><i class="fas fa-upload"></i> Choose video</label>
                <span class="text-muted small ml-2" id="hero-video-name">{{ $heroSetting->hero_video ? basename($heroSetting->hero_video) : 'MP4, WebM, OGG, or MOV · max 50 MB' }}</span>
              </div>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Save hero media</button>
            </div>
            @error('hero_video')<div class="invalid-feedback d-block mt-2">{{ $message }}</div>@enderror
          </form>
        </div>
      </div>

      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">View All Slider</h3>
          <div class="card-tools">
            <a href="{{ url('admin/front-setting/add-new-slider') }}" class="btn btn-success btn-sm">
              <i class="fa fa-plus"></i> Add Slider
            </a>
          </div>
        </div>

        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Background Image</th>
                <th>Details</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sliders as $index => $slider)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  <img src="{{ asset($slider->slider_image) }}" width="50px" alt="slider img">
                </td>
                <td>
                  H.: <strong>{{ $slider->slider_heading }}</strong><br>
                  S.H.: <strong>{{ $slider->slider_sub_heading }}</strong><br>
                  B. Name: <strong>{{ $slider->slider_btn_name }}</strong><br>
                  B. Link: <strong>{{ $slider->slider_btn_link }}</strong>
                </td>
                <td class="text-right py-0 align-middle">
                  <div class="btn-group-sm">
                    <a href="{{ url('admin/front-setting/edit-slider/' . $slider->slider_id) }}" class="btn btn-info">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ url('admin/front-setting/delete-slider/' . $slider->slider_id) }}"
                      onclick="return confirm('Are you sure?')" class="btn btn-danger mt-3">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> <!-- /.card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.container-fluid -->
  </section>
  @push('scripts')
  <script>
    (function () {
      const videoControl = document.getElementById('hero-video-control');
      const choices = document.querySelectorAll('input[name="hero_media_type"]');
      const updateHeroMediaControl = () => {
        const isVideo = document.querySelector('input[name="hero_media_type"]:checked').value === 'video';
        videoControl.style.display = isVideo ? '' : 'none';
      };
      choices.forEach(choice => choice.addEventListener('change', updateHeroMediaControl));
      document.getElementById('hero_video').addEventListener('change', function () {
        document.getElementById('hero-video-name').textContent = this.files[0] ? this.files[0].name : 'MP4, WebM, OGG, or MOV · max 50 MB';
      });
      updateHeroMediaControl();
    })();
  </script>
  @endpush
@endsection

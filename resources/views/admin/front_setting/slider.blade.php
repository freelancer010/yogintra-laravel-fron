@extends('layouts.admin') {{-- Update this if your layout file is named differently --}}

@push('styles')
<style>
  .hero-media-toggle { display:inline-block; margin:0; cursor:pointer; }
  .hero-media-toggle input { position:absolute; opacity:0; pointer-events:none; }
  .hero-media-toggle-track { position:relative; display:flex; align-items:center; width:244px; height:46px; padding:4px; border:1px solid #b9d9de; border-radius:12px; background:#f4fafb; overflow:hidden; }
  .hero-media-toggle-track::before { content:''; position:absolute; top:4px; bottom:4px; left:4px; width:calc(50% - 4px); border-radius:8px; background:#168794; box-shadow:0 2px 5px rgba(10,84,92,.18); transition:transform .22s ease; }
  .hero-media-toggle input:checked + .hero-media-toggle-track::before { transform:translateX(100%); }
  .hero-media-toggle-option { position:relative; z-index:1; width:50%; color:#54747a; font-size:13px; font-weight:700; text-align:center; transition:color .22s ease; }
  .hero-media-toggle input:not(:checked) + .hero-media-toggle-track .hero-media-toggle-image,
  .hero-media-toggle input:checked + .hero-media-toggle-track .hero-media-toggle-video { color:#fff; }
  .hero-video-editor { display:grid; grid-template-columns:minmax(280px, .85fr) minmax(0, 1.15fr); gap:28px; align-items:stretch; }
  .hero-video-preview-pane { display:flex; flex-direction:column; min-height:420px; padding:22px; border:1px solid #d6e3e6; border-radius:10px; background:#fff; }
  .hero-video-preview-frame { position:relative; display:flex; flex:1; align-items:center; justify-content:center; min-height:260px; margin-top:14px; overflow:hidden; border-radius:8px; background:#122126; }
  .hero-video-preview-frame video { width:100%; height:100%; min-height:260px; object-fit:contain; }
  .hero-video-preview-empty { color:#d8e6e8; text-align:center; }
  .hero-video-preview-empty i { display:block; margin-bottom:10px; font-size:34px; }
  .hero-video-fields-pane { padding:4px 2px; }
  #hero-slider-list .table { width:100%; table-layout:fixed; }
  #hero-slider-list .slider-id-column { width:6%; }
  #hero-slider-list .slider-image-column { width:30%; }
  #hero-slider-list .slider-details-column { width:50%; }
  #hero-slider-list .slider-actions-column { width:14%; text-align:center; }
  #hero-slider-list .slider-thumbnail { width:88px; height:58px; object-fit:cover; border-radius:7px; border:1px solid #e1ebed; }
  #hero-slider-list .slider-details { line-height:1.45; overflow-wrap:anywhere; }
  #hero-slider-list .slider-actions { display:flex; justify-content:center; align-items:center; gap:8px; min-width:116px; }
  #hero-slider-list .slider-actions .btn { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; margin:0; border-radius:9px; }
  @media (max-width: 767px) {
    #hero-slider-list .card-body { overflow-x:auto; -webkit-overflow-scrolling:touch; }
    #hero-slider-list .dataTables_wrapper { min-width:720px; }
    #hero-slider-list .table { min-width:720px; }
  }
  @media (max-width: 991px) { .hero-video-editor { grid-template-columns:1fr; } .hero-video-preview-pane { min-height:300px; } .hero-video-preview-frame, .hero-video-preview-frame video { min-height:220px; } }
</style>
@endpush

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
              <input type="hidden" name="hero_media_type" id="hero-media-type" value="{{ $heroSetting->hero_media_type ?? 'slider' }}">
              <label class="hero-media-toggle" for="hero-media-toggle">
                <input type="checkbox" id="hero-media-toggle" {{ ($heroSetting->hero_media_type ?? 'slider') === 'video' ? 'checked' : '' }} aria-label="Switch between image slider and video">
                <span class="hero-media-toggle-track">
                  <span class="hero-media-toggle-option hero-media-toggle-image"><i class="fas fa-images"></i> Image slider</span>
                  <span class="hero-media-toggle-option hero-media-toggle-video"><i class="fas fa-video"></i> Video</span>
                </span>
              </label>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Save hero media</button>
            </div>
            <div class="hero-video-settings mt-4" id="hero-video-settings">
              <div class="border rounded p-3 bg-light hero-video-editor">
                <div class="hero-video-preview-pane">
                  <div><strong>Video preview</strong><p class="text-muted small mb-0">This is the video visitors will see in the homepage hero.</p></div>
                  <div class="hero-video-preview-frame">
                    <video id="hero-video-preview" controls preload="metadata" class="{{ $heroSetting->hero_video ? '' : 'd-none' }}" title="{{ $heroSetting->hero_video_title }}">
                      @if($heroSetting->hero_video)<source src="{{ asset($heroSetting->hero_video) }}">@endif
                    </video>
                    <div class="hero-video-preview-empty {{ $heroSetting->hero_video ? 'd-none' : '' }}" id="hero-video-preview-empty"><i class="fas fa-video"></i>Choose a video to preview it here.</div>
                  </div>
                </div>
                <div class="hero-video-fields-pane">
                  <div class="mb-3"><strong>Hero video settings</strong><p class="text-muted small mb-0">These fields match the image slider and control the text overlay.</p></div>
                  <div class="hero-video-control mb-3" id="hero-video-control">
                    <label class="d-block">Slider Background Video <span class="text-danger">*</span></label>
                    <input type="file" name="hero_video" id="hero_video" accept="video/mp4,video/webm,video/ogg,video/quicktime" class="d-none">
                    <label for="hero_video" class="btn btn-outline-primary btn-sm mb-0"><i class="fas fa-upload"></i> Choose video</label>
                    <span class="text-muted small ml-2" id="hero-video-name">{{ $heroSetting->hero_video ? basename($heroSetting->hero_video) : 'MP4, WebM, OGG, or MOV · max 50 MB' }}</span>
                  </div>
                  <div class="hero-video-control mb-3">
                    <label class="d-block">Video thumbnail <small class="text-muted">Generated automatically from the selected video. You can also replace it.</small></label>
                    <input type="file" name="hero_video_thumbnail" id="hero_video_thumbnail" accept="image/jpeg,image/png,image/webp" class="d-none">
                    <label for="hero_video_thumbnail" class="btn btn-outline-secondary btn-sm mb-0"><i class="fas fa-image"></i> Choose thumbnail</label>
                    <img id="hero-video-thumbnail-preview" src="{{ $heroSetting->hero_video_thumbnail ? asset($heroSetting->hero_video_thumbnail) : '' }}" alt="Hero video thumbnail" class="{{ $heroSetting->hero_video_thumbnail ? '' : 'd-none' }} ml-2" style="width:96px;height:54px;object-fit:cover;border-radius:5px;border:1px solid #d7e4e7;">
                  </div>
                  <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="hero_video_heading">Slider Heading <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('hero_video_heading') is-invalid @enderror" id="hero_video_heading" name="hero_video_heading" maxlength="255" value="{{ old('hero_video_heading', $heroSetting->hero_video_heading) }}">
                    @error('hero_video_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-12 form-group">
                    <label for="hero_video_sub_heading">Slider Sub Heading</label>
                    <input type="text" class="form-control @error('hero_video_sub_heading') is-invalid @enderror" id="hero_video_sub_heading" name="hero_video_sub_heading" maxlength="255" value="{{ old('hero_video_sub_heading', $heroSetting->hero_video_sub_heading) }}">
                    @error('hero_video_sub_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-6 form-group mb-0">
                    <label for="hero_video_btn_name">Slider Button Name</label>
                    <input type="text" class="form-control" id="hero_video_btn_name" name="hero_video_btn_name" maxlength="100" value="{{ old('hero_video_btn_name', $heroSetting->hero_video_btn_name) }}">
                  </div>
                  <div class="col-md-6 form-group mb-0">
                    <label for="hero_video_btn_link">Slider Button Link</label>
                    <input type="url" class="form-control @error('hero_video_btn_link') is-invalid @enderror" id="hero_video_btn_link" name="hero_video_btn_link" value="{{ old('hero_video_btn_link', $heroSetting->hero_video_btn_link) }}">
                    @error('hero_video_btn_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-6 form-group mt-3 mb-0">
                    <label for="hero_video_text_direction">Slider Text Direction <span class="text-danger">*</span></label>
                    <select class="form-control" id="hero_video_text_direction" name="hero_video_text_direction">
                      @foreach(['left' => 'Left', 'right' => 'Right', 'center' => 'Center'] as $value => $label)
                        <option value="{{ $value }}" {{ old('hero_video_text_direction', $heroSetting->hero_video_text_direction ?? 'left') === $value ? 'selected' : '' }}>{{ $label }}</option>
                      @endforeach
                    </select>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            @error('hero_video')<div class="invalid-feedback d-block mt-2">{{ $message }}</div>@enderror
          </form>
        </div>
      </div>

      <div class="card card-default" id="hero-slider-list">
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
                <th class="slider-id-column">ID</th>
                <th class="slider-image-column">Background Image</th>
                <th class="slider-details-column">Details</th>
                <th class="slider-actions-column">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sliders as $index => $slider)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  <img src="{{ asset($slider->slider_image) }}" class="slider-thumbnail" alt="{{ $slider->slider_heading }}">
                </td>
                <td class="slider-details">
                  H.: <strong>{{ $slider->slider_heading }}</strong><br>
                  S.H.: <strong>{{ $slider->slider_sub_heading }}</strong><br>
                  B. Name: <strong>{{ $slider->slider_btn_name }}</strong><br>
                  B. Link: <strong>{{ $slider->slider_btn_link }}</strong>
                </td>
                <td class="align-middle">
                  <div class="slider-actions">
                    <a href="{{ url('admin/front-setting/edit-slider/' . $slider->slider_id) }}" class="btn btn-info">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ url('admin/front-setting/delete-slider/' . $slider->slider_id) }}"
                      onclick="return confirm('Are you sure?')" class="btn btn-danger">
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
      const videoSettings = document.getElementById('hero-video-settings');
      const sliderList = document.getElementById('hero-slider-list');
      const heroMediaToggle = document.getElementById('hero-media-toggle');
      const heroMediaType = document.getElementById('hero-media-type');
      const updateHeroMediaControl = () => {
        const isVideo = heroMediaToggle.checked;
        heroMediaType.value = isVideo ? 'video' : 'slider';
        heroMediaToggle.setAttribute('aria-checked', String(isVideo));
        videoSettings.style.display = isVideo ? '' : 'none';
        sliderList.style.display = isVideo ? 'none' : '';
      };
      heroMediaToggle.addEventListener('change', updateHeroMediaControl);
      document.getElementById('hero_video').addEventListener('change', function () {
        const file = this.files[0];
        document.getElementById('hero-video-name').textContent = file ? file.name : 'MP4, WebM, OGG, or MOV · max 50 MB';
        if (!file) return;
        const preview = document.getElementById('hero-video-preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
        document.getElementById('hero-video-preview-empty').classList.add('d-none');
        preview.load();
        const thumbnailInput = document.getElementById('hero_video_thumbnail');
        const thumbnailPreview = document.getElementById('hero-video-thumbnail-preview');
        const captureFrame = () => {
          const canvas = document.createElement('canvas');
          const scale = Math.min(1280 / preview.videoWidth, 1);
          canvas.width = Math.max(1, Math.round(preview.videoWidth * scale));
          canvas.height = Math.max(1, Math.round(preview.videoHeight * scale));
          canvas.getContext('2d').drawImage(preview, 0, 0, canvas.width, canvas.height);
          canvas.toBlob(blob => {
            if (!blob) return;
            const generatedThumbnail = new File([blob], 'hero-video-thumbnail.jpg', { type: 'image/jpeg' });
            const transfer = new DataTransfer(); transfer.items.add(generatedThumbnail); thumbnailInput.files = transfer.files;
            thumbnailPreview.src = URL.createObjectURL(generatedThumbnail); thumbnailPreview.classList.remove('d-none');
          }, 'image/jpeg', .85);
        };
        preview.addEventListener('loadedmetadata', () => { preview.currentTime = Math.min(1, Math.max(0, preview.duration / 2)); }, { once:true });
        preview.addEventListener('seeked', captureFrame, { once:true });
      });
      document.getElementById('hero_video_thumbnail').addEventListener('change', function () {
        const file = this.files[0]; if (!file) return;
        const thumbnailPreview = document.getElementById('hero-video-thumbnail-preview');
        thumbnailPreview.src = URL.createObjectURL(file); thumbnailPreview.classList.remove('d-none');
      });
      updateHeroMediaControl();
    })();
  </script>
  @endpush
@endsection

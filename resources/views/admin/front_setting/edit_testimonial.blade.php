@extends('layouts.admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Testimonial</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Front Setting</a></li>
          <li class="breadcrumb-item active">Edit Testimonial</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    @include('admin.partials.flash')

    <div class="row">
      <div class="col-sm-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edit Testimonial</h3>
            <div class="card-tools">
              <a href="{{ route('admin.front.testimonial') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-eye" aria-hidden="true"></i> View All
              </a>
            </div>
          </div>

          <form action="{{ route('admin.front.testimonial.update', $testimonial->test_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('test_name') is-invalid @enderror" name="test_name" placeholder="Enter customer name" value="{{ old('test_name', $testimonial->test_name) }}">
                    @error('test_name') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Star Rating <span class="text-danger">*</span></label>
                    <select class="form-control @error('test_review') is-invalid @enderror" name="test_review" required>
                      <option value="">Select Rating</option>
                      <option value="5" {{ old('test_review', $testimonial->test_review) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
                      <option value="4" {{ old('test_review', $testimonial->test_review) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars</option>
                      <option value="3" {{ old('test_review', $testimonial->test_review) == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 Stars</option>
                      <option value="2" {{ old('test_review', $testimonial->test_review) == 2 ? 'selected' : '' }}>⭐⭐ 2 Stars</option>
                      <option value="1" {{ old('test_review', $testimonial->test_review) == 1 ? 'selected' : '' }}>⭐ 1 Star</option>
                    </select>
                    @error('test_review') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Position (Job Title)</label>
                    <input type="text" class="form-control @error('test_position') is-invalid @enderror" name="test_position" placeholder="e.g., Yoga Instructor, Student" value="{{ old('test_position', $testimonial->test_position) }}">
                    @error('test_position') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Photo (Optional)</label>
                    <div class="custom-file-upload">
                      <input type="file" class="file-input @error('test_image') is-invalid @enderror" name="test_image" id="photo" style="display: none;" accept="image/*">
                      <button type="button" class="btn btn-primary" onclick="document.getElementById('photo').click()">
                        <i class="fas fa-cloud-upload-alt"></i> Change Photo
                      </button>
                      <span id="file-chosen">No file chosen</span>
                    </div>
                    @error('test_image') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Review Text <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('test_description') is-invalid @enderror" name="test_description" placeholder="Enter customer review" rows="4">{{ old('test_description', $testimonial->test_description) }}</textarea>
                    @error('test_description') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Current Photo</label><br>
                    @if($testimonial->test_image)
                      <img id="imagePreview" style="border: 1px solid #ddd; border-radius: 4px; max-width: 100%; height: auto;" src="{{ asset($testimonial->test_image) }}" width="150px;">
                    @else
                      <p id="noPreview" style="color: #999; font-size: 12px;">No image uploaded</p>
                      <img id="imagePreview" style="border: 1px solid #ddd; border-radius: 4px; max-width: 100%; height: auto; display: none;" src="" width="150px;">
                    @endif
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group text-right">
                    <button type="submit" class="btn btn-success">
                      <i class="fas fa-save"></i> Update Testimonial
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div><!-- /.container-fluid -->
</section>

<style>
  .custom-file-upload {
    display: inline-block;
    margin-top: 5px;
  }
  .custom-file-upload button {
    margin-right: 10px;
  }
  #file-chosen {
    margin-left: 10px;
    color: #666;
    font-size: 14px;
  }
  #imagePreview {
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  #imagePreview:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }
</style>

<script>
  document.getElementById('photo').addEventListener('change', function(e) {
    const fileChosen = document.getElementById('file-chosen');
    const imagePreview = document.getElementById('imagePreview');
    const noPreview = document.getElementById('noPreview');
    
    fileChosen.textContent = this.files[0] ? this.files[0].name : 'No file chosen';

    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.style.display = 'block';
        if (noPreview) noPreview.style.display = 'none';
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
</script>
@endsection

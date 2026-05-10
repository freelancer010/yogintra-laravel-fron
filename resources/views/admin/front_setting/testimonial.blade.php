@extends('layouts.admin')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Review Section</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Front Setting</a></li>
            <li class="breadcrumb-item active">Review Section</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @include('admin.partials.flash')

      <!-- Add New Testimonial Form -->
      <div class="card card-default mb-4">
        <div class="card-header">
          <h3 class="card-title">Add New Testimonial</h3>
        </div>

        <form action="{{ route('admin.front.testimonial.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('test_name') is-invalid @enderror" name="test_name" placeholder="Enter customer name" value="{{ old('test_name') }}">
                  @error('test_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Star Rating <span class="text-danger">*</span></label>
                  <select class="form-control @error('test_review') is-invalid @enderror" name="test_review" required>
                    <option value="">Select Rating</option>
                    <option value="5" {{ old('test_review') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
                    <option value="4" {{ old('test_review') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars</option>
                    <option value="3" {{ old('test_review') == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 Stars</option>
                    <option value="2" {{ old('test_review') == 2 ? 'selected' : '' }}>⭐⭐ 2 Stars</option>
                    <option value="1" {{ old('test_review') == 1 ? 'selected' : '' }}>⭐ 1 Star</option>
                  </select>
                  @error('test_review') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Position (Job Title)</label>
                  <input type="text" class="form-control @error('test_position') is-invalid @enderror" name="test_position" placeholder="e.g., Yoga Instructor, Student" value="{{ old('test_position') }}">
                  @error('test_position') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Photo (Optional)</label>
                  <div class="custom-file-upload">
                    <input type="file" class="file-input @error('test_image') is-invalid @enderror" name="test_image" id="photo" style="display: none;" accept="image/*">
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('photo').click()">
                      <i class="fas fa-cloud-upload-alt"></i> Choose Photo
                    </button>
                    <span id="file-chosen">No file chosen</span>
                  </div>
                  @error('test_image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Review Text <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('test_description') is-invalid @enderror" name="test_description" placeholder="Enter customer review" rows="4">{{ old('test_description') }}</textarea>
                  @error('test_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Preview Photo</label><br>
                  <img id="imagePreview" style="border: 1px solid #ddd; border-radius: 4px; max-width: 100%; height: auto; display: none;" src="" width="150px;">
                  <p id="noPreview" style="color: #999; font-size: 12px;">No image preview</p>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group text-right">
                  <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Add Testimonial
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- View All Testimonials Table -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">All Testimonials</h3>
        </div>

        <div class="card-body">
          @if($testimonials->count() > 0)
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Rating</th>
                  <th>Review</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($testimonials as $index => $testimonial)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    @if($testimonial->test_image)
                      <img src="{{ asset($testimonial->test_image) }}" width="50px" height="50px" alt="photo" style="border-radius: 4px; object-fit: cover;">
                    @else
                      <span class="text-muted">No photo</span>
                    @endif
                  </td>
                  <td>{{ $testimonial->test_name }}</td>
                  <td><small>{{ $testimonial->test_position ?? 'N/A' }}</small></td>
                  <td>
                    @for($i = 0; $i < $testimonial->test_review; $i++)
                      <span style="color: #FFD700;">★</span>
                    @endfor
                    <small>({{ $testimonial->test_review }}/5)</small>
                  </td>
                  <td>
                    <small>{{ Str::limit($testimonial->test_description, 50) }}</small>
                  </td>
                  <td class="text-right py-0 align-middle">
                    <div class="btn-group-sm">
                      <a href="{{ route('admin.front.testimonial.edit', $testimonial->test_id) }}" class="btn btn-info">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <a href="{{ route('admin.front.testimonial.delete', $testimonial->test_id) }}" 
                         onclick="return confirm('Are you sure you want to delete this testimonial?')" 
                         class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                      </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="alert alert-info" role="alert">
              <strong>No testimonials yet.</strong> Add your first testimonial using the form above.
            </div>
          @endif
        </div>
      </div>

    </div> <!-- /.container-fluid -->
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
          noPreview.style.display = 'none';
        };
        reader.readAsDataURL(this.files[0]);
      } else {
        imagePreview.style.display = 'none';
        noPreview.style.display = 'block';
      }
    });
  </script>
@endsection

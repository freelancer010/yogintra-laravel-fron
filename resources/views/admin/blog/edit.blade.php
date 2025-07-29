@extends('layouts.admin')

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Edit Blog</h1>
          <a target="_blank" href="{{ url('/blog/' . $blog->blog_slug) }}"> ({{$blog->blog_title}}) </a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Blog</a></li>
            <li class="breadcrumb-item active">Edit Blog</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      @include('admin.partials.flash')

      <div class="row">
        <div class="col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Edit Blog</h3>
              <div class="card-tools">
                <a href="{{ route('admin.blog.index') }}" class="btn btn-primary btn-sm">
                  <i class="fa fa-eye"></i> View All Blog
                </a>
              </div>
            </div>

            <form action="{{ route('admin.blog.update', $blog->blog_id) }}" method="POST" enctype="multipart/form-data">              
              @csrf
              <div class="card-body">
                <div class="row">
                  {{-- <div class="col-md-12"> --}}

                    @if($blog->blog_image)
                    <div class="form-group text-center col-md-6">
                      <b class="d-block mb-3 text-left">Preview Blog Image</b>
                      <img src="{{ asset($blog->blog_image) }}" width="100%">
                    </div>
                    @endif

                    <div class="form-group col-md-6">
                      <label for="blog_image">Blog Image</label>
                      <input type="file" name="blog_image" id="blog_image" class="form-control" accept="image/*">
                    </div>
                  
                    <hr class="w-100 border-bottom mb-5">

                    <div class="form-group col-md-6">
                      <label for="blog_title">Title <span style="color:red">*</span></label>
                      <input id="blog_title" type="text" name="blog_title" class="form-control" required value="{{ old('blog_title', $blog->blog_title) }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="blog_author">Author Name</label>
                      <input id="blog_author" type="text" name="blog_author" class="form-control" value="{{ old('blog_author', $blog->blog_author) }}">
                    </div>

                    <div class="form-group col-md-12">
                      <label for="blog_short_description">Short Description</label>
                      <textarea id="blog_short_description" name="blog_short_description" class="form-control" rows="3">{{ old('blog_short_description', $blog->blog_short_description) }}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="blog_meta_keywords">Meta Keywords</label>
                      <textarea id="blog_meta_keywords" name="blog_meta_keywords" class="form-control" rows="3">{{ old('blog_meta_keywords', $blog->blog_meta_keywords) }}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="blog_meta_description">Meta Description</label>
                      <textarea id="blog_meta_description" name="blog_meta_description" class="form-control" rows="3">{{ old('blog_meta_description', $blog->blog_meta_description) }}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="blog_category">Select Category <span style="color:red">*</span></label>
                      <select id="blog_category" name="blog_category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($get_all_blog_category as $category)
                          <option value="{{ $category->id }}" {{ (old('blog_category', $blog->blog_category) == $category->id) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  {{-- </div> --}}

                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="editor">Content <span style="color:red">*</span></label>
                        <textarea name="blog_content" id="editor" class="form-control text-editor" rows="10">{!! old('blog_content', $blog->blog_content) !!}</textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success float-right">
                        <i class="fa fa-save"></i> Update Blog
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@push('styles')
<!-- TinyMCE does not require additional CSS -->
@endpush

@push('scripts')
<script src="https://cdn.tiny.cloud/1/p96sr398x0evyp69lvm9o2ieiuyexn462e38v64kghyfl7zy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#editor',
    height: 500,
    plugins: 'image media link code table lists advlist fullscreen preview anchor insertdatetime searchreplace wordcount charmap emoticons codesample visualblocks visualchars',
    toolbar: 'undo redo | blocks fontfamily fontsize | styles | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media codesample | table charmap emoticons | code visualblocks fullscreen preview',
    style_formats: [
      { title: 'Image Left', selector: 'img', styles: { 'float': 'left', 'margin': '0 10px 0 0' } },
      { title: 'Image Right', selector: 'img', styles: { 'float': 'right', 'margin': '0 0 0 10px' } },
      { title: 'Clear Float', selector: 'p', styles: { 'clear': 'both' } }
    ],
    content_style: `
      body { max-width: 100%; }
      img { max-width: 100%; height: auto; display: block; margin: 10px 0; }
      p { margin: 0 0 1em 0; }
      .mce-content-body[data-mce-placeholder]:not(.mce-visualblocks)::before { 
        display: none; 
      }
    `,
    image_dimensions: false,
    image_class_list: [
      { title: 'Responsive', value: 'img-fluid' },
      { title: 'Left align', value: 'float-left me-3' },
      { title: 'Right align', value: 'float-right ms-3' },
      { title: 'No alignment', value: '' }
    ],
    image_advtab: true,
    image_caption: true,
    automatic_uploads: true,
    images_reuse_filename: true,
    paste_data_images: true,
    images_upload_url: '{{ route("admin.tinymce.upload") }}',
    automatic_uploads: true,
    images_upload_credentials: true,
    convert_urls: true,
    relative_urls: false,
    remove_script_host: false,
    file_picker_types: 'image',
    images_upload_handler: function (blobInfo, progress) {
      return new Promise((resolve, reject) => {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route("admin.tinymce.upload") }}');
        
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.setRequestHeader("Accept", "application/json");
        
        xhr.upload.onprogress = function (e) {
          progress(e.loaded / e.total * 100);
        };
        
        xhr.onload = function() {
          var json;
          
          if (xhr.status === 403) {
            reject('HTTP Error: ' + xhr.status);
            return;
          }
          
          if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
          }
          
          try {
            json = JSON.parse(xhr.responseText);
          } catch (e) {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
          }
          
          if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
          }
          
          resolve(json.location);
        };
        
        xhr.onerror = function () {
          reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('_token', token);
        
        xhr.send(formData);
      });
    },
    setup: function (editor) {
      editor.on('change', function () {
        editor.save();
      });
    }
  });
</script>
@endpush
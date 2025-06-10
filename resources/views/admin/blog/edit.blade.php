@extends('layouts.admin')

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0 text-dark">Edit Blog</h1></div>
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
                    
                  @if($blog->blog_image)
                  <div class="col-md-6">
                    <div class="form-group text-center">
                      <b class="d-block mb-3">Preview Blog Image</b>
                      <img src="{{ asset($blog->blog_image) }}" width="50%">
                    </div>
                  </div>
                  @endif
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Blog Image</label>
                      <input type="file" name="blog_image" class="form-control">
                    </div>
                  </div>

                  <hr class="w-100 border-bottom mb-5">

                  <div class="col-md-7">
                    <div class="form-group">
                      <label>Title <span style="color:red">*</span></label>
                      <input type="text" name="blog_title" class="form-control" required value="{{ $blog->blog_title }}">
                    </div>
                  </div>

                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Author Name</label>
                      <input type="text" name="blog_author" class="form-control" value="{{ $blog->blog_author }}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Short Description</label>
                      <textarea name="blog_short_description" class="form-control">{{ $blog->blog_short_description }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Meta Keywords</label>
                      <textarea name="blog_meta_keywords" class="form-control">{{ $blog->blog_meta_keywords }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Meta Description</label>
                      <textarea name="blog_meta_description" class="form-control">{{ $blog->blog_meta_description }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Content</label>
                      <textarea name="blog_content" class="form-control text-editor">{{ $blog->blog_content }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Select Category</label>
                      <select name="blog_category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($get_all_blog_category as $category)
                          <option value="{{ $category->id }}" {{ $blog->blog_category == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success float-right">Update</button>
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
@push('scripts')
<script src="https://cdn.tiny.cloud/1/p96sr398x0evyp69lvm9o2ieiuyexn462e38v64kghyfl7zy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
        // TinyMCE Init - fully featured toolbar (removed hr and toc)
    tinymce.init({
      selector: 'textarea.text-editor',
      height: 500,
      plugins: 'image media link code table lists advlist fullscreen preview anchor insertdatetime searchreplace wordcount charmap emoticons codesample visualblocks visualchars',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media codesample | table charmap emoticons | code visualblocks fullscreen preview',
      images_upload_url: '{{ url("/admin/tinymce/upload") }}',
      automatic_uploads: true,
      images_upload_credentials: true,
      convert_urls: true,
      relative_urls: false,
      remove_script_host: false,
      file_picker_types: 'image',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      setup: function (editor) {
        editor.on('change', function () {
          editor.save();
        });
      }
    });
</script>
@endpush
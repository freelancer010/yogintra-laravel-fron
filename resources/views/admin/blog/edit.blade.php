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
                  <div class="col-md-3">

                    @if($blog->blog_image)
                    <div class="form-group text-center">
                      <b class="d-block mb-3 text-left">Preview Blog Image</b>
                      <img src="{{ asset($blog->blog_image) }}" width="100%">
                    </div>
                    @endif

                    <div class="form-group">
                      <label for="blog_image">Blog Image</label>
                      <input type="file" name="blog_image" id="blog_image" class="form-control" accept="image/*">
                    </div>
                  
                    <hr class="w-100 border-bottom mb-5">

                    <div class="form-group">
                      <label for="blog_title">Title <span style="color:red">*</span></label>
                      <input id="blog_title" type="text" name="blog_title" class="form-control" required value="{{ old('blog_title', $blog->blog_title) }}">
                    </div>

                    <div class="form-group">
                      <label for="blog_author">Author Name</label>
                      <input id="blog_author" type="text" name="blog_author" class="form-control" value="{{ old('blog_author', $blog->blog_author) }}">
                    </div>

                    <div class="form-group">
                      <label for="blog_short_description">Short Description</label>
                      <textarea id="blog_short_description" name="blog_short_description" class="form-control" rows="3">{{ old('blog_short_description', $blog->blog_short_description) }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="blog_meta_keywords">Meta Keywords</label>
                      <textarea id="blog_meta_keywords" name="blog_meta_keywords" class="form-control" rows="3">{{ old('blog_meta_keywords', $blog->blog_meta_keywords) }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="blog_meta_description">Meta Description</label>
                      <textarea id="blog_meta_description" name="blog_meta_description" class="form-control" rows="3">{{ old('blog_meta_description', $blog->blog_meta_description) }}</textarea>
                    </div>

                    <div class="form-group">
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
                  </div>

                  <div class="col-md-9">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="editor">Content <span style="color:red">*</span></label>
                        <textarea name="blog_content" id="editor" class="form-control" rows="10">{!! old('blog_content', $blog->blog_content) !!}</textarea>
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
<link rel="stylesheet" href="{{ asset('ckeditor/style.css') }}">
<link rel="stylesheet" href="{{ asset('ckeditor/ckeditor/ckeditor5.css') }}">
@endpush

@push('scripts')
<script type="importmap">
  {
    "imports": {
      "ckeditor5": "../../../ckeditor/ckeditor/ckeditor5.js",
      "ckeditor5/": "./"
    }
  }
</script>
<script type="module" src="{{ asset('ckeditor/main.js') }}"></script>
<script>
 console.log( window.ClassicEditor.builtinPlugins.map( p => p.pluginName ) )
</script>
@endpush
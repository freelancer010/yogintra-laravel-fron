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
                      <label>Blog Image</label>
                      <input type="file" name="blog_image" class="form-control">
                    </div>
                  </div>

                  @if($blog->blog_image)
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Preview Blog Image</label>
                      <img src="{{ asset($blog->blog_image) }}" width="100px">
                    </div>
                  </div>
                  @endif

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

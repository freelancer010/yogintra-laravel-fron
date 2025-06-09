@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0 text-dark">Add Blog</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Blog</li>
                        <li class="breadcrumb-item active">Add Blog</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @include('admin.partials.flash') {{-- flash messages --}}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add New Blog</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.blog.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i> View All Blog
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    {{-- Title --}}
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Title <span class="text-danger">*</span>
                                                <small>(130–150 characters recommended)</small>
                                            </label>
                                            <input type="text" name="blog_title" class="form-control" id="title" required>
                                            <small>Characters Length: <span id="title-characters"></span> <span id="title-characterss"></span></small>
                                        </div>
                                    </div>

                                    {{-- Author --}}
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Author Name</label>
                                            <input type="text" name="blog_author" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Short Description --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Short Description</label>
                                            <textarea name="blog_short_description" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    {{-- Meta Keywords --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea name="blog_meta_keywords" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    {{-- Meta Description --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Meta Description
                                                <small>(155–160 characters recommended)</small>
                                            </label>
                                            <textarea name="blog_meta_description" class="form-control" id="textarea"></textarea>
                                            <small>Characters Length: <span id="characters"></span> <span id="characterss"></span></small>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="blog_content" class="form-control text-editor"></textarea>
                                        </div>
                                    </div>

                                    {{-- Category --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select Category</label>
                                            <select name="blog_category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach ($get_all_blog_category as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Image --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Blog Image <span class="text-danger">*</span> (690x460 px)</label>
                                            <input type="file" name="blog_image" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div> {{-- card-body --}}
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
    
    $('#textarea').on('input', updateMetaCount);
    $('#title').on('input', updateTitleCount);

    function updateMetaCount() {
        const len = $(this).val().length;
        $('#characters').text(len);
        updateFeedback(len, 155, 160, '#textarea', '#characterss');
    }

    function updateTitleCount() {
        const len = $(this).val().length;
        $('#title-characters').text(len);
        updateFeedback(len, 130, 150, '#title', '#title-characterss');
    }

    function updateFeedback(count, min, max, inputId, labelId) {
        if (count > max) {
            $(inputId).css('border-color', 'red');
            $(labelId).text('(Alert)').css('color', 'red');
        } else if (count >= min) {
            $(inputId).css('border-color', 'green');
            $(labelId).text('(Good)').css('color', 'green');
        } else {
            $(inputId).css('border-color', '#b48a0a');
            $(labelId).text('(Poor)').css('color', '#b48a0a');
        }
    }
</script>
@endpush

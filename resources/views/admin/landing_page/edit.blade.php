@extends('layouts.admin')

@section('content')

<section class="content">
<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
        <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Update Landing Page</h3>
        </div>

        <form action="{{ route('admin.landing-pages.update', $page->page_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group mb-5 border-bottom text-center pb-5">
                        <label>Page Image</label><br>
                        @if($page->page_image)
                            <img id="preview-image" src="{{ asset($page->page_image) }}" width="45%" alt="Page Image">
                            <span>File Name -  {{$page->page_image}}</span>
                        @endif
                        <input type="file" name="page_image" class="form-control w-50 m-auto" onchange="previewImage(event)">
                    </div>
                        
                    <div class="col-md-6 form-group">
                        <label>Page Name <span class="text-danger">*</span></label>
                        <input type="text" name="page_name" class="form-control" required value="{{ $page->page_name }}">
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Page URL</label>
                    <input type="text" name="page_title" class="form-control" required value="{{ $page->page_title }}">
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Meta Description</label>
                    <textarea name="page_meta_description" class="form-control">{{ $page->page_meta_description }}</textarea>
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Meta Keywords</label>
                    <textarea name="page_keywords" class="form-control">{{ $page->page_keywords }}</textarea>
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Meta Title</label>
                    <input type="text" name="page_meta_title" class="form-control" value="{{ $page->page_meta_title }}">
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Head Code</label>
                    <textarea name="page_head_code" class="form-control">{{ $page->page_head_code }}</textarea>
                    </div>

                    <div class="col-md-12 form-group">
                    <label>Heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_title" class="form-control" required value="{{ $page->page_image_title }}">
                    </div>

                    <div class="col-md-12 form-group">
                    <label>Sub-heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_description" class="form-control" required value="{{ $page->page_image_description }}">
                    </div>

                    <div class="col-md-12 form-group">
                    <label>Page Content</label>
                    <textarea name="page_content" class="form-control text-editor">{{ $page->page_content }}</textarea>
                    </div>

                    <div class="col-md-12">
                    <button type="submit" class="btn btn-success float-right">Update</button>
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
    
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
        const output = document.getElementById('preview-image');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endpush

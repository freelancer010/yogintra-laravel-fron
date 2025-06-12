@extends('layouts.admin')

@section('content')

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Add Landing Page</h3>
            </div>

            <form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>Page Name <span class="text-danger">*</span></label>
                    <input type="text" name="page_name" class="form-control" id="page_name" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Page URL</label>
                    <input type="text" name="page_title" class="form-control" id="page_slug" readonly>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Meta Description</label>
                    <textarea name="page_meta_description" class="form-control"></textarea>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Meta Keywords</label>
                    <textarea name="page_keywords" class="form-control"></textarea>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Meta Title</label>
                    <input type="text" name="page_meta_title" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Head Code</label>
                    <textarea name="page_head_code" class="form-control"></textarea>
                  </div>
                  <div class="col-md-12 form-group">
                    <label>Heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_title" class="form-control" required>
                  </div>
                  <div class="col-md-12 form-group">
                    <label>Sub-heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_description" class="form-control" required>
                  </div>
                  <div class="col-md-12 form-group">
                    <label>Content</label>
                    <textarea name="page_content" class="form-control text-editor"></textarea>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Page Image <span class="text-danger">*</span></label>
                    <input type="file" name="page_image" class="form-control" required>
                  </div>
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-success float-right">Add</button>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>

<script>
  document.getElementById("page_name").addEventListener("keyup", function () {
    const name = this.value.trim().toLowerCase().replace(/\s+/g, '-');
    const baseUrl = window.location.origin;
    document.getElementById("page_slug").value = `${baseUrl}/city/${name}`;
  });
</script>
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

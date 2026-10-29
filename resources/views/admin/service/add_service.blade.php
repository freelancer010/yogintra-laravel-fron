@extends('layouts.admin')

@section('content')
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h4>Add New Service</h4>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Service</a></li>
                  <li class="breadcrumb-item active">Add Service</li>
               </ol>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
               <div class="card card-default">
                  <div class="card-header">
                     <h3 class="card-title">Create New Service</h3>
                  </div>
                  <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Service Name <span class="text-danger">*</span></label>
                                 <input type="text" name="service_name" class="form-control" required>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Price</label>
                                 <input type="number" name="service_price" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Capacity</label>
                                 <input type="number" name="service_capacity" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Duration (Hours)</label>
                                 <input type="number" name="service_duration" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Category <span class="text-danger">*</span></label>
                                 <select name="service_category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{ $cat->service_cat_id }}">{{ $cat->service_cat_name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Service Image</label>
                                 <input type="file" name="service_image" class="form-control" accept="image/*">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="service_image_alt">Image Alt Text</label>
                                 <input id="service_image_alt" type="text" name="service_image_alt" class="form-control" maxlength="255" value="{{ old('service_image_alt') }}" placeholder="Describe what is shown in the image">
                                 <small class="form-text text-muted">Used by screen readers. Keep it short and describe the image’s purpose.</small>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="service_image_title">Image Title</label>
                                 <input id="service_image_title" type="text" name="service_image_title" class="form-control" maxlength="255" value="{{ old('service_image_title') }}" placeholder="Optional supporting image title">
                                 <small class="form-text text-muted">Optional text shown as supporting information when a visitor points to the image.</small>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Description</label>
                                 <textarea name="service_description" class="form-control text-editor" rows="4"></textarea>
                              </div>
                           </div>
                           <div class="col-md-12 mt-2">
                              <h5>SEO Metadata</h5>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="service_meta_title">Meta Title</label>
                                 <input id="service_meta_title" type="text" name="service_meta_title" class="form-control" maxlength="255" value="{{ old('service_meta_title') }}" placeholder="Search result title for this service">
                                 <small class="form-text text-muted">Recommended: 50–60 characters. Service name is used when blank.</small>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="service_meta_description">Meta Description</label>
                                 <textarea id="service_meta_description" name="service_meta_description" class="form-control" rows="3" maxlength="500" placeholder="Short summary for search results">{{ old('service_meta_description') }}</textarea>
                                 <small class="form-text text-muted">Recommended: 150–160 characters. The service description is used when blank.</small>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <button type="submit" class="btn btn-success float-right">Submit</button>
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

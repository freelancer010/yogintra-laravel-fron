@extends('layouts.admin')

@section('content')
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Section 2</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="#">Front Setting</a></li>
                  <li class="breadcrumb-item active">Section 2</li>
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
                     <h3 class="card-title">Head Section</h3>
                  </div>
                  <form action="{{ route('admin.front.section2.image.update') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Heading <span>*</span></label>
                                 <input type="text" name="os_image_heading" class="form-control" required value="{{ $service_heading->os_image_heading ?? '' }}">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Sub-Heading <span>*</span></label>
                                 <input type="text" name="os_image_sub_heading" class="form-control" required value="{{ $service_heading->os_image_sub_heading ?? '' }}">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Description <span>*</span> <small>(Use &lt;br&gt; for line breaks)</small></label>
                                 <textarea name="os_image_description" class="form-control text-editor" required>{{ $service_heading->os_image_description ?? '' }}</textarea>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Image</label>
                                 <input type="file" name="os_image_image" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Image Preview</label><br>
                                 @if(!empty($service_heading->os_image_image))
                                    <img src="{{ asset($service_heading->os_image_image) }}" width="100px">
                                 @endif
                              </div>
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

   <section class="content">
      <div class="container-fluid">
         <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">View All Content</h3>
               <div class="card-tools">
                  <button data-toggle="modal" data-target="#imageModal" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Content</button>
               </div>
            </div>
            <div class="card-body">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Heading</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($our_service as $key => $service)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><img src="{{ asset($service->os_image) }}" width="70px"></td>
                        <td>{{ $service->os_heading }}</td>
                        <td>
                           <div class="btn-group">
                              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Action
                              </button>
                              <div class="dropdown-menu">
                                 <a class="dropdown-item" href="{{ route('admin.front.section2.service.edit', $service->os_id) }}">
                                    <i class="fas fa-edit"></i> Edit
                                 </a>
                                 <div class="dropdown-divider"></div>
                                 <form action="{{ route('admin.front.section2.service.delete', $service->os_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                       <i class="fas fa-trash"></i> Delete
                                    </button>
                                 </form>
                              </div>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </section>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add New Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('admin.front.section2.service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label>Heading <span>*</span></label>
                  <input type="text" class="form-control" name="os_heading" required>
               </div>
               <div class="form-group">
                  <label>Image <span>*</span></label>
                  <input type="file" class="form-control" name="os_image" required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Add</button>
            </div>
         </form>
      </div>
   </div>
@endsection
@push('scripts')
<!-- TinyMCE CDN -->
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
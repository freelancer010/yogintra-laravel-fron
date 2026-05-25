@extends('layouts.admin')

@section('content')
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h4>Add Yoga Center</h4>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Yoga Center</a></li>
                  <li class="breadcrumb-item active">Add Yoga Center</li>
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
                     <h3 class="card-title">Add Yoga Center</h3>
                  </div>
                  <form action="{{ route('admin.yoga_centers.store') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row gy-3">
                           <div class="mt-3 col-md-12">
                              <div class="form-group">
                                 <label>Name <span class="required">*</span></label>
                                 <input type="text" name="center_name" class="form-control" placeholder="Enter Center Name" required>
                              </div>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>Select Country <span class="required">*</span></label>
                              <select class="form-control countries" name="center_country" required>
                                 <option value="">Select A Country</option>
                              </select>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>Select State <span class="required">*</span></label>
                              <select class="form-control states" name="center_state" required>
                                 <option value="">Select your Country First</option>
                              </select>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>Select City <span class="required">*</span></label>
                              <select class="form-control cities" name="center_city" required>
                                 <option value="">Select your state first</option>
                              </select>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>Address <span class="required">*</span></label>
                              <input class="form-control" name="center_address" required placeholder="Enter Address">
                           </div>

                           <div class="mt-3 col-md-12">
                              <label>Add Map Link <small>(Add Map Link into iframe tag)</small></label>
                              <textarea class="form-control" name="map_link" placeholder="Enter Map Link"></textarea>
                           </div>

                           <div class="mt-3 col-md-6">
                              <label>Page Title</label>
                              <input type="text" class="form-control" name="page_title" placeholder="Enter Page Title">
                           </div>

                           <div class="mt-3 col-md-6">
                              <label>Page Meta Title</label>
                              <input type="text" class="form-control" name="page_meta_title" placeholder="Enter Page Meta Title">
                           </div>

                           <div class="mt-3 col-md-6">
                              <label>Page Slug</label>
                              <input type="text" class="form-control" name="page_Slug" placeholder="Enter Page Slug">
                           </div>

                           <div class="mt-3 col-md-6">
                              <label>Page Meta Keywords <small>(Separate by Comma)</small></label>
                              <textarea class="form-control" name="page_keywords" placeholder="Enter Meta Keywords"></textarea>
                           </div>

                           <div class="mt-3 col-md-12">
                              <label>Page Meta Description</label>
                              <textarea class="form-control" name="page_meta_description" placeholder="Enter Meta Description"></textarea>
                           </div>

                           <div class="mt-3 col-md-6">
                              <label>Mobile Number</label>
                              <input type="text" class="form-control" name="mobile_number" placeholder="Enter Mobile Number">
                           </div>

                           <div class="mt-3 col-md-6">
                              <label>Email Address</label>
                              <input type="email" class="form-control" name="email_address" placeholder="Enter Email Address">
                           </div>

                           <div class="mt-3 col-md-12">
                              <label>Description</label>
                              <textarea name="center_description" class="form-control text-editor" placeholder="Enter Description"></textarea>
                           </div>

                           <div class="mt-3 col-md-4">
                              <label>Center Image <span class="required">*</span></label>
                              <input type="file" name="center_image" class="form-control" required>
                           </div>

                           <div class="mt-3 col-md-12">
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
    
   function ajaxCall() {
      this.send = function(data, url, method, success, type = 'json') {
         $.ajax({
            url, method, data, dataType: type,
            success,
            error: function(xhr, ajaxOptions, thrownError) {
               console.error(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },
            timeout: 60000
         });
      }
   }

   function locationInfo() {
      var rootUrl = "https://geodata.phplift.net/api/index.php";
      var call = new ajaxCall();

      this.getCities = function(id) {
         $(".cities option:gt(0)").remove();
         const url = `${rootUrl}?type=getCities&stateId=${id}`;
         $('.cities').find("option:eq(0)").html("Please wait..");
         call.send({}, url, "post", function(data) {
            $('.cities').find("option:eq(0)").html("Select City");
            $.each(data.result, function(_, val) {
               $('.cities').append(`<option value='${val.name}'>${val.name}</option>`);
            });
            $(".cities").prop("disabled", false);
         });
      };

      this.getStates = function(id) {
         $(".states option:gt(0), .cities option:gt(0)").remove();
         const url = `${rootUrl}?type=getStates&countryId=${id}`;
         $('.states').find("option:eq(0)").html("Please wait..");
         call.send({}, url, "post", function(data) {
            $('.states').find("option:eq(0)").html("Select State");
            $.each(data.result, function(_, val) {
               $('.states').append(`<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`);
            });
            $(".states").prop("disabled", false);
         });
      };

      this.getCountries = function() {
         const url = `${rootUrl}?type=getCountries`;
         $('.countries').find("option:eq(0)").html("Please wait..");
         call.send({}, url, "post", function(data) {
            $('.countries').find("option:eq(0)").html("Select Country");
            $.each(data.result, function(_, val) {
               $('.countries').append(`<option value='${val.name}' countryid='${val.id}'>${val.name}</option>`);
            });
         });
      };
   }

   $(function() {
      var loc = new locationInfo();
      loc.getCountries();
      $(".countries").on("change", function() {
         var countryId = $("option:selected", this).attr('countryid');
         countryId ? loc.getStates(countryId) : $(".states option:gt(0)").remove();
      });
      $(".states").on("change", function() {
         var stateId = $("option:selected", this).attr('stateid');
         stateId ? loc.getCities(stateId) : $(".cities option:gt(0)").remove();
      });
   });
</script>
@endpush

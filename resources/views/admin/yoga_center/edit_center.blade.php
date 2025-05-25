@extends('layouts.admin')

@section('content')
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h4>Edit Yoga Center</h4>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Yoga Center</a></li>
                  <li class="breadcrumb-item active">Edit Yoga Center</li>
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
                     <h3 class="card-title">Update Yoga Center</h3>
                  </div>
                  <form action="{{ route('admin.yoga_centers.update', $center->center_id) }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                     <div class="card-body">
                        <div class="row gy-4">
                           <div class="mt-3 col-md-12">
                              <label>Name</label>
                              <input type="text" name="center_name" class="form-control" value="{{ $center->center_name }}" required>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>Country</label>
                              <input type="text" name="center_country" class="form-control" value="{{ $center->center_country }}" required>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>State</label>
                              <input type="text" name="center_state" class="form-control" value="{{ $center->center_state }}" required>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>City</label>
                              <input type="text" name="center_city" class="form-control" value="{{ $center->center_city }}" required>
                           </div>
                           <div class="mt-3 col-md-3">
                              <label>Address</label>
                              <input type="text" name="center_address" class="form-control" value="{{ $center->center_address }}" required>
                           </div>
                           <div class="mt-3 col-md-12">
                              <label>Map Link</label>
                              <textarea name="map_link" class="form-control text-editor">{{ $center->map_link }}</textarea>
                           </div>
                           <div class="mt-3 col-md-6">
                              <label>Page Title</label>
                              <input type="text" name="page_title" class="form-control" value="{{ $center->page_title }}">
                           </div>
                           <div class="mt-3 col-md-6">
                              <label>Meta Title</label>
                              <input type="text" name="page_meta_title" class="form-control" value="{{ $center->page_meta_title }}">
                           </div>
                           <div class="mt-3 col-md-6">
                              <label>Page Slug</label>
                              <input type="text" name="page_Slug" class="form-control" value="{{ $center->page_Slug }}">
                           </div>
                           <div class="mt-3 col-md-6">
                              <label>Meta Keywords</label>
                              <textarea name="page_keywords" class="form-control">{{ $center->page_keywords }}</textarea>
                           </div>
                           <div class="mt-3 col-md-12">
                              <label>Meta Description</label>
                              <textarea name="page_meta_description" class="form-control">{{ $center->page_meta_description }}</textarea>
                           </div>
                           <div class="mt-3 col-md-6">
                              <label>Mobile Number</label>
                              <input type="text" name="mobile_number" class="form-control" value="{{ $center->mobile_number }}">
                           </div>
                           <div class="mt-3 col-md-6">
                              <label>Email Address</label>
                              <input type="email" name="email_address" class="form-control" value="{{ $center->email_address }}">
                           </div>
                           <div class="mt-3 col-md-12">
                              <label>Description</label>
                              <textarea name="center_description" class="form-control text-editor">{{ $center->center_description }}</textarea>
                           </div>
                           <div class="mt-3 col-md-4">
                              <label>Center Image</label>
                              <input type="file" name="center_image" class="form-control">
                              @if($center->center_image)
                                 <img src="{{ asset($center->center_image) }}" width="80" class="mt-2">
                              @endif
                           </div>
                           <div class="mt-3 col-md-12">
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
      this.send = function(data, url, method, success, type) {
         type = 'json';
         var successRes = function(data) {
            success(data);
         }
         var errorRes = function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
         }
         jQuery.ajax({
            url: url,
            type: method,
            data: data,
            success: successRes,
            error: errorRes,
            dataType: type,
            timeout: 60000
         });
      }
   }

   function locationInfo() {
      var rootUrl = "https://geodata.phplift.net/api/index.php";
      var call = new ajaxCall();

      this.getCities = function(id) {
         jQuery(".cities option:gt(0)").remove();
         var url = rootUrl + '?type=getCities&stateId=' + id;
         var method = "post";
         var data = {};
         jQuery('.cities').find("option:eq(0)").html("Please wait..");
         call.send(data, url, method, function(data) {
            jQuery('.cities').find("option:eq(0)").html("Select City");
            if (data['result']) {
               jQuery.each(data['result'], function(key, val) {
                  var option = `<option value='${val.name}'>${val.name}</option>`;
                  jQuery('.cities').append(option);
               });
            }
         });
      };

      this.getStates = function(id) {
         jQuery(".states option:gt(0)").remove();
         jQuery(".cities option:gt(0)").remove();
         var url = rootUrl + '?type=getStates&countryId=' + id;
         var method = "post";
         var data = {};
         jQuery('.states').find("option:eq(0)").html("Please wait..");
         call.send(data, url, method, function(data) {
            jQuery('.states').find("option:eq(0)").html("Select State");
            if (data['result']) {
               jQuery.each(data['result'], function(key, val) {
                  var option = `<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`;
                  jQuery('.states').append(option);
               });
            }
         });
      };

      this.getCountries = function() {
         var url = rootUrl + '?type=getCountries';
         var method = "post";
         var data = {};
         jQuery('.countries').find("option:eq(0)").html("Please wait..");
         call.send(data, url, method, function(data) {
            jQuery('.countries').find("option:eq(0)").html("Select Country");
            if (data['result']) {
               jQuery.each(data['result'], function(key, val) {
                  var option = `<option value='${val.name}' countryid='${val.id}'>${val.name}</option>`;
                  jQuery('.countries').append(option);
               });
            }
         });
      };
   }

   jQuery(function() {
      var loc = new locationInfo();
      loc.getCountries();

      jQuery(".countries").on("change", function() {
         var countryId = jQuery("option:selected", this).attr('countryid');
         if (countryId != '') {
            loc.getStates(countryId);
         } else {
            jQuery(".states option:gt(0)").remove();
         }
      });

      jQuery(".states").on("change", function() {
         var stateId = jQuery("option:selected", this).attr('stateid');
         if (stateId != '') {
            loc.getCities(stateId);
         } else {
            jQuery(".cities option:gt(0)").remove();
         }
      });
   });
</script>
@endpush
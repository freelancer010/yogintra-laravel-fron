@extends('layouts.admin') {{-- or your layout file --}}

@section('content')
<!-- Content Wrapper. Contains page content -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h4>Edit Blog Category</h4>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Blog</a></li>
                  <li class="breadcrumb-item active">Edit Blog Category</li>
               </ol>
            </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="container-fluid">
      @include('admin.partials.flash')

         <div class="row">
            <div class="col-sm-12">
               <div class="card card-default">
                  <div class="card-header">
                     <h3 class="card-title">Update Blog Category</h3>
                  </div>

                  <form action="{{ route('admin.blog_category.update', $category->id) }}" method="POST">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="col-form-label">Category Name <span class="required">*</span></label>
                                 <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required value="{{ old('category_name', $category->category_name) }}">
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="col-form-label">Category Meta Keywords</label>
                                 <textarea name="category_keyword" class="form-control" placeholder="Enter Meta Keywords">{{ old('category_keyword', $category->category_keyword) }}</textarea>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="col-form-label">Category Meta Description</label>
                                 <textarea name="category_description" class="form-control" placeholder="Enter Meta Description">{{ old('category_description', $category->category_description) }}</textarea>
                              </div>
                           </div>

                           <div class="col-md-12">
                              <div class="form-group text-right">
                                 <button type="submit" class="btn btn-success">Update</button>
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

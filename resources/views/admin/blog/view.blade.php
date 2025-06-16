@extends('layouts.admin')

@section('content')
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">All Blogs</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="#">Blog</a></li>
                  <li class="breadcrumb-item active">All Blogs</li>
               </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
      <div class="container-fluid">
         <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">View All Blogs</h3>
               <div class="card-tools">
                  <a href="{{ route('admin.blog.create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New Blog</a>
               </div>
            </div>

            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>Image</th>
                        <th>Blog Title</th>
                        <th>Category</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($get_all_blog as $post)
                        <tr>
                           <td>
                              <img src="{{ asset($post->blog_image) }}" width="100px">
                           </td>
                           <td>
                              {{ $post->blog_title }}
                              @if($post->blog_author)
                                 <br/>
                                 <b>Auth:</b> {{ $post->blog_author }}
                              @endif
                           </td>
                           <td>{{ $post->category->category_name ?? 'N/A' }}</td>
                           <td>
                              <div class="input-group-prepend">
                                 <a class="dropdown-item" href="{{ route('admin.blog.edit', $post->blog_id) }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i> Edit
                                 </a>
                                 <div class="dropdown-divider"></div>
                                 <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ route('admin.blog.delete', $post->blog_id) }}">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                 </a>
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
@endsection
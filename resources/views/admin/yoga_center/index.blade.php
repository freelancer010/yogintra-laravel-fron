@extends('layouts.admin')

@section('content')
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h4>All Yoga Center</h4>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item">Yoga Center</li>
                  <li class="breadcrumb-item active">All Yoga Center</li>
               </ol>
            </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="container-fluid">
         <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">View All Yoga Center</h3>
               <div class="card-tools">
                  <a href="{{ route('admin.yoga_centers.create') }}" class="btn btn-success btn-sm">
                     <i class="fa fa-plus" aria-hidden="true"></i> Add Center
                  </a>
               </div>
            </div>
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($centers as $i => $center)
                     <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><img src="{{ asset($center->center_image) }}" width="50px"></td>
                        <td>{{ $center->center_name }}</td>
                        <td>{{ $center->center_address }}, {{ $center->center_city }}, {{ $center->center_state }}, {{ $center->center_country }}</td>
                        <td>
                           <a href="{{ route('admin.yoga_centers.edit', $center->center_id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <form action="{{ route('admin.yoga_centers.destroy', $center->center_id) }}" method="POST" style="display:inline-block;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                 <i class="fas fa-trash"></i>
                              </button>
                           </form>
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

@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@include('admin.partials.flash')

<div class="content-wrapper m-0">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6 col-12">
               <h1 class="m-0">Dashboard</h1>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-3 col-6">
               <div class="small-box bg-info">
                  <div class="inner">
                     <h3>{{ $eventCount }}</h3>
                     <p>Total Events</p>
                  </div>
                  <div class="icon">
                     <i class="fa fa-calendar"></i>
                  </div>
                  <a href="{{ url('/admin/event/view_all_event') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <div class="small-box bg-primary">
                  <div class="inner">
                     <h3>{{ $serviceCount }}</h3>
                     <p>Total Service</p>
                  </div>
                  <div class="icon">
                     <i class="fa fa-wrench"></i>
                  </div>
                  <a href="{{ url('/admin/service/all_service') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <div class="small-box bg-warning">
                  <div class="inner">
                     <h3>{{ $yogaCenterCount }}</h3>
                     <p>Total Yoga Center</p>
                  </div>
                  <div class="icon">
                     <i class="fa fa-building"></i>
                  </div>
                  <a href="{{ url('/admin/yoga_center/view_all_yoga_center') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <div class="small-box bg-success">
                  <div class="inner">
                     <h3>{{ $blogCount }}</h3>
                     <p>Total Blog</p>
                  </div>
                  <div class="icon">
                     <i class="fab fa-blogger"></i>
                  </div>
                  <a href="{{ url('/admin/blog/view_all_post') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <a href="{{ route('sitemap.generate') }}" class="btn btn-success">Generate Sitemap</a>
         </div>
      </div>
   </section>
</div>
@endsection

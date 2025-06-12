@extends('layouts.admin')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>View All Booking</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Event</a></li>
            <li class="breadcrumb-item active">All Event Booking</li>
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
              <h3 class="card-title">View All Event Booking</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Addon</th>
                    <th>Ticket</th>
                    <th>Event Name</th>
                    <th>Booking Price</th>
                    <th>Payment ID</th>
                    <th>Booking Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($all_booking as $i => $booking)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $booking->booking_name }}</td>
                    <td>
                      <span class="badge badge-warning"><i class="fa fa-envelope"></i> {{ $booking->booking_email_id }}</span><br>
                      <span class="badge badge-success"><i class="fa fa-phone"></i> {{ $booking->booking_phone_no }}</span>
                    </td>
                    <td>
                      @if(empty($booking->booking_addon))
                        <li><b>1.</b> No Addon</li>
                        <hr/>
                      @else
                      <ul class="list-unstyled">
                        @foreach(json_decode($booking->booking_addon ?? '[]') as $index => $addonIndex)
                          <li><b>{{ $index + 1 }}.</b> {{ json_decode($booking->addon_name)[$addonIndex] ?? 'N/A' }}</li>
                          <hr/>
                        @endforeach
                      </ul>
                      @endif
                    </td>
                    <td>
                      {{ $booking->booking_ticket == 1 ? 'Indian Student' : 'Foreigner Student' }}
                    </td>
                    <td>{{ $booking->title }} ({{ $booking->category }})</td>
                    <td>&#8377;{{ $booking->booking_price }}</td>
                    <td>{{ $booking->booking_pay_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
    $('#example1').DataTable();
  });
</script>
@endpush

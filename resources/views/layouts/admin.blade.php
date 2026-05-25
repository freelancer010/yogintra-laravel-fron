<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $app_setting->app_name ?? 'Yogintra' }} | Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset($app_setting->fevicon ?? 'favicon.png') }}">

  <!-- AdminLTE + Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <!-- ✨ Custom UI Styling -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8fafc;
      font-size: 15px;
      color: #1e293b;
    }

    /* Sidebar */
    .main-sidebar {
      background-color: #ffffff !important;
      border-right: 1px solid #e5e7eb;
    }

    .brand-link {
      padding: 1rem;
      font-weight: bold;
      font-size: 1.1rem;
      color: #0f172a !important;
      text-align: center;
    }

    .nav-sidebar .nav-link {
      color: #334155 !important;
      transition: all 0.2s ease;
      font-weight: 500;
    }

    .nav-sidebar .nav-link:hover,
    .nav-sidebar .nav-link.active {
      background-color: #e0f2fe !important;
      color: #0c4a6e !important;
    }

    /* Navbar */
    .main-header {
      background-color: #ffffff !important;
      border-bottom: 1px solid #e5e7eb;
      padding: 0.5rem 1rem;
    }

    /* Cards */
    .card {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .card-title {
      font-size: 1rem;
      font-weight: 600;
      border-bottom: 1px solid #e2e8f0;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
    }

    /* Buttons */
    .btn {
      border-radius: 6px !important;
      transition: all 0.2s ease;
    }

    .btn:hover {
      transform: scale(1.03);
    }

    .btn-sm i {
      margin-right: 4px;
    }

    .add-btn {
      background-color: #3b82f6;
      color: white;
      font-size: 14px;
      padding: 6px 14px;
    }

    .add-btn:hover {
      background-color: #2563eb;
      box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    }

    /* Table */
    table tr:hover {
      background-color: #f1f5f9;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9fafb;
    }

    .table th, .table td {
      vertical-align: middle !important;
    }

    /* Pills */
    .status-pill {
      padding: 4px 10px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 13px;
    }

    .status-pill.On {
      background-color: #22c55e;
      color: white;
    }

    .status-pill.Off {
      background-color: #ef4444;
      color: white;
    }

    /* Breadcrumb */
    .breadcrumb {
      background: transparent !important;
      font-size: 13px;
      padding: 0;
      margin-bottom: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
      content: '>';
      padding: 0 5px;
      color: #9ca3af;
    }
  </style>

  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')

    <div class="content-wrapper p-4">
      @yield('content')
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#example1').DataTable({
        pageLength: 10
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
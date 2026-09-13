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

  <!-- Shared admin design system -->
  <style>
    :root {
      --admin-ink: #183c45;
      --admin-muted: #6b7f86;
      --admin-accent: #0f7c87;
      --admin-accent-dark: #0b606a;
      --admin-accent-soft: #e7f6f6;
      --admin-border: #dce8eb;
      --admin-surface: #ffffff;
      --admin-canvas: #f3f7f8;
      --admin-radius: 14px;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--admin-canvas);
      font-size: 15px;
      color: var(--admin-ink);
    }

    .content-wrapper {
      background: var(--admin-canvas);
      min-height: calc(100vh - 57px) !important;
    }

    .content-header h1, .content-header .m-0 { color: var(--admin-ink); font-weight: 700; letter-spacing: -.025em; }
    .admin-listing-heading { display: flex; align-items: center; flex-wrap: wrap; gap: .75rem; }
    .admin-listing-heading .admin-listing-action { margin: 0; }

    /* Sidebar */
    .main-sidebar {
      background: var(--admin-surface) !important;
      border-right: 1px solid var(--admin-border);
      box-shadow: 10px 0 28px rgba(18, 57, 67, .045);
    }

    .main-sidebar .brand-link {
      position: relative !important;
      display: flex !important;
      align-items: center;
      justify-content: center;
      height: 70px;
      padding: .8rem 1rem;
      font-weight: bold;
      font-size: 1.1rem;
      color: var(--admin-ink) !important;
      text-align: center;
      border-bottom: 1px solid var(--admin-border) !important;
      background: #fff !important;
    }

    .main-sidebar .brand-link img { display: block; width: auto; max-height: 44px; max-width: 180px; object-fit: contain; }
    .main-sidebar .sidebar { margin-top: 0 !important; padding-top: 0 !important; }
    .main-sidebar .sidebar > nav { margin-top: 0 !important; padding-top: 4px; }
    .user-panel { margin: 14px 12px !important; padding: 12px !important; border: 1px solid var(--admin-border) !important; border-radius: 12px; background: #f9fcfc; }
    .user-panel .image img { border: 2px solid #d5eeee; box-shadow: none !important; }
    .sidebar-user-avatar { display:inline-flex; align-items:center; justify-content:center; width:35px; height:35px; border-radius:50%; background:var(--admin-accent); color:#fff; font-size:13px; font-weight:700; }

    .nav-sidebar .nav-link {
      color: #537078 !important;
      margin: 3px 10px;
      width: calc(100% - 20px);
      max-width: calc(100% - 20px);
      box-sizing: border-box;
      padding: .72rem .85rem;
      border-radius: 9px;
      transition: background .18s ease, color .18s ease, transform .18s ease;
      font-weight: 600;
      font-size: 13px;
    }

    .nav-sidebar .nav-link:hover,
    .nav-sidebar .nav-link.active {
      background: var(--admin-accent-soft) !important;
      color: var(--admin-accent-dark) !important;
      transform: translateX(2px);
    }

    .nav-sidebar .nav-treeview .nav-link { font-size: 12.5px; font-weight: 500; padding-left: 1.25rem; }
    .main-sidebar .nav-sidebar { padding-right: 10px; box-sizing: border-box; }
    .main-sidebar .nav-sidebar .nav-link { width: calc(100% - 20px); max-width: calc(100% - 20px); }
    .nav-sidebar .nav-icon { color: var(--admin-accent); }

    /* Navbar */
    .main-header {
      background: rgba(255,255,255,.94) !important;
      border-bottom: 1px solid var(--admin-border);
      box-shadow: 0 4px 18px rgba(22, 62, 71, .04);
      padding: .45rem 1rem;
      backdrop-filter: blur(10px);
    }

    .main-header .nav-link { color: var(--admin-ink) !important; border-radius: 8px; }
    .main-header .nav-link:hover { background: var(--admin-accent-soft); }
    .main-header .btn { margin: 0; }
    .admin-profile-trigger { min-height: 42px; padding: 5px 9px !important; }
    .admin-navbar-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #cfeaec; box-shadow: 0 2px 7px rgba(15, 124, 135, .15); }
    .admin-navbar-avatar-fallback { display: inline-flex; align-items: center; justify-content: center; background: var(--admin-accent); color: #fff; font-size: 13px; font-weight: 700; }
    .admin-profile-meta { flex-direction: column; line-height: 1.12; min-width: 100px; }
    .admin-profile-meta strong { color: var(--admin-ink); font-size: 12px; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .admin-profile-meta small { color: var(--admin-muted); font-size: 10.5px; margin-top: 2px; }

    /* Cards */
    .card {
      background: var(--admin-surface);
      border: 1px solid var(--admin-border);
      border-radius: var(--admin-radius);
      box-shadow: 0 10px 28px rgba(25, 62, 71, .055);
      overflow: hidden;
    }

    .card-header { background: transparent; border-bottom: 1px solid var(--admin-border); padding: 1rem 1.15rem; }
    .card-body { padding: 1.15rem; }

    .card-title {
      font-size: 1.05rem;
      font-weight: 600;
      color: var(--admin-ink);
      border: 0;
      margin: 0;
      padding: 0;
    }

    /* Buttons */
    .btn {
      border-radius: 8px !important;
      font-weight: 600;
      transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 5px 14px rgba(24, 60, 69, .14);
    }

    .btn-primary, .btn-success { background-color: var(--admin-accent); border-color: var(--admin-accent); }
    .btn-primary:hover, .btn-success:hover { background-color: var(--admin-accent-dark); border-color: var(--admin-accent-dark); }
    .btn-outline-primary, .btn-outline-success { color: var(--admin-accent-dark); border-color: #85c9cf; }
    .btn-outline-primary:hover, .btn-outline-success:hover { background: var(--admin-accent); border-color: var(--admin-accent); }
    .btn-group:not(.btn-group-toggle) { display: inline-flex; align-items: center; flex-wrap: wrap; gap: 8px; }
    .btn-group:not(.btn-group-toggle) > .btn,
    .btn-group:not(.btn-group-toggle) > .btn-group,
    .btn-group:not(.btn-group-toggle) > form > .btn {
      margin: 0 !important;
      border-radius: 8px !important;
    }

    .btn-sm i {
      margin-right: 4px;
    }

    .add-btn {
      background-color: var(--admin-accent);
      color: white;
      font-size: 14px;
      padding: 6px 14px;
    }

    .add-btn:hover {
      background-color: var(--admin-accent-dark);
      box-shadow: 0 5px 14px rgba(15, 124, 135, .22);
    }

    /* Forms and tables */
    .form-control, .custom-select, .select2-container--default .select2-selection--single {
      border: 1px solid #cbdde1;
      border-radius: 8px;
      min-height: 35px;
      padding: .35rem .65rem;
      font-size: 13px;
      color: var(--admin-ink);
      box-shadow: none;
    }
    textarea.form-control { min-height: 82px; line-height: 1.45; }
    .input-group-text { min-height: 35px; padding: .35rem .65rem; font-size: 13px; border-color: #cbdde1; background: #f6fbfb; color: var(--admin-muted); }
    .form-control:focus, .custom-select:focus {
      border-color: var(--admin-accent);
      box-shadow: 0 0 0 3px rgba(15, 124, 135, .12);
    }
    .form-group { margin-bottom: .85rem; }
    label, .col-form-label { color: #44646c; font-weight: 600; font-size: 12px; margin-bottom: .35rem; }
    .form-text, .invalid-feedback { font-size: 11.5px; }
    /* Data tables: compact, borderless records in a clean white data card. */
    .card-body:has(> table.table), .card-body:has(> .dataTables_wrapper) {
      background: transparent;
      padding: 1.25rem;
    }
    .table, .dataTables_wrapper > .table {
      border-collapse: separate;
      border-spacing: 0;
      margin: 0;
      background: #fff;
      border: 0 !important;
      border: 1px solid var(--admin-border) !important;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(24, 60, 69, .045);
    }
    .table.table-bordered th, .table.table-bordered td { border: 0 !important; }
    .table thead th {
      background: #f7f9fd;
      border: 0;
      color: #687586;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .035em;
      text-transform: uppercase;
      padding: .85rem 1rem;
      white-space: nowrap;
    }
    .table td { border: 0; padding: .82rem 1rem; color: #596779; font-size: 12px; }
    .table tbody tr { transition: background .16s ease; }
    .table tbody tr + tr td { border-top: 1px solid #f0f3f8; }
    .table tbody tr:hover { background: #f7faff; }
    .table-striped tbody tr:nth-of-type(odd) { background: #fff; }
    .table-responsive { border: 0; border-radius: 5px; box-shadow: none; background: transparent; }
    .table td:last-child { white-space: nowrap; }
    .table td > .btn, .table td > form, .table td > .btn-group, .table td > .btn-group-sm { display: inline-flex; vertical-align: middle; margin: 2px 7px 2px 0; }
    .table td > form .btn { margin: 0; }
    .table .table-action {
      align-items: center;
      justify-content: center;
      min-width: 36px;
      min-height: 34px;
      padding: .42rem .6rem;
      border-radius: 8px !important;
      box-shadow: none;
    }
    .table .table-action.btn-primary, .table .table-action.btn-info {
      background: var(--admin-accent-soft);
      border: 1px solid #a8dadd;
      color: var(--admin-accent-dark);
    }
    .table .table-action.btn-primary:hover, .table .table-action.btn-info:hover { background: var(--admin-accent); border-color: var(--admin-accent); color: #fff; }
    .table .table-action.btn-danger { background: #fff4f4; border: 1px solid #f2c4c4; color: #b73b3b; }
    .table .table-action.btn-danger:hover { background: #c74444; border-color: #c74444; color: #fff; }
    .table .dropdown-toggle.table-action { background: #f5f9f9; border: 1px solid var(--admin-border); color: var(--admin-ink); }

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

    .pagination .page-link { border: 0; border-radius: 7px; margin: 0 2px; color: var(--admin-accent-dark); }
    .pagination .page-item.active .page-link { background: var(--admin-accent); }
    .dropdown-menu { border: 1px solid var(--admin-border); border-radius: 10px; box-shadow: 0 12px 28px rgba(24, 60, 69, .12); padding: 6px; }
    .dropdown-item { border-radius: 6px; font-size: 13px; padding: .55rem .7rem; }
    .dropdown-item:hover { background: var(--admin-accent-soft); color: var(--admin-accent-dark); }
    .dropdown-item:has(.fa-edit), .dropdown-item:has(.fas.fa-edit) { color: var(--admin-accent-dark); }
    .dropdown-item.text-danger { color: #b73b3b !important; }
    .modal-content { border: 0; border-radius: var(--admin-radius); box-shadow: 0 20px 50px rgba(16, 49, 57, .2); overflow: hidden; }
    .modal-header, .modal-footer { border-color: var(--admin-border); }
    .alert { border: 0; border-radius: 10px; }
    .dataTables_wrapper { padding: .15rem 0; }
    .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length { margin: 0 0 1rem; color: var(--admin-muted); font-size: 13px; }
    .dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select { border: 1px solid #cbdde1; border-radius: 8px; padding: 6px 9px; margin-left: 7px; background: #fff; }
    .dataTables_wrapper .dataTables_info { color: var(--admin-muted); font-size: 13px; padding-top: 1rem; }
    .dataTables_wrapper .dataTables_paginate { padding-top: .65rem; }
    .admin-success-toast {
      position: fixed;
      z-index: 1085;
      top: 20px;
      right: 22px;
      display: flex;
      align-items: center;
      gap: 12px;
      width: min(390px, calc(100vw - 32px));
      padding: 14px 14px 14px 16px;
      color: #fff;
      background: linear-gradient(135deg, #0b606a, #118b96);
      border-radius: 12px;
      box-shadow: 0 14px 32px rgba(11, 96, 106, .28);
      animation: adminToastIn .42s cubic-bezier(.2,.9,.25,1) both;
    }
    .admin-success-toast.is-leaving { animation: adminToastOut .3s ease forwards; }
    .admin-success-toast__icon { display: inline-flex; flex: 0 0 30px; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,.18); font-size: 16px; font-weight: 800; }
    .admin-success-toast__message { flex: 1; font-size: 13px; font-weight: 600; line-height: 1.35; }
    .admin-success-toast__close { appearance: none; border: 0; background: transparent; color: #fff; opacity: .85; font-size: 22px; line-height: 1; cursor: pointer; padding: 0 2px; }
    .admin-success-toast__close:hover { opacity: 1; }
    .admin-success-toast::after { content: ''; position: absolute; left: 16px; right: 16px; bottom: 7px; height: 2px; border-radius: 2px; background: rgba(255,255,255,.85); transform-origin: left; animation: adminToastProgress 4.5s linear forwards; }
    @keyframes adminToastIn { from { opacity: 0; transform: translateY(-12px) translateX(18px); } to { opacity: 1; transform: translateY(0) translateX(0); } }
    @keyframes adminToastOut { to { opacity: 0; transform: translateY(-8px) translateX(18px); } }
    @keyframes adminToastProgress { to { transform: scaleX(0); } }

    /* Two-colour dashboard and utility palette: navy + teal. */
    .small-box {
      border-radius: var(--admin-radius);
      overflow: hidden;
      box-shadow: 0 10px 24px rgba(24, 60, 69, .14);
      border: 0;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .small-box:hover { transform: translateY(-3px); box-shadow: 0 16px 30px rgba(24, 60, 69, .2); }
    .small-box.bg-info, .small-box.bg-warning { background: linear-gradient(135deg, var(--admin-accent), #1499a4) !important; color: #fff !important; }
    .small-box.bg-primary, .small-box.bg-success { background: linear-gradient(135deg, var(--admin-ink), #285a67) !important; color: #fff !important; }
    .small-box > .inner { padding: 14px 16px 10px; }
    .small-box h3 { font-size: 2rem; font-weight: 700; letter-spacing: -.05em; margin-bottom: 6px; }
    .small-box p { font-size: .82rem; font-weight: 600; opacity: .92; margin-bottom: 0; }
    .small-box .icon { color: rgba(255,255,255,.18) !important; }
    .small-box .icon > i { font-size: 52px; top: 12px; }
    .small-box .small-box-footer { background: rgba(0,0,0,.14); padding: 7px; font-size: .84rem; font-weight: 600; transition: background .18s ease; }
    .small-box .small-box-footer:hover { background: rgba(0,0,0,.24); color: #fff; }

    .bg-light, .card.bg-light { background: #f7fbfb !important; color: var(--admin-ink) !important; }
    .bg-secondary, .card.bg-secondary { background: var(--admin-ink) !important; color: #fff !important; }
    .bg-dark, .card.bg-dark { background: var(--admin-ink) !important; }
    .btn-info, .btn-warning, .btn-secondary { background: var(--admin-ink); border-color: var(--admin-ink); color: #fff; }
    .btn-info:hover, .btn-warning:hover, .btn-secondary:hover { background: #102f37; border-color: #102f37; color: #fff; }
    .badge-success, .badge-info, .badge-primary { background: var(--admin-accent); color: #fff; }
    .badge-warning, .badge-secondary { background: var(--admin-ink); color: #fff; }
    .status-pill.On { background: var(--admin-accent); }
    .status-pill.Off { background: var(--admin-ink); }
    .text-success, .text-info { color: var(--admin-accent-dark) !important; }
    .border-success, .border-info { border-color: #88cbd0 !important; }

    /* Floating desktop application shell. */
    @media (min-width: 992px) {
      body:not(.landing-builder-focus) .wrapper > .main-sidebar {
        top: 82px;
        left: 14px;
        bottom: 14px;
        width: 250px;
        height: auto;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(17, 57, 66, .13);
        margin-left: 0 !important;
        transform: translateX(0) !important;
        transition: transform .25s ease, box-shadow .25s ease;
      }
      body:not(.landing-builder-focus) .wrapper > .main-sidebar .sidebar { height: calc(100% - 70px); overflow-y: auto; overflow-x: hidden; }
      body:not(.landing-builder-focus) .wrapper > .main-header {
        top: 14px;
        left: 14px;
        right: 16px;
        width: auto;
        min-height: 56px;
        margin-left: 0 !important;
        border: 1px solid var(--admin-border);
        border-radius: 15px;
        box-shadow: 0 10px 28px rgba(17, 57, 66, .1);
      }
      body:not(.landing-builder-focus) .wrapper > .content-wrapper {
        margin: 82px 16px 16px 278px !important;
        min-height: calc(100vh - 100px) !important;
        border-radius: 18px;
      }
      body.sidebar-collapse:not(.landing-builder-focus) .wrapper > .main-sidebar {
        margin-left: 0 !important;
        transform: translateX(-280px) !important;
        box-shadow: none;
      }
      body.sidebar-collapse:not(.landing-builder-focus) .wrapper > .content-wrapper { margin-left: 16px !important; }
    }

    @media (max-width: 991px) { .main-header { border-radius: 0; } }
    @media (max-width: 767px) {
      .content-wrapper { padding: 16px !important; }
      .card-body { padding: .9rem; }
      .main-header { padding: .35rem .5rem; }
      .admin-listing-heading { align-items: flex-start; }
      .content-wrapper .card-body:has(> table.table), .content-wrapper .card-body:has(> .dataTables_wrapper) { overflow-x: auto; -webkit-overflow-scrolling: touch; }
      .content-wrapper .table, .content-wrapper .dataTables_wrapper { min-width: 680px; }
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

  @if(session('success'))
    <div class="admin-success-toast" role="status" aria-live="polite">
      <span class="admin-success-toast__icon" aria-hidden="true">✓</span>
      <span class="admin-success-toast__message">{{ session('success') }}</span>
      <button type="button" class="admin-success-toast__close" aria-label="Dismiss notification">×</button>
    </div>
  @endif

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

      // Apply the shared action treatment to existing CRUD controls without
      // requiring every legacy list view to be rewritten.
      $('table td .btn').each(function () {
        const button = $(this);
        const label = button.text().trim().toLowerCase();
        const isEdit = button.find('.fa-edit, .fa-pencil, .fa-pencil-alt').length || label === 'edit';
        const isDelete = button.find('.fa-trash, .fa-trash-alt').length || label === 'delete';
        if (!isEdit && !isDelete) return;
        button.addClass('table-action');
        if (!button.attr('title')) button.attr('title', isEdit ? 'Edit item' : 'Delete item');
        if (!button.attr('aria-label')) button.attr('aria-label', isEdit ? 'Edit item' : 'Delete item');
      });

      // Normalise legacy index pages: place each Add action beside the page
      // heading and remove the now-redundant card heading.
      const pageHeading = $('.content-header h1, section.content-header h1').first();
      const addAction = $('.card-header .card-tools').filter(function () {
        return /\b(add|new)\b/i.test($(this).text());
      }).first();

      if (!addAction.length) return;
      const actionSourceHeader = addAction.closest('.card-header');

      let heading = pageHeading;
      if (!heading.length) {
        const sourceTitle = actionSourceHeader.find('.card-title').first().text().replace(/^\s*(view\s+all|all)\s+/i, '').trim() || 'Manage items';
        const generatedHeader = $('<div class="content-header admin-generated-listing-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-12 admin-listing-heading"></div></div></div></div>');
        heading = $('<h1 class="m-0 text-dark"></h1>').text(sourceTitle);
        generatedHeader.find('.admin-listing-heading').append(heading);
        $('.content').first().before(generatedHeader);
      }

      const headingRow = heading.parent();
      headingRow.addClass('admin-listing-heading');
      addAction.addClass('admin-listing-action').appendTo(headingRow);

      actionSourceHeader.find('.card-title').first().remove();
      if (!actionSourceHeader.children().length) actionSourceHeader.remove();
    });

    const successToast = document.querySelector('.admin-success-toast');
    if (successToast) {
      const dismissToast = () => {
        successToast.classList.add('is-leaving');
        window.setTimeout(() => successToast.remove(), 300);
      };
      successToast.querySelector('.admin-success-toast__close')?.addEventListener('click', dismissToast);
      window.setTimeout(dismissToast, 4500);
    }
  </script>
  @stack('scripts')
</body>
</html>

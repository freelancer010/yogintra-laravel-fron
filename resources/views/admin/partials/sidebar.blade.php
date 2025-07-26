<!-- resources/views/admin/partials/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#feeeef">
  <a href="{{ route('admin.dashboard') }}" class="brand-link text-center" style="background-color:#feeeef">
    <img src="{{ asset($app_setting->app_sticky_logo ?? 'logo.png') }}" alt="{{ $app_setting->app_name ?? 'Yogintra' }}" style="height:40px">
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 mb-2 d-flex align-items-center" style="border: none; padding-left: 0.5rem;">
    <div class="image">
        <img src="{{ asset(Auth::user()->user_photo ?? 'uploads/65034cf0e716aimage_2023_09_14T18_10_56_706Z.png') }}" class="img-circle elevation-2" alt="User Image" style="height: 35px; width: 35px; object-fit: cover;">
    </div>
    <div class="info ml-2">
        <a href="#" class="d-block" style="font-weight: 600; color: #1f2937; font-size: 14px;">
        {{ Auth::user()->name }}
        </a>
        <small style="color:#6b7280; font-size: 12px;">
        ({{ Auth::user()->user_role ?? 'Admin' }})
        </small>
    </div>
    </div>

    <nav class="mt-2 navbar-white">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        @php
          $menu = [
            'event' => [
                'title' => 'Event',
                'icon' => 'fas fa-calendar-check',
                'items' => [
                ['name' => 'View All Event', 'route' => 'admin.event.index'],
                ['name' => 'Event Booking', 'route' => 'admin.event.booking']
                ]
            ],
            'service' => [
                'title' => 'Service',
                'icon' => 'fas fa-briefcase',
                'items' => [
                ['name' => 'Service Category', 'route' => 'admin.service.category'],
                ['name' => 'All Service', 'route' => 'admin.service.index']
                ]
            ],
            'yoga_center' => [
                'title' => 'Yoga Center',
                'icon' => 'fas fa-building',
                'items' => [
                ['name' => 'View All Center', 'route' => 'admin.yoga_centers.index']
                ]
            ],
            'gallery' => [
                'title' => 'Gallery',
                'icon' => 'fas fa-images', // ✅ updated
                'items' => [
                ['name' => 'View All Category', 'route' => 'admin.gallery.category.index'],
                ['name' => 'View All Gallery', 'route' => 'admin.gallery.index']
                ]
            ],
            'blog' => [
              'title' => 'Blog',
              'icon' => 'fab fa-blogger',
              'items' => [
                ['name' => 'Blog Category', 'route' => 'admin.blog.category'],
                ['name' => 'Add New Post', 'route' => 'admin.blog.create'],
                ['name' => 'View All Post', 'route' => 'admin.blog.index']
              ]
            ],
            'landing-page' => [
              'title' => 'Landing Pages',
              'icon' => 'far fa-id-card',
              'items' => [
                ['name' => 'Landing Pages', 'route' => 'admin.landing-pages.index']
              ]
            ],
            'front-setting' => [
              'title' => 'Front Setting',
              'icon' => 'fas fa-home',
              'items' => [
                ['name' => 'All Slider', 'route' => 'admin.front.slider'],
                ['name' => 'Section 1', 'route' => 'admin.front.section1'],
                ['name' => 'Section 2', 'route' => 'admin.front.section2'],
              ]
            ],
            'setting' => [
              'title' => 'Setting',
              'icon' => 'fas fa-tools',
              'items' => [
                ['name' => 'Application Setting', 'route' => 'admin.setting.application']
              ]
            ]
          ];
        @endphp

        @foreach($menu as $prefix => $section)
          <li class="nav-item has-treeview {{ request()->is("admin/$prefix*") ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is("admin/$prefix*") ? 'active' : '' }}">
              <i class="nav-icon {{ $section['icon'] }}"></i>
              <p>{{ $section['title'] }}<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              @foreach($section['items'] as $item)
                <li class="nav-item">
                  <a href="{{ route($item['route']) }}" class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    <i class="fa fa-long-arrow-right nav-icon"></i>
                    <p>{{ $item['name'] }}</p>
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
        @endforeach

        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fa fa-sign-out"></i>
            <p>Signout</p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
      </ul>
    </nav>
  </div>
</aside>

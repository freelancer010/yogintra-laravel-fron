<nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#feeeef">
  @php($isLandingBuilder = request()->routeIs('admin.landing-pages.create', 'admin.landing-pages.edit'))
  @php($navbarProfilePhoto = filled(Auth::user()->user_photo) ? Auth::user()->user_photo : null)
  <ul class="navbar-nav">
    @unless($isLandingBuilder)
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars text-dark"></i>
      </a>
    </li>
    @endunless
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}">
        <button class="btn btn-outline-success btn-sm"><i class="fa fa-home"></i>&nbsp;Home</button>
      </a>
    </li>
    @if($isLandingBuilder)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.landing-pages.index') }}">
        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-file-text-o"></i>&nbsp;Landing pages</button>
      </a>
    </li>
    @endif
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link admin-profile-trigger d-flex align-items-center" data-toggle="dropdown" href="#" aria-label="Open profile menu">
        @if($navbarProfilePhoto)
          <img src="{{ asset($navbarProfilePhoto) }}" class="admin-navbar-avatar" alt="{{ Auth::user()->name }}">
        @else
          <span class="admin-navbar-avatar admin-navbar-avatar-fallback">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
        @endif
        <span class="admin-profile-meta ml-2 d-none d-sm-flex">
          <strong>{{ Auth::user()->name }}</strong>
          <small>{{ Auth::user()->user_role ?? 'Administrator' }}</small>
        </span>
        <i class="fa fa-angle-down ml-2 text-muted"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="px-2 pt-1 pb-2 small text-muted">Signed in as {{ Auth::user()->name }}</div>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">Update Profile</a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">Change Password</a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>

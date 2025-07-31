<nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#feeeef">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars text-dark"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}">
        <button class="btn btn-outline-success btn-sm"><i class="fa fa-home"></i>&nbsp;Home</button>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-cog text-dark"></i></a>
      <div class="dropdown-menu dropdown-menu-right">
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

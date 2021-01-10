<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <div class="d-flex">
        <div class="image">
          @if(Auth::user()->image)
          <img src="{{ asset('dist/img/' . Auth::user()->image) }}" class="img-circle img-size-50 elevation-2"
            alt="User Image">
          @else
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle img-size-50 elevation-2" alt="User Image">
          @endif
        </div>
      <div>
      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name }}
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                               document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
    
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
          @csrf
        </form>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">
          {{ __('Settings') }}
        </a>
      </div>
    </li>

    
  </ul>
</nav>
<!-- /.navbar -->
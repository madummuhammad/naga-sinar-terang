  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
       <form action="{{route('m.logout')}}" method="post">
        @csrf
        <button type="submit" class="dropdown-item btn">
          <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
          Logout
        </button>
      </form>
    </li> 
  </ul>
</nav>
  <!-- /.navbar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link text-center">
      <span class="brand-text font-weight-light">Naga Sinar Terang</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info text-white">
          Logged as:
          <a class="d-block text-uppercase">{{auth()->user()->hak_akses}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           @if(auth()->user()->hak_akses=='production')
           <li class="nav-item {{ (request()->is('production/dashboard')) ? 'active' : '' }}">
            <a href="{{route('production.dashboard')}}" class="nav-link {{ (request()->is('production/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @endif
          @if(auth()->user()->hak_akses=='qc')
          <li class="nav-item {{ (request()->is('qc/dashboard')) ? 'active' : '' }}">
            <a href="{{route('qc.dashboard')}}" class="nav-link {{ (request()->is('qc/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @endif
          @if(auth()->user()->hak_akses=='production')
          <li class="nav-item {{ (request()->is('production/dashboard')) ? 'active' : '' }}">
            <a href="{{route('production.insert')}}"class="nav-link {{ (request()->is('production/insert/*') OR request()->is('production/insert')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Insert Production</p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
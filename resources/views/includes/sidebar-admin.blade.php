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
           <li class="nav-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
            <a href="{{route('admin-dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @if(auth()->user()->hak_akses=='admin')
          <li class="nav-item {{ (request()->is('admin/project')) ? 'active' : '' }}">
            <a href="{{route('project.index')}}" class="nav-link {{ (request()->is('admin/project')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-th-large"></i>
              <p>
                Projects
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item {{ (request()->is('admin/receiver/*') OR request()->is('admin/receiver') OR request()->is('admin/production') OR request()->is('admin/production/*') OR request()->is('admin/qc') OR request()->is('admin/qc/*') OR request()->is('admin/delivery') OR request()->is('admin/delivery/*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('admin/receiver') OR request()->is('admin/receiver/*') OR request()->is('admin/production') OR request()->is('admin/production/*') OR request()->is('admin/qc') OR request()->is('admin/qc/*') OR request()->is('admin/delivery') OR request()->is('admin/delivery/*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Divisi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             @if(auth()->user()->hak_akses=='receiver' OR auth()->user()->hak_akses=='admin')
             <li class="nav-item">
              <a href="{{ route('receiver.index') }}" class="nav-link {{ (request()->is('admin/receiver/*') OR request()->is('admin/receiver')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Receiver</p>
              </a>
            </li>

            @endif
            @if(auth()->user()->hak_akses=='production' OR auth()->user()->hak_akses=='admin')
            <li class="nav-item">
              <a href="{{route('production.index')}}"class="nav-link {{ (request()->is('admin/production/*') OR request()->is('admin/production')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Production</p>
              </a>
            </li>
            @endif
            @if(auth()->user()->hak_akses=='qc' OR auth()->user()->hak_akses=='admin')
            <li class="nav-item">
              <a href="{{route('qc.index')}}" class="nav-link {{ (request()->is('admin/qc/*') OR request()->is('admin/qc')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>QC</p>
              </a>
            </li>
            @endif
            @if(auth()->user()->hak_akses=='delivery' OR auth()->user()->hak_akses=='admin')
            <li class="nav-item">
              <a href="{{route('delivery.index')}}" class="nav-link {{ (request()->is('admin/delivery/*') OR request()->is('admin/delivery')) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>FG</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @if(auth()->user()->hak_akses=='admin')
        <li class="nav-item">
          <a href="{{route('user.index')}}" class="nav-link {{ (request()->is('admin/user/*') OR request()->is('admin/user')) ? 'active' : '' }}">
            <i class="nav-icon far fa-user"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
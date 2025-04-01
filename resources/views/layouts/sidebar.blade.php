<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('temp/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Al Lail App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('temp/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Manajemen Masjid
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('members.pos_keuangan') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Pos Keuangan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Laporan Keuangan
                        </p>
                    </a>
                </li>
                <hr>
                @if (Auth::user()->roles == 'admin' || Auth::user()->roles == 'Admin')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-th-large"></i>
                            <p>
                                Admin
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users_management') }}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.category_transaction') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category Transaction</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.masjid_management') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Masjid Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.financial_post') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Financial Post</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.system_log') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>System Log</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

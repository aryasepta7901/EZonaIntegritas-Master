<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('template/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
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

                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @can('pic')
                    <li class="nav-item">
                        <a href="/lke" class="nav-link {{ Request::is('lke*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Self Assessment LKE
                            </p>
                        </a>
                    </li>
                @endcan
                @can('EvalProv')
                    <li class="nav-item">
                        <a href="/prov/evaluasi" class="nav-link {{ Request::is('prov*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Evaluasi Kabupaten/Kota
                            </p>
                        </a>
                    </li>
                @endcan

                {{-- Admin --}}
                @can('admin')
                    <li class="nav-item">
                        <a href="/users" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/tpi" class="nav-link {{ Request::is('tpi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>
                                Mengelola Wilayah TPI
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/persyaratan" class="nav-link {{ Request::is('persyaratan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Mengelola Persyaratan
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ Request::is('rincian*') | Request::is('subrincian*') | Request::is('pilar*') | Request::is('subpilar*') | Request::is('pertanyaan*') | Request::is('hasil*') ? 'menu-open' : '' }} ">
                        <a href="#"
                            class="nav-link {{ Request::is('rincian*') | Request::is('subrincian*') | Request::is('pilar*') | Request::is('subpilar*') | Request::is('pertanyaan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question"></i>
                            <p>
                                Mengelola LKE
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/rincian"
                                    class="nav-link {{ Request::is('rincian*') | Request::is('subrincian*') | Request::is('pilar*') | Request::is('subpilar*') | Request::is('pertanyaan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>LKE</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/hasil " class="nav-link {{ Request::is('hasil*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Upload Rincian Hasil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="/logout" class="nav-link ">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

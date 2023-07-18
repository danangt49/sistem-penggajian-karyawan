<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Penggajian Pegawai</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('public/admin/asset/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('public/admin/asset/dist/css/adminlte.min.css') }}">
    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"></span>
                        <a href="{{ url('profil') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('public/img/logo.png') }}" alt="PT. GASABA SUKSES MANDIRI Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Sistem Penggajian</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('public/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ url('profil') }}" class="d-block">{{ auth::user()->name }}</a>
                    </div>
                </div>
                @if (Auth::user()->level == 'admin' || Auth::user()->level == 'direktur')
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ url('/') }}"
                                    class="nav-link {{ request()->is('/') || request()->is('home') || request()->is('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is('master') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p> Master <i class="fas fa-angle-left right"></i> </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ url('master/user') }}"
                                            class="nav-link {{ request()->is('master/user') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master/jabatan') }}"
                                            class="nav-link {{ request()->is('master/jabatan') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Jabatan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master/pegawai') }}"
                                            class="nav-link {{ request()->is('master/pegawai') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pegawai</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master/tunjangan-skill') }}"
                                            class="nav-link {{ request()->is('master/tunjangan-skill') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tunjangan Skill</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master/lembur') }}"
                                            class="nav-link {{ request()->is('master/lembur') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lembur</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master/kasbon') }}"
                                            class="nav-link {{ request()->is('master/kasbon') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kasbon</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('master/kehadiran') }}"
                                            class="nav-link {{ request()->is('master/kehadiran') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kehadiran</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('gaji') }}"
                                    class="nav-link {{ request()->is('gaji') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>Gaji</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @else
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ url('/') }}"
                                    class="nav-link {{ request()->is('/') || request()->is('home') || request()->is('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Gaji</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </aside>

        @yield('content')

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <footer class="main-footer">
            <strong>Copyright &copy; 2023 <a href="{{ url('/') }}">Admin</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('public/admin/asset/dist/js/pages/dashboard3.js') }}"></script>
    @yield('js')
</body>

</html>

@can('isAdmin')
    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>


        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" >
        <div id="app" class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ url('/home') }}" class="brand-link">
                <img src="" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <br><span class="brand-text font-weight-light">
                    {{ config('app.name', 'Laravel') }}
                </span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                    @yield('user-image')
                    </div>
                    <div class="info">
                    <a href="#" class="d-block">{{ucwords(auth()->user()->name)}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a class="nav-link" href="/home">
                            <i class="nav-icon fas fa-home"></i>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/users">
                            <i class="nav-icon fas fa-users"></i>
                            Users
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/fields">
                            <i class="nav-icon fas fa-plus"></i>
                            Fields
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/account/edit">
                            <i class="nav-icon fas fa-user-edit"></i>
                            Edit Profile
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="nav-icon fas fa-power-off"></i>
                                    {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            @yield('content')

            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2019 <a >{{ config('app.name') }}</a>.</strong>
                All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
            @yield('script')
        </div>

    </body>
    </html>

@endcan

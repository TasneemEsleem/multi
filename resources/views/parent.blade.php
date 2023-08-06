<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en" data-textdirection="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | @yield('title')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    @yield('style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="dropdown" href="{{ route('chat.admin') }}">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">0</span>
                    </a>
                </li>
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-cog profile-setting"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            Edit Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('Edit-Password') }}" class="dropdown-item">
                            Change Password
                        </a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ Auth::user()->unreadNotifications->count() }} Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i>{{ Auth::user()->unreadNotifications->count() }} new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        @foreach (Auth::user()->notifications as $notification)
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-envelope mr-2"></i>
                                    {{ $notification->data['message'] }}
                                    @if (is_null($notification->read_at))
                                        <span class="float-right text-muted text-sm">Unread</span>
                                    @else
                                        <span class="float-right text-muted text-sm">Read</span>
                                    @endif
                                </a>
                            @endforeach
                        {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header">{{ Auth::user()->unreadNotifications->count() }} Unread Notifications</span>
                            <div class="dropdown-divider"></div>
                            @foreach (Auth::user()->notifications as $notification)
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-bell mr-2"></i>
                                    {{ $notification->data['message'] }}
                                    @if (is_null($notification->read_at))
                                        <span class="float-right text-muted text-sm">Unread</span>
                                    @else
                                        <span class="float-right text-muted text-sm">Read</span>
                                    @endif
                                </a>
                            @endforeach
                        </div> --}}

                        {{-- <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a> --}}
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('cms/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('cms/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">

                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->roles[0]->name ?? '' }}</a>
                        <p>{{ auth()->user()->name ?? '' }}</p>

                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Starter Pages
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        @canany(['Create-Role', 'Create-Permission', 'Read-Role', 'Read-Permission'])
                            <li class="nav-header">Role && Permission</li>
                            @canany(['Create-Role', 'Read-Role'])
                                <li class="nav-item">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-bullseye"></i>
                                        <p>Role
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('Read-Role')
                                            <li class="nav-item">
                                                <a href="{{ route('roles.index') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-Role')
                                            <li class="nav-item">
                                                <a href="{{ route('roles.create') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Create</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                                </li>
                            @endcanany
                            @canany(['Create-Permission', 'Read-Permission'])
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-bullseye"></i>
                                        <p>Permission
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('Read-Permission')
                                            <li class="nav-item">
                                                <a href="{{ route('permissions.index') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Index</p>
                                                </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </li>
                            @endcanany
                        @endcanany
                        <li class="nav-header">Users</li>

                        @canany(['Create-DataEntry', 'Read-DataEntry'])
                            <li class="nav-item">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bullseye"></i>
                                    <p>Data Entry
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Read-DataEntry')
                                        <li class="nav-item">
                                            <a href="{{ route('dataentries.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-DataEntry')
                                        <li class="nav-item">
                                            <a href="{{ route('dataentries.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            </li>
                        @endcanany

                        @canany(['Create-Financial', 'Read-Financial'])
                            <li class="nav-item">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bullseye"></i>
                                    <p>Financial
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Read-Financial')
                                        <li class="nav-item">
                                            <a href="{{ route('financials.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-Financial')
                                        <li class="nav-item">
                                            <a href="{{ route('financials.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            </li>
                        @endcanany
                        <li class="nav-header">Content</li>
                        @canany(['Create-Restaurant', 'Read-Restaurant', 'Trashed-Restaurant'])

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bullseye"></i>
                                    <p>Resturant
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">


                                    @can('Read-Restaurant')
                                        <li class="nav-item">
                                            <a href="{{ route('restaurants.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-Restaurant')
                                        <li class="nav-item">
                                            <a href="{{ route('restaurants.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Trashed-Restaurant')
                                        <li class="nav-item">
                                            <a href="{{ route('trashed') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Trashed</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @canany(['Create-Category', 'Read-Category'])
                            <li class="nav-item">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bullseye"></i>
                                    <p>Category
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Read-Category')
                                        <li class="nav-item">
                                            <a href="{{ route('categories.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-Category')
                                        <li class="nav-item">
                                            <a href="{{ route('categories.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            </li>
                        @endcanany

                        @canany(['Create-Item', 'Read-items'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bullseye"></i>
                                    <p>Item
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Read-items')
                                        <li class="nav-item">
                                            <a href="{{ route('items.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-Item')
                                        <li class="nav-item">
                                            <a href="{{ route('items.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @canany(['Read-Orders'])
                            @can('Read-Orders')
                                <a href="{{ route('OrderCustomer') }}" class="nav-link">
                                    <i class="nav-icon fas fa-bullseye"></i>
                                    <p>The Orders Customer
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                            @endcan
                        @endcanany
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-bullseye"></i>
                            <p>logout
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('lg_title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">@yield('main_title')</a></li>
                                <li class="breadcrumb-item active">@yield('sm_title')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong><a href="">AdminLTE.io</a>.</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>

</html>

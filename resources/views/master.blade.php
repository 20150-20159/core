<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="uS32J7T7RfmDVKHv6zr7m1MTk6e0kPlsCFJ9AsGk">


    <title>
        AdminLTE 3 </title>


    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css')}}">


    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


</head>

<body class="sidebar-mini">


<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </li>
        </ul>
    </nav>


    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="home" class="brand-link ">
            <img src="{{asset('vendor/adminlte/dist/img/AdminLTELogo.png')}}"
                 alt="AdminLTE"
                 class="brand-image img-circle elevation-3"
                 style="opacity:.8">
            <span class="brand-text font-weight-light ">
        <b>Admin</b>LTE
    </span>
        </a>
        <div class="sidebar">
            <nav class="pt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-header ">LISTINGS</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard.home')}}">
                            <i class="fas fa-fw fa-home text-green"></i>
                            <p>My listings</p>
                        </a>
                    </li>
                    @if(count($user->roles) === 2)
                        <li class="nav-header ">ADMIN</li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-fw fa-home text-red"></i>
                                <p>All listings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="far fa-fw fa-user text-yellow"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-header">ACCOUNT</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}">
                            <i class="fa fa-door-open text-cyan"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper ">
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>


<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>


<script src="{{asset('vendor/adminlte/dist/js/adminlte.min.js')}}"></script>


</body>

</html>
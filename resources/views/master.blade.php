<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vale | Dashboard</title>

  <link rel="icon" href="{{asset('SelainLogin/dist/img/load.png')}}">

  <script src="{{asset('SelainLogin/plugins/gatt/dhtmlxgantt.js')}}"></script>
  <link href="{{asset('SelainLogin/plugins/gatt/dhtmlxgantt.css')}}" rel="stylesheet">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/google-font/font.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/ionicons/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('SelainLogin/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('SelainLogin/plugins/summernote/summernote-bs4.min.css')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <style>
    .gantt-orange {
      background-color: rgb(244, 176, 132);
    }

    .gantt-amber {
      background-color: rgb(255, 230, 153);
    }

    .gantt-green {
      background-color: rgb(197, 224, 179);
    }

    .gantt-blue {
      background-color: rgb(142, 169, 219);
    }
  </style>
  @yield('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('SelainLogin/dist/img/load.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('home')}}" class="nav-link">Home</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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
      </li> --}}
      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fas fa-bell"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <div class="dropdown-divider"></div>

          @foreach ($notifications as $notification)
          <div class="dropdown-item">
            <h5>{{ $notification->title }}</h5>
            <p>{{ $notification->content }}</p>
          </div>
          <div class="dropdown-divider"></div>
          @endforeach
        </div>
      </li>
      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <span class="dropdown-item dropdown-header">Current User</span>
          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> {{Auth::user()->name}}
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{url('logout-user')}}" class="dropdown-item dropdown-footer">Logout</a>
        </div>
      </li>


      <!-- Notifications Dropdown Menu -->
      {{-- <form method = 'post' action = '{{route('logout')}}'>
      {{csrf_field()}}
      <button class="nav-link" type="submit" role="button">
        LOGOUT
      </button>
      </form> --}}

      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>

          <div class="dropdown-divider"></div>

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
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->



  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
      <img src="{{asset('SelainLogin/dist/img/load.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 100">
      <span class="brand-text font-weight-light">VALE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a href="#" class="d-block"><b>PPU AUTOMATION</b></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{url('tasks')}}" class="nav-link {{  Request::is('tasks') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Main Project</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/oncall" class="nav-link {{  Request::is('oncall') ? 'active' : '' }}">
              <i class="nav-icon fas fa-phone-alt"></i>
              <p>
                OnCall Automation
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/knowledge" class="nav-link {{  Request::is('knowledge') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                Sharing Knowledge

              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/mcu" class="nav-link {{  Request::is('mcu') ? 'active' : '' }}">
              <i class="nav-icon fas fa-hospital-alt"></i>
              <p>
                Status MCU
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/training-status" class="nav-link {{  Request::is('training-status') ? 'active' : '' }}">
              <i class="nav-icon fas fa-hospital-alt"></i>
              <p>
                Training Status
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a href="/wfhrooster" class="nav-link {{  Request::is('wfhrooster') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>WFH Rooster</p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="/overtime-hour" class="nav-link {{  Request::is('overtime-hour*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-clock"></i>
              <p>Overtime Hours</p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="/mod" class="nav-link {{  Request::is('mod') ? 'active' : '' }}">
          <i class="nav-icon fas fa-book"></i>
          <p>Schedule Engineer</p>
          </a>
          </li> --}}
          @if(Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="/image-landing" class="nav-link {{  Request::is('image-landing') ? 'active' : '' }}">
              <i class="nav-icon fas fa-image"></i>
              <p>Image Landing Page</p>
            </a>
          </li>
          @endif
          @if(Auth::user()->role == 'admin')
          <li class="nav-item {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Input Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/inputfurconv" class="nav-link {{  Request::is('inputfurconv') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Furnace-Converter</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/inputdryerkiln" class="nav-link {{  Request::is('inputdryerkiln') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dryer-Kiln</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/inputinfra" class="nav-link {{  Request::is('inputinfra') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Infrastructure</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/inpututl" class="nav-link {{  Request::is('inpututl') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilities</p>
                </a>
              </li>
              @if(Auth::user()->role=='admin')
              <li class="nav-item">
                <a href="/import-excel" class="nav-link {{  Request::is('import-excel') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Import Excel</p>
                </a>
              </li>
              @endif
              @if(Auth::user()->role=='admin')
              <li class="nav-item">
                <a href="/export-excel" class="nav-link {{  Request::is('export-excel') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Export Excel</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @endif
          @if(Auth::user()->role != 'admin')
          <li class="nav-item">
            <a href="/update-password" class="nav-link {{  Request::is('update-password') ? 'active' : '' }}">
              <i class="far fa-user nav-icon"></i>
              <p>Update Password</p>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->

  <!-- /.content-wrapper -->
  @yield('content')


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('SelainLogin/plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('SelainLogin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('SelainLogin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('SelainLogin/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('SelainLogin/plugins/sparklines/sparkline.js')}}"></script>
  <!-- JQVMap -->
  <script src="{{asset('SelainLogin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('SelainLogin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('SelainLogin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('SelainLogin/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('SelainLogin/plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('SelainLogin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('SelainLogin/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('SelainLogin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('SelainLogin/dist/js/adminlte.js')}}"></script>

  @stack('scripts')

</body>

</html>

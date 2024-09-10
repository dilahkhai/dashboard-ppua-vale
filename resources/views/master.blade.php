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

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@forevolve/bootstrap-dark@1.0.0/dist/css/bootstrap-dark.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@forevolve/bootstrap-dark@1.0.0/dist/css/toggle-bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@forevolve/bootstrap-dark@1.0.0/dist/css/toggle-bootstrap-dark.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@forevolve/bootstrap-dark@1.0.0/dist/css/toggle-bootstrap-print.min.css" /> -->

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

    .checkbox {
      opacity: 0;
      position: absolute;
    }

    .checkbox-label {
      background-color: #111;
      width: 50px;
      height: 26px;
      border-radius: 50px;
      position: relative;
      padding: 5px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .fa-moon {
      color: #f1c40f;
    }

    .fa-sun {
      color: #f39c12;
    }

    .checkbox-label .ball {
      background-color: #fff;
      width: 22px;
      height: 22px;
      position: absolute;
      left: 2px;
      top: 2px;
      border-radius: 50%;
      transition: transform 0.2s linear;
    }

    .checkbox:checked+.checkbox-label .ball {
      transform: translateX(24px);
    }

    a {
      color: inherit;
    }

    .added-right {
      text-align: center;
    }

    .notification-content {
    max-height: 500px; 
    overflow-y: auto; 
    overflow-x: hidden; 
  }
  
  .notification-content::-webkit-scrollbar {
    width: 6px;
  }

  .notification-content::-webkit-scrollbar-thumb {
    background-color: #888; 
    border-radius: 10px; 
  }

  .notification-content::-webkit-scrollbar-track {
    background-color: #f1f1f1; 
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
      <li class="nav-item">
        <div class="mt-2 mr-3">
          <input type="checkbox" class="checkbox" id="checkbox">
          <label for="checkbox" class="checkbox-label">
            <i class="fas fa-moon"></i>
            <i class="fas fa-sun"></i>
            <span class="ball"></span>
          </label>
        </div>
      </li>
      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" id="notification-button" aria-expanded="true">
          <i class="fas fa-bell"></i>
          @php
            $unreadCount = $notifications->filter(fn ($notification) => !$notification->is_read)->count();
          @endphp
          @if($unreadCount > 0)
            <span class="badge badge-danger" id="unread-count">{{ $unreadCount }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <div class="dropdown-divider"></div>
          <div class="notification-content">
            @foreach ($notifications as $notification)
            <div class="dropdown-item">
              <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
              <h5>{{ $notification->title }}</h5>
              <p>{{ $notification->content }}</p>
            </div>
            <div class="dropdown-divider"></div>
            @endforeach
          </div>
        </div>
      </li>
      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"> {{Auth::user()->name}}</i>
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
            <a href="{{url('issue')}}" class="nav-link {{  Request::is('issue') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Issue</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('key-performance-index')}}" class="nav-link {{  Request::is('key-performance-index') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Key Performance Index</p>
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
            <a href="/sharing-schedule" class="nav-link {{  Request::is('sharing-schedule') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                Sharing Schedule
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/study-schedule" class="nav-link {{  Request::is('study-schedule') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                Study Schedule
              </p>
            </a>
          </li>
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
            <a href="/sub-training" class="nav-link {{  Request::is('sub-training') ? 'active' : '' }}">
              <i class="nav-icon fas fa-hospital-alt"></i>
              <p>
                Training Status
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/simper" class="nav-link {{  Request::is('simper') ? 'active' : '' }}">
              <i class="nav-icon fas fa-hospital-alt"></i>
              <p>
                SIM Status
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
          <li class="nav-item ">
            <a href="/man-power" class="nav-link {{  Request::is('man-power*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>Man Power</p>
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
          @if(Auth::user()->isAdmin || Auth::user()->isLeader)
          <li class="nav-item {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Input Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel')  ? 'active' : '' }}">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Data
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/inputdryerkiln" class="nav-link {{  Request::is('inputdryerkiln') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>PP Automation</p>
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
                </ul>
              </li>
              <li class="nav-item {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{  Request::is('inputfurconv') || Request::is('inputdryerkiln') || Request::is('inputinfra') || Request::is('inpututl') || Request::is('import-excel')  ? 'active' : '' }}">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Import / Export
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 @if(Auth::user()->isAdmin || Auth::user()->isLeader)
                  <li class="nav-item">
                    <a href="/import-excel" class="nav-link {{  Request::is('import-excel') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Import Excel</p>
                    </a>
                  </li>
                  @endif
                  @if(Auth::user()->isAdmin || Auth::user()->isLeader)
                  <li class="nav-item">
                    <a href="/export-excel" class="nav-link {{  Request::is('export-excel') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Export Excel</p>
                    </a>
                  </li>
                  @endif
                </ul>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-item">
            <a href="/update-password" class="nav-link {{  Request::is('update-password') ? 'active' : '' }}">
              <i class="far fa-user nav-icon"></i>
              <p>Update Password</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
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

  <script>
    $('#notification-button').click(function() {
      $.ajax({
        'url': '/read-notif',
        'method': 'get',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success': function(response) {
          $('#unread-count').text('0')
        },
        error: function(error) {
          console.error(error);
        }
      })
    })
  </script>

  @stack('scripts')

  <script>
    $('#checkbox').change(function() {
      if ($('.navbar').hasClass('navbar-light')) {
        $('.navbar').removeClass('navbar-light navbar-white')
        $('.navbar').addClass('navbar-dark navbar-black')
      } else {
        $('.navbar').removeClass('navbar-dark navbar-black')
        $('.navbar').addClass('navbar-light navbar-white')
      }

      $('.content-wrapper').toggleClass('bg-dark')
      $('.card').toggleClass('text-white bg-secondary')
      $('.fc-day').toggleClass('bg-secondary text-white')

      try {
        var homeChartColor = homeChart.options.color

        if (homeChartColor == '#000') {
          homeChart.options.color = '#fff'
        } else {
          homeChart.options.color = '#000'
        }

        homeChart.update()
      } catch (e) {

      }

      var myChartColor = myChart.options.color
      var myChartYTicksColor = myChart.options.scales?.y?.ticks?.color
      var myChartXTicksColor = myChart.options.scales?.x?.ticks?.color

      if (myChartColor == '#000') {
        myChart.options.color = '#fff'
      } else {
        myChart.options.color = '#000'
      }

      if (myChartYTicksColor == '#000') {
        myChart.options.scales.y.ticks.color = '#fff'
      } else {
        myChart.options.scales.y.ticks.color = '#000'
      }

      if (myChartXTicksColor == '#000') {
        myChart.options.scales.x.ticks.color = '#fff'
      } else {
        myChart.options.scales.x.ticks.color = '#000'
      }

      myChart.update()

      var myChartProductivityColor = myChartProductivity.options.color
      var myChartProductivityYTicksColor = myChartProductivity.options.scales.y.ticks.color
      var myChartProductivityXTicksColor = myChartProductivity.options.scales.x.ticks.color

      if (myChartProductivityColor == '#000') {
        myChartProductivity.options.color = '#fff'
      } else {
        myChartProductivity.options.color = '#000'
      }

      if (myChartProductivityYTicksColor == '#000') {
        myChartProductivity.options.scales.y.ticks.color = '#fff'
      } else {
        myChartProductivity.options.scales.y.ticks.color = '#000'
      }

      if (myChartProductivityXTicksColor == '#000') {
        myChartProductivity.options.scales.x.ticks.color = '#fff'
      } else {
        myChartProductivity.options.scales.x.ticks.color = '#000'
      }

      myChartProductivity.update()

      var myChartManhoursColor = myChartManhours.options.color
      var myChartManhoursYTicksColor = myChartManhours.options.scales.y.ticks.color
      var myChartManhoursXTicksColor = myChartManhours.options.scales.x.ticks.color

      if (myChartManhoursColor == '#000') {
        myChartManhours.options.color = '#fff'
      } else {
        myChartManhours.options.color = '#000'
      }

      if (myChartManhoursYTicksColor == '#000') {
        myChartManhours.options.scales.y.ticks.color = '#fff'
      } else {
        myChartManhours.options.scales.y.ticks.color = '#000'
      }

      if (myChartManhoursXTicksColor == '#000') {
        myChartManhours.options.scales.x.ticks.color = '#fff'
      } else {
        myChartManhours.options.scales.x.ticks.color = '#000'
      }

      myChartManhours.update()

      var myChartAutomationColor = myChartAutomation.options.color
      var myChartAutomationYTicksColor = myChartAutomation.options.scales.y.ticks.color
      var myChartAutomationXTicksColor = myChartAutomation.options.scales.x.ticks.color

      if (myChartAutomationColor == '#000') {
        myChartAutomation.options.color = '#fff'
      } else {
        myChartAutomation.options.color = '#000'
      }

      if (myChartAutomationYTicksColor == '#000') {
        myChartAutomation.options.scales.y.ticks.color = '#fff'
      } else {
        myChartAutomation.options.scales.y.ticks.color = '#000'
      }

      if (myChartAutomationXTicksColor == '#000') {
        myChartAutomation.options.scales.x.ticks.color = '#fff'
      } else {
        myChartAutomation.options.scales.x.ticks.color = '#000'
      }

      myChartAutomation.update()
    })
  </script>
</body>

</html>

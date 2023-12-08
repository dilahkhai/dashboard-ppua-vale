<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPUA</title>

  <link rel="icon" href="{{asset('SelainLogin/dist/img/load.png')}}">

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

  <link href="{{asset('SelainLogin/plugins/google-font/font2.css')}}" rel="stylesheet">
  @yield('css')

  <style>
    .banner {
      width: 100%;
      height: 600px;
      contain: content;
    }

    #background-video {
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      z-index: -1;
    }

    p {
      font-family: 'Roboto', sans-serif;
    }

    h1 {
      font-family: 'Roboto', sans-serif;
    }

    .btn-custom-color {
      background-color: #008F83
    }
  </style>

</head>

<body>
  <!-- NavBar -->
  <nav class="navbar sticky-top navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <img src="{{asset('SelainLogin/dist/img/load.png')}}" width="30" height="30" alt="">
      Vale
    </a>
  </nav>

  {{-- Banner --}}
  <div class="banner d-flex justify-content-center align-items-center">
    <div class="overflow-hidden">
      <video id="background-video" autoplay loop muted>
        <source src="{{asset('video/landing2.mkv')}}" type="video/mp4">
      </video>
    </div>

    <div class="text-middle text-center" style="width:40%;">
      {{-- <p style="color: white">DON'T LOOK ANY FURTHER, HERE IS THE KEY</p> --}}
      <h1 style="color: rgb(255, 210, 9)">Process Plant & Utilities </h1>
      <h1 style="color: rgb(255, 210, 9)">AUTOMATION</h1>
      {{-- <p style="color: white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim. sed do eiusmod tempor incididunt.</p> --}}
      <a href="{{url('signin')}}" class="btn btn-custom-color"><span style="color: white">LOGIN</span></a>
    </div>
  </div>

  {{-- Area Description --}}
  <h2 class="text-center mb-4">Area Information</h2>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <img src="{{ $dryer->file }}" class="w-100" alt="" style="aspect-ratio: 2/1;">
      </div>
      <div class="col-md-8">
        <h4>Dryer-Kiln</h4>
        <p>Update OT Standards of Dryer-Kiln area. Perform automation technical supports for Dryer-Kiln operation and maintenance groups, Conduct automation studies and automation projects across Dryer-Kiln Area to solve problems, to sustain performance, time-efficient, cost-efficient, workforce-effective, target-oriented, and quality oriented manners.</p>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4">
        <img src="{{ $furconv->file }}" class="w-100" alt="" style="aspect-ratio: 2/1;">
      </div>
      <div class="col-md-8">
        <h4>Furnace-Converter</h4>
        <p>Update OT Standards of Furnace-Converter area. Perform automation technical supports for Furnace-Converter operation and maintenance groups, Conduct automation studies and automation projects across Furnace-Converter Area to solve problems, to sustain performance, time-efficient, cost-efficient, workforce-effective, target-oriented, and quality oriented manners.</p>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4">
        <img src="{{ $infra->file }}" class="w-100" alt="" style="aspect-ratio: 2/1;">
      </div>
      <div class="col-md-8">
        <h4>Infrastructure</h4>
        <p>Update the IT/OT network standards of the PTVI process plant,  provide technical support for process plant operation, process plant maintenance, process plant technology, process plant engineering & planning related to automation network in all area of process plant.</p>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4">
        <img src="{{ $util->file }}" class="w-100" alt="" style="aspect-ratio: 2/1;">
      </div>
      <div class="col-md-8">
        <h4>Utilities</h4>
        <p>Update OT Standards of Utilities area. Perform automation technical supports for Utilities operation and maintenance groups, Conduct automation studies and automation projects across Utilities Area to solve problems, to sustain performance, time-efficient, cost-efficient, workforce-effective, target-oriented, and quality oriented manners.</p>
      </div>
    </div>
  </div>

  <footer class="mt-5"></footer>
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

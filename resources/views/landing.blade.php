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
    .fullscreen-background {
    position: relative;
    width: 100vw; 
    height: 100vh; 
    background-image: url('https://akcdn.detik.net.id/community/media/visual/2023/07/29/pt-vale-garap-3-proyek-smelter-senilai-1343-triliun_169.jpeg?w=700&q=90');
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
    color: white; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    text-align: center; 
    padding: 20px;
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
  <div class="d-flex justify-content-center align-items-center">
    <div class="fullscreen-background">
    <div class="text-middle text-center" style="width:40%;">
      <p style="color: white">DON'T LOOK ANY FURTHER, HERE IS THE KEY</p>
      <h1 style="color: rgb(255, 210, 9)">Process Plant & Utilities </h1>
      <h1 style="color: rgb(255, 210, 9)">AUTOMATION</h1>
      <p style="color: white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim. sed do eiusmod tempor incididunt.</p>
      <a href="{{url('signin')}}" class="btn btn-custom-color"><span style="color: white">LOGIN</span></a>
    </div>
    </div>
  </div>
  <br><br>
  
  {{-- Area Description --}}
  <h1 class="text-center mb-4" style="color: rgb(0, 126, 122)"><b>Area Information</b></h1>
  <br><br>
  <div class="container">
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <img src="https://asset-2.tstatic.net/makassar/foto/bank/images/Pabrik-pengolahan-nikel-PT-Vale-Indonesia-Tbk-1-892022.jpg" class="img-fluid" alt="Process Plant Automation">
        </div>
        <div class="col-md-8">
            <h3 style="color: rgb(0, 126, 122)">Process Plant Automation</h3>
            <p>Update OT Standards of Process Plant Automation area. Perform automation technical supports for Process Plant Automation operation and maintenance groups, Conduct automation studies and automation projects across Process Plant Automation Area to solve problems, to sustain performance, time-efficient, cost-efficient, workforce-effective, target-oriented, and quality oriented manners.</p>
        </div>
    </div>
    <br><br>
    <div class="row align-items-center mb-4">
        <div class="col-md-8 text-right">
            <h3 style="color: rgb(0, 126, 122)">Furnace-Converter</h3>
            <p>Update OT Standards of Furnace-Converter area. Perform automation technical supports for Furnace-Converter operation and maintenance groups, Conduct automation studies and automation projects across Furnace-Converter Area to solve problems, to sustain performance, time-efficient, cost-efficient, workforce-effective, target-oriented, and quality oriented manners.</p>
        </div>
        <div class="col-md-4">
            <img src="https://asset-2.tstatic.net/makassar/foto/bank/images/Pabrik-pengolahan-nikel-PT-Vale-Indonesia-Tbk-1-892022.jpg" class="img-fluid" alt="Furnace-Converter">
        </div>
    </div>
    <br><br>
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <img src="https://asset-2.tstatic.net/makassar/foto/bank/images/Pabrik-pengolahan-nikel-PT-Vale-Indonesia-Tbk-1-892022.jpg" class="img-fluid" alt="Infrastructure">
        </div>
        <div class="col-md-8">
            <h3 style="color: rgb(0, 126, 122)">Infrastructure</h3>
            <p>Update the IT/OT network standards of the PTVI process plant, provide technical support for process plant operation, process plant maintenance, process plant technology, process plant engineering & planning related to automation network in all area of process plant.</p>
        </div>
    </div>
    <br><br>
    <div class="row align-items-center mb-4">
        <div class="col-md-8 text-right">
            <h3 style="color: rgb(0, 126, 122)">Utilities</h3>
            <p>Update OT Standards of Utilities area. Perform automation technical supports for Utilities operation and maintenance groups, Conduct automation studies and automation projects across Utilities Area to solve problems, to sustain performance, time-efficient, cost-efficient, workforce-effective, target-oriented, and quality oriented manners.</p>
        </div>
        <div class="col-md-4">
            <img src="https://asset-2.tstatic.net/makassar/foto/bank/images/Pabrik-pengolahan-nikel-PT-Vale-Indonesia-Tbk-1-892022.jpg" class="img-fluid" alt="Utilities">
        </div>
    </div>
</div>


<footer style="background-color: rgb(0, 126, 122); color: white;" class="mt-5">
  <div class="container py-4">
    <div class="row text-center">
      <!-- Kolom 1: Informasi Perusahaan -->
      <div class="col-md-4">
        <h5 style="color: rgb(255, 210, 9);">About Us</h5>
        <p style="color: rgb(255, 210, 9);">Process Plant & Utilities Automation provides advanced solutions for process plant and utilities operations, focusing on efficiency, quality, and workforce effectiveness.</p>
      </div>

      <!-- Kolom 3: Follow Us -->
      <div class="col-md-4 mt-4">
        <h5 style="color: rgb(255, 210, 9);">Follow Us</h5>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="https://www.youtube.com/valeglobal" style="color: rgb(255, 210, 9);"><i class="fab fa-youtube"></i></a></li>
          <li class="list-inline-item"><a href="https://twitter.com/valeglobal" style="color: rgb(255, 210, 9);"><i class="fab fa-twitter"></i></a></li>
          <li class="list-inline-item"><a href="https://www.facebook.com/valenobrasil/" style="color: rgb(255, 210, 9);"><i class="fab fa-facebook"></i></a></li>
          <li class="list-inline-item"><a href="https://www.instagram.com/valeglobal/" style="color: rgb(255, 210, 9);"><i class="fab fa-instagram"></i></a></li>
          <li class="list-inline-item"><a href="https://www.linkedin.com/company/vale/" style="color: rgb(255, 210, 9);"><i class="fab fa-linkedin-in"></i></a></li>
        </ul>
      </div>

      <!-- Kolom 2: Contact Information -->
      <div class="col-md-4">
        <h5 style="color: rgb(255, 210, 9);">Contact Us</h5>
        <ul class="list-unstyled">
          <li style="color: rgb(255, 210, 9);"><i class="fas fa-map-marker-alt"></i> Main Office Plant Site, Sorowako, Kec. Nuha, Kabupaten Luwu Timur, Sulawesi Selatan 92983</li>
          <li style="color: rgb(255, 210, 9);"><i class="fas fa-phone"></i> (021) 5249000</li>
          <li style="color: rgb(255, 210, 9);"><i class="fas fa-envelope"></i> info@automation.com</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Copyright -->
  <div style="background-color: rgb(238, 240, 238);" class="text-center py-3">
    <p class="mb-0" style="color: rgb(0, 126, 122);">© 2024 Process Plant & Utilities Automation. All Rights Reserved.</p>
  </div>
</footer>




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

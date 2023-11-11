@extends('master')
@section('content')
    
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">SELECT AREA</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              

                <p>Dryer-Kiln</p>
              </div>
              <div class="icon">
               
              </div>
              <a href="/dashboarddryerkiln" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                

                <p>Furnace-Converter</p>
              </div>
              <div class="icon">
                
              </div>
              <a href="/dashboardfurconv" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                

                <p>Infrastructure</p>
              </div>
              <div class="icon">
                
              </div>
              <a href="/dashboardinfra" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                

                
                <p>Utilities</p>
              </div>
              <div class="icon">
                
              </div>

              <a href="/dashboardutl" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        
        <div class="row">
          <div class="col-4"></div>
            <div class="chart-container" style="position: center; height:10vh; width:15vw">
              <canvas id="myChart"></canvas>
            </div>
          <div class="col-4"></div>
        </div>

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script src="{{asset('SelainLogin/chart.js')}}"></script>

  <script>

const data = {
  labels: [
   
    'Furnace-Converter',
    'Dryer-Kiln',
    'Infrastructure',
    'Utilities'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [ 7, 7, 8, 5],
    backgroundColor: [
      'rgb(75, 192, 192)',
      'rgb(255, 205, 86)',
      'rgb(201, 203, 207)',
      'rgb(54, 162, 235)'
    ]
  }]
  
};

const config = {
  type: 'pie',
  data: data,
  options: {}
};



  </script>

<script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>


@endsection
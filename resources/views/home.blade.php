@extends('master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
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
                <h4><b>Dryer-Kiln</b></h4>

                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/dashboarddryerkiln" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h4><b>Furnace-Converter</b></h4>

                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="/dashboardfurconv" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h4><b>Infrastructure</b></h4>

                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/dashboardinfra" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4><b>Utilities</b></h4>

                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/dashboardutl" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        {{-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{asset('images/oncall.jpg')}}" class="d-block w-50" alt="...">
            </div>
            <div class="carousel-item">
              <img src="{{asset('images/oncall2.jpg')}}" class="d-block w-50" alt="...">
            </div>
            <div class="carousel-item">
              <img src="{{asset('images/oncall3.jpg')}}" class="d-block w-50" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div> --}}

        <div class="mb-5 d-flex justify-content-center" style="height:300px">
            <div class="row col-12 justify-content-center">
                <div class="chart-container"  style="height:300px;width:300px;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">




            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$user}}</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="/cruduser" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            {{-- <div class="w-100 h-50">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="{{asset('images/oncall.jpg')}}" class="d-block w-100 " alt="..." height="720">
                    </div>
                    <div class="carousel-item">
                    <img src="{{asset('images/oncall2.jpg')}}" class="d-block w-100 " alt="..." height="720">
                    </div>
                    <div class="carousel-item">
                    <img src="{{asset('images/oncall4.png')}}" class="d-block w-100 " alt="..." height="720">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </button>
                </div>
            </div> --}}
        </div>


    {{-- <iframe src="https://onedrive.live.com/embed?cid=8AFA2D6E9FD8FA55&resid=8AFA2D6E9FD8FA55%21984&authkey=AEuyJXmxFpUfWUw&em=2" width='100%' height='1000px' frameborder='0'></iframe> --}}
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

  @push('scripts')
  <script src="{{asset('SelainLogin/chart.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>

  <script>
    const data = {
        labels: {!! json_encode($list_area) !!},
        datasets: [{
            label: 'My First Dataset',
            data: {!! json_encode($area_value) !!},
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
        options: {},
        plugins: [ChartDataLabels]
    };

    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
  @endpush
@endsection

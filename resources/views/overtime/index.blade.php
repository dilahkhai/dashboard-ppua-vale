@extends('master')
@section('css')
{{-- <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('SelainLogin/tablesearch/DataTables/datatables.min.css')}}" />
@endsection
@section('content')

<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Overtime Hours</h1>
        </div>
      </div>
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        Data Saved succesfully!
      </div>
      @endif

      @if(session()->has('fail'))
      <div class="alert alert-danger" role="alert">
        Failed!
      </div>
      @endif
    </div><!-- /.container-fluid -->
  </section>


  <section class="content">
    <div class="container-fluid">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Add Overtime
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="/overtime-hour" method="post">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Overtime Hours</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                @if (auth()->user()->role == 'admin')
                <div class="form-group">
                  <label for="exampleInputPassword1">Area</label>
                  <select class="form-control" name="area_id" onchange="fetchDataAndPopulate(this.value)">
                    <option>Select Area</option>
                    @foreach ($areas as $id => $data)
                    <option value="{{$data->id}}">{{$data->area}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Employee</label>
                  <select class="form-control" name="employee" id="employee">
                  </select>
                </div>
                @endif
                <div class="form-group">
                  <label for="hour">Hours</label>
                  <input type="number" class="form-control" name="hour" id="hour" placeholder="Overtime hours ...">
                </div>
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" class="form-control" name="date" id="date" placeholder="Overtime date ...">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Area</th>
                  <th>Name</th>
                  <th>Hours</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($overtimes as $item)
                <tr>
                  <td>{{$item->user?->area->area }}</td>
                  <td>{{$item->user?->name}}</td>
                  <td>{{$item->hour}}</td>
                  <td>{{ $item->date }}</td>
                  <td class="d-flex">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 mr-3" data-toggle="modal" data-target="#editModal{{ $item->id }}">
                      Edit
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModal{{ $item->id }}Label" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="/overtime-hour/{{ $item->id }}" method="post">
                          @csrf
                          @method('patch')
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModal{{ $item->id }}Label">Edit Overtime Hours</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="hour-edit-{{ $item->id }}">Hours</label>
                                <input type="number" class="form-control" name="hour" value="{{ $item->hour }}" id="hour-edit-{{ $item->id }}" placeholder="Overtime hours ...">
                              </div>
                              <div class="form-group">
                                <label for="date-edit-{{ $item->id }}">Date</label>
                                <input type="date" class="form-control" name="date" value="{{ $item->date }}" id="date-edit-{{ $item->id }}" placeholder="Overtime date ...">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                    <form action="/overtime-hour/{{ $item->id }}" method="post">
                      @csrf
                      @method('delete')

                      <button class="btn btn-danger" type="button" onclick="return confirm('Are you sure want to delete?')">Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>

            </table>
          </div>
        </div>
      </div>

      @if (auth()->user()->role == 'admin')
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="chart-container" style="height:450px">
                <canvas id="chartOvertimeDryer"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="chart-container" style="height:450px">
                <canvas id="chartOvertimeFurnance"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="chart-container" style="height:450px">
                <canvas id="chartOvertimeInfra"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="chart-container" style="height:450px">
                <canvas id="chartOvertimeUtl"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </section>
</div>
@endsection
@push('scripts')
<script src="{{asset('SelainLogin/chart.js')}}"></script>

<script type="text/javascript" src="{{asset('SelainLogin/tablesearch/DataTables/datatables.min.js')}}"></script>

<script src="SelainLogin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="SelainLogin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="SelainLogin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="SelainLogin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="SelainLogin/plugins/jszip/jszip.min.js"></script>
<script src="SelainLogin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="SelainLogin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="SelainLogin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(document).ready(function() {
    $('#tabeluser').DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>

<script>
  const dataFurncanceOvertime = {
    labels: {!!json_encode($furnanceUser) !!},
    datasets: [{
      label: 'Furnance Overtime',
      data: {!!json_encode($furnanceHours) !!},
      backgroundColor: 'rgb(180, 200, 145)',
      borderWidth: 1
    }]
  };

  const furnanceConfig = {
    type: 'bar',
    data: dataFurncanceOvertime,
    options: {
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 100
        }
      },
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'Furnance Overtime'
        }
      }
    }
  };

  const myChartManhours = new Chart(
    document.getElementById('chartOvertimeFurnance'),
    furnanceConfig
  );

  const dataDryerOvertime = {
    labels: {!!json_encode($dryerUser) !!},
    datasets: [{
      label: 'DryerKlin Overtime',
      data: {!!json_encode($dryerHours) !!},
      backgroundColor: 'rgb(180, 200, 145)',
      borderWidth: 1
    }]
  };

  const dryerConfig = {
    type: 'bar',
    data: dataDryerOvertime,
    options: {
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 100
        }
      },
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'DryerKlin Overtime'
        }
      }
    }
  };

  const chartDryer = new Chart(
    document.getElementById('chartOvertimeDryer'),
    dryerConfig
  );

  const dataInfraOvertime = {
    labels: {!!json_encode($infraUser) !!},
    datasets: [{
      label: 'Infrastructure Overtime',
      data: {!!json_encode($infraHours) !!},
      backgroundColor: 'rgb(180, 200, 145)',
      borderWidth: 1
    }]
  };

  const infraConfig = {
    type: 'bar',
    data: dataInfraOvertime,
    options: {
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 100
        }
      },
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'Infrastructure Overtime'
        }
      }
    }
  };

  const infraChart = new Chart(
    document.getElementById('chartOvertimeInfra'),
    infraConfig
  );

  const dataOvertime = {
    labels: {!!json_encode($utlUser) !!},
    datasets: [{
      label: 'Utilities Overtime',
      data: {!!json_encode($utlHours) !!},
      backgroundColor: 'rgb(180, 200, 145)',
      borderWidth: 1
    }]
  };

  const utlConfig = {
    type: 'bar',
    data: dataOvertime,
    options: {
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 100
        }
      },
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'Utilities Overtime'
        }
      }
    }
  };

  const utlChart = new Chart(
    document.getElementById('chartOvertimeUtl'),
    utlConfig
  );

  function fetchDataAndPopulate(selectedId) {
    // Assuming you have an API endpoint that returns data based on the selected ID
    const apiUrl = `/tambahmcu?id=${selectedId}`;

    // Perform a fetch request to the API
    fetch(apiUrl, {
        headers: {
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);

        // Get the second select element
        const select2 = document.getElementById('employee');

        // Clear existing options
        select2.innerHTML = '';

        // Populate options based on API data
        data.forEach(item => {
          const option = document.createElement('option');
          option.value = item.id;
          option.text = item.name; // Assuming your API returns 'name' property
          select2.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching data:', error));
  }
</script>
@endpush

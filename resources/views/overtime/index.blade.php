@extends('master')
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

      <!-- Modal -->
      <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="/overtime-hour-export" method="post">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Overtime Hours</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="from">From</label>
                  <input type="date" class="form-control" name="from" id="from">
                </div>
                <div class="form-group">
                  <label for="to">From</label>
                  <input type="date" class="form-control" name="to" id="to">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Export</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <form action="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ request('name') }}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="from">From</label>
                  <input type="date" class="form-control" name="from" id="from" value="{{ request('from') }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="to">To</label>
                  <div class="row">
                    <div class="col">
                      <input type="date" class="form-control" name="to" id="to" value="{{ request('to') }}">
                    </div>
                    <div class="col d-flex">
                      <button type="submit" class="btn btn-primary mr-3">Filter</button>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">Export</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
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

@extends('master')
@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Training Status</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Training Status</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('training-status.update', $trainingStatus->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('patch')

              <div class="card-body">
                <div class="form-group">
                  <label for="name">Training Name</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ $trainingStatus->name }}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Area</label>
                  <select class="form-control" name="area_id" onchange="fetchDataAndPopulate(this.value)">
                    <option>Select Area</option>
                    @foreach ($areas as $id => $data)
                    <option value="{{$data->id}}" @selected($trainingStatus->employee->area->id == $data->id)>{{$data->area}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Employee</label>
                  <select class="form-control" name="user_id" id="employee">
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->id }}" @selected($trainingStatus->employee->id == $employee->id)>{{ $employee->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Certif Date</label>
                  <input type="date" class="form-control" name="certif_date" placeholder="Certif Date" value="{{ $trainingStatus->certif_date->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status" id="status">
                    <option>Select Status</option>
                    <option value="1" @selected($trainingStatus->status == 1)>Active</option>
                    <option value="2" @selected($trainingStatus->status == 2)>Warning</option>
                    <option value="3" @selected($trainingStatus->status == 3)>Expired</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Training Schedule</label>
                  <input type="date" class="form-control" name="training_schedule" placeholder="Certif Date" value="{{ $trainingStatus->training_schedule }}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Submit </button>
                </div>
              </div>
              <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

@push('scripts')
<script>
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

@endsection

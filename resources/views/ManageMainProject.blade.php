@extends('master')
@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage Main Project</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Manage Main Project</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  @if(session()->has('success'))
  <div class="alert alert-success" role="alert">
    Data Saved succesfully!
  </div>
  @endif
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->

      </div>

      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">List Tasks</h3>
          </div>
          <div class="card-body">
            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#TaskModal">Add Task</button>
            <p>&nbsp;</p>

            <div class="row">
              <div class="col-2">
                <b>Task Name</b>
              </div>
              <div class="col-2">
                <b>Area</b>
              </div>
              <div class="col-2">
                <b>Owner</b>
              </div>
              <div class="col-1">
                <b>Priority</b>
              </div>
              <div class="col-1">
                <b>Duration (Days)</b>
              </div>
              <div class="col-2">
                <b>Start</b>
              </div>
              <div class="col-1">
                <b>Status</b>
              </div>
              <div class="col-1">
                <b> Action</b>
              </div>
            </div>

            <hr>

            <form action="{{url('updateMainTask')}}" method="POST">
              @csrf
              {{-- Value --}}
              @foreach ($tasks as $task)
              <input type="hidden" name="id[]" value="{{$task->id}}">
              <div class="row">
                <div class="col-2">
                  <input type="text" class="form-control" name="name[]" value="{{$task->name}}">
                </div>
                <div class="col-2">
                  <select class="form-control" name="area_id[]" onchange="fetchDataAndPopulate(this.value, 'owner-{{ $task->id }}')">
                    @foreach ($areas as $data)
                    <option value="{{$data->id}}" {{ ($task->area_id === $data->id) ? 'selected' : '' }}>{{$data->area}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-2">
                  <select name="owner[]" class="form-control" data-name="owner-{{ $task->id }}">
                    @foreach ($list_user as $id => $name)
                    <option value="{{$id}}" {{ ($id == $task->user_id) ? 'selected' : '' }}>{{$name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-1">
                  <select name="priority[]" class="form-control">
                    <option value="Low" {{ ("Low" == $task->priority) ? 'selected' : '' }}>Low</option>
                    <option value="Med" {{ ("Med" == $task->priority) ? 'selected' : '' }}>Med</option>
                    <option value="High" {{ ("High" == $task->priority) ? 'selected' : '' }}>High</option>
                  </select>
                </div>
                <div class="col-1">
                  <input type="number" class="form-control" name="duration[]" value="{{$task->duration}}">
                </div>
                <div class="col-2">

                  <input type="date" class="form-control" name="start_date[]" value="{{ date_format($task->start_date,"Y-m-d") }}">
                </div>
                <div class="col-1">
                  <select name="status[]" class="form-control">
                    <option value="Not Started" {{ ("Not Started" == $task->status) ? 'selected' : '' }}>Not Started</option>
                    <option value="In Progress" {{ ("In Progress" == $task->status) ? 'selected' : '' }}>In Progress</option>
                    <option value="Complete" {{ ("Complete" == $task->status) ? 'selected' : '' }}>Complete</option>
                    <option value="Overdue" {{ ("Overdue" == $task->status) ? 'selected' : '' }}>Overdue</option>
                  </select>
                </div>
                <div class="col-1">
                  <a href="{{url('task').'/'.$task->id.'/delete'}}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> </a>
                </div>
              </div>
              <br>
              @endforeach

              <br>
              <button type="submit" class="btn btn-success float-right">Save</button>
            </form>
          </div>
        </div>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="TaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="TaskModalLabel">Add Task</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{url('inputMainTask')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="name">Task Name</label>
                  <input type="text" required name="name" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Area</label>
                  <select class="form-control" name="area_id" onchange="fetchDataAndPopulate(this.value, 'owner')">
                    <option>Select Area</option>
                    @foreach ($areas as $id => $data)
                    <option value="{{$data->id}}">{{$data->area}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="name">Owner</label>
                  <select name="owner" class="form-control" data-name="owner">

                  </select>
                </div>
                <div class="form-group">
                  <label for="name">Priority</label>
                  <select name="priority" class="form-control">
                    <option value="Low">Low</option>
                    <option value="Med">Med</option>
                    <option value="High">High</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="name">Start Date</label>
                  <input type="date" required name="start_date" class="form-control">
                </div>
                <div class="form-group">
                  <label for="name">Duration</label>
                  <input type="number" required name="duration" class="form-control">
                </div>
                <div class="form-group">
                  <label for="name">Status</label>
                  <select name="status" class="form-control">
                    <option value="Not Started">Not Started</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Complete">Complete</option>
                    <option value="Overdue">Overdue</option>
                  </select>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>

    </div>
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
  function fetchDataAndPopulate(selectedId, target) {
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
        const select2 = document.querySelector(`[data-name="${target}"]`);

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

@extends('master')
@section('content')

<fieldset {{Auth::user()->role != 'admin' ? 'disabled' : '' }}>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Furnace-Converter</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Furnace-Converter</li>
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


          {{-- Employee Status Per Day --}}
          <div class="col-12">
            <form action="{{url('inputfurconvStatusPerDay')}}" method="POST">
              @csrf
              <div class="col-md-12">
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Employee Status Per Day</h3>
                  </div>
                  <div class="card-body">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-3">
                          <div class="form-group">
                            <label for="dateInput">Date</label>
                            <input type="date" name="datestatus" class="form-control" id="dateInput">
                          </div>
                        </div>
                      </div>
                      <div class="text-left">
                        {{-- Header --}}
                        <div class="row">
                          <div class="col-4">
                            <p><b>Name</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Office</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>HO</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Training</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Sick Leave</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Annual Leave</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Emergency Leave</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Medical Check up</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Maternity Leave</b></p>
                          </div>
                          <div class="col-1">
                            <p><b>Total WTA</b></p>
                          </div>
                        </div>
                        {{-- Body --}}
                        @foreach ($user as $employee)
                        <div class="row">
                          <div class="col-4">
                            <p>{{$employee->name}}</p>
                          </div>
                          <input type="hidden" name="employee[]" value="{{$employee->id}}">
                          <div class="col-1">
                            <input type="number" name="offices[]" class="form-control" value="{{$employee->todaystatusperday->office ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="hos[]" class="form-control" value="{{$employee->todaystatusperday->ho ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="trainings[]" class="form-control" value="{{$employee->todaystatusperday->training ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="sick_leaves[]" class="form-control" value="{{$employee->todaystatusperday->sick_leave ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="annual_leaves[]" class="form-control" value="{{$employee->todaystatusperday->annual_leave ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="emergency_leaves[]" class="form-control" value="{{$employee->todaystatusperday->emergency_leave ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="medical_leaves[]" class="form-control" value="{{$employee->todaystatusperday->medical_leave ?? ''}}">
                          </div>
                          <div class="col-1">
                            <input type="number" name="maternity_leaves[]" class="form-control" value="{{$employee->todaystatusperday->maternity_leave ?? ''}}">
                          </div>
                        </div>
                        @endforeach


                      </div>
                      <br>
                      <button type="submit" class="btn btn-success text-right">Save</button>
                      <!-- /.card-body -->


                      <!-- /.card-body -->
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          {{-- Employee Status Per Day --}}

          {{-- Safety Report --}}
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Safety Report</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('/inputfurconv')}}" method="POST">
                @csrf
                <div class="card-body text-right">
                  <div class="text-left">
                    {{-- Header --}}
                    <div class="row">
                      <div class="col-4">
                        <p><b>Nama</b></p>
                      </div>
                      <div class="col-8">
                        <p><b>Count</b></p>
                      </div>
                    </div>
                    {{-- Body --}}
                    @foreach ($user as $employee)

                    <div class="row">
                      <div class="col-4">
                        <p>{{$employee->name}}</p>
                      </div>
                      <input type="hidden" value="{{$employee->id}}" name="employee[]">
                      <div class="col-8">
                        <input type="number" class="form-control" name="count[]" value="{{$employee->today_safety_report->count ?? ''}}">
                      </div>
                    </div>
                    @endforeach
                  </div>
                  <br>
                  <button type="submit" class="btn btn-success text-right">Save</button>
                  <!-- /.card-body -->
              </form>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          {{-- End of Safety Report --}}
        </div>

        {{-- Organization Structure --}}
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Organization Structure</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('/inputfurconvOrganization')}}" method="POST">
              @csrf
              <div class="card-body text-right">
                <div class="text-left">
                  {{-- Header --}}
                  <div class="row">
                    <div class="col-4">

                    </div>
                    <div class="col-8">
                      <p><b>Value</b></p>
                    </div>
                  </div>
                  {{-- Body --}}
                  <div class="row">
                    <div class="col-4">
                      <p>Organization Structure</p>
                    </div>
                    <div class="col-8">
                      <input required type="number" class="form-control" max="100" name="value" value="{{$organization->value ?? ''}}">
                    </div>
                  </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success text-right">Save</button>
                <!-- /.card-body -->
            </form>

            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        {{-- End of Organization Structure --}}
      </div>

      {{-- Kaizen --}}
      <div class="col-md-4">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Kaizen</h3>
          </div>

          <form action="{{url('/inputfurconvKaizen')}}" method="POST">
            @csrf
            <div class="card-body text-right">
              <div class="text-left">
                {{-- Header --}}
                <div class="row">
                  <div class="col-4">

                  </div>
                  <div class="col-8">
                    <p><b>Value</b></p>
                  </div>
                </div>
                {{-- Body --}}
                <div class="row">
                  <div class="col-4">
                    <p>Kaizen</p>
                  </div>
                  <div class="col-8">
                    <input required type="number" class="form-control" max="100" name="value" value="{{$kaizen->value ?? ''}}">
                  </div>
                </div>
              </div>
              <br>
              <button type="submit" class="btn btn-success text-right">Save</button>
              <!-- /.card-body -->
          </form>
        </div>
      </div>
  </div>

  <div class="col-12">
    {{-- Working TIme Allocation --}}
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Productivity</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{url('/inputfurconvProductivity')}}" method="POST">
          @csrf
          <div class="card-body text-right">
            <div class="text-left">
              {{-- Header --}}
              <div class="row">
                <div class="col-4">
                  <p><b>Department</b></p>
                </div>
                <div class="col-8">
                  <p><b>Update</b></p>
                </div>
              </div>
              {{-- Body --}}
              @foreach ($departments as $department)
              <div class="row">
                <div class="col-4">
                  <p>{{$department->name}}</p>
                </div>
                <input type="hidden" name="department[]" value="{{$department->id}}">
                <div class="col-8">
                  <input type="number" name="departmentValue[]" class="form-control" max=100 value="{{$department->today_productivity->update ?? ''}}">
                </div>
              </div>
              @endforeach
            </div>
            <br>
            <button type="submit" class="btn btn-success text-right">Save</button>
            <!-- /.card-body -->

        </form>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    {{-- End of Working TIme Allocation --}}
  </div>

  <form action="{{url('inputfurconvWorkingWeek')}}" method="POST">
    @csrf
    {{-- Working time per week --}}

    {{-- End Working time per week --}}
  </form>


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
          <form action="{{url('inputfurconvTask')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Task Name</label>
              <input type="text" required name="name" class="form-control">
            </div>
            <div class="form-group">
              <label for="name">Owner</label>
              <select name="owner" class="form-control">
                @foreach ($list_user as $id => $name)
                <option value="{{$id}}">{{$name}}</option>
                @endforeach
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

</fieldset>

@endsection

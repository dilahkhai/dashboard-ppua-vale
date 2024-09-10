@extends('master')

@section('css')
<style>
  .calendar-card {
    margin-right: 20px; /* Menambahkan jarak di sebelah kanan kartu kalender pertama */
  }
</style>
@endsection

@section('content')
<div class="content-wrapper position-relative">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">FMDS Meeting Process Plant Utilities Automation</h1>
        </div>
      </div>

      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif

      @if(session()->has('fail'))
      <div class="alert alert-danger" role="alert">
        {{ session('fail') }}
      </div>
      @endif
    </div>
  </div>

  <div class="row">
    <div class="container mt-4">
      <div class="row">
        <!-- Safety Share Schedule Card -->
        <div class="card calendar-card" style="width: 35rem;">
          <div class="card-header text-center"><b>Safety Share Schedule</b></div>
          <div class="card-body">
            <div id="calendar"></div>
            <div class="row mt-3">
              <div class="col-md-3">
                @if (auth()->user()->role == 'admin')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSchedule">
                  Add Schedule
                </button>
                @endif
              </div>
            </div>

            <!-- Add Schedule Modal -->
            <div class="modal fade" id="addSchedule" tabindex="-1" aria-labelledby="addScheduleLabel" aria-hidden="true">
              <div class="modal-dialog">
                <form action="{{ route('safety-share.store') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addScheduleLabel">Add Safety Share Schedule</h5>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="name">Employee</label>
                        <select class="form-control" name="name" id="name">
                          <option>-- Select Employee --</option>
                          <option value="Abd. Marlin">Abd. Marlin</option>
                          <option value="Utilities">Utilities</option>
                          <option value="Process Plant">Process Plant</option>
                          <option value="Infrastructure">Infrastructure</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="safetydate" id="safetydate">
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

            <!-- Delete Schedule Modal for Safety Share -->
            <div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                @foreach($safetyShares as $safetyShare)
                <form action="{{ route('safety-share.destroy', $safetyShare->id) }}" method="post" id="deleteScheduleForm">
                  @csrf
                  @method('DELETE')
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteScheduleModalLabel">Delete Safety Share Schedule</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="employee_name">Employee Name</label>
                        <input type="text" class="form-control" name="employee_name" id="employee_name" value="{{$safetyShare->name}}" readonly>
                      </div>
                      <div class="form-group">
                        <label for="safety_date">Date</label>
                        <input type="text" name="safety_date" class="form-control" id="safety_date" value="{{$safetyShare->safetydate}}" readonly>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      @if (auth()->user()->role == 'admin')
                      <button type="submit" class="btn btn-danger">Delete</button>
                      @endif
                    </div>
                  </div>
                </form>
                @endforeach
              </div>
            </div>

          </div>
        </div>

        <!-- FMDS 9.0 Schedule Card -->
        <div class="card" style="width: 35rem;">
          <div class="card-header text-center"><b>FMDS 9.0 Schedule</b></div>
          <div class="card-body">
            <div id="calendar2"></div>
            <div class="row mt-3">
              <div class="col-md-3">
                @if (auth()->user()->role == 'admin')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFmdsSchedule">
                  Add Schedule
                </button>
                @endif
              </div>
            </div>

            <!-- Add FMDS Schedule Modal -->
            <div class="modal fade" id="addFmdsSchedule" tabindex="-1" aria-labelledby="addFmdsScheduleLabel" aria-hidden="true">
              <div class="modal-dialog">
                <form action="{{ route('fmds.store') }}" method="post">
                  @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addFmdsScheduleLabel">Add FMDS 9.0 Schedule</h5>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="area">Area</label>
                        <select class="form-control" name="area_id" id="area">
                          <option>-- Select Area --</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->id }}">{{ $area->area }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="fmds_date">Date</label>
                        <input type="date" class="form-control" name="fmds_date" id="fmds_date">
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

            <!-- Delete FMDS Schedule Modal -->
            <div class="modal fade" id="deleteFmdsModal" tabindex="-1" aria-labelledby="deleteFmdsModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                @foreach($fmdsSchedules as $fmdsSchedule)
                <form action="{{ route('fmds.destroy', $fmdsSchedule->id) }}" method="post" id="deleteFmdsForm">
                  @csrf
                  @method('DELETE')
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteFmdsModalLabel">Delete FMDS 9.0 Schedule</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="fmds_area">Area</label>
                        <input type="text" class="form-control" name="fmds_area" id="fmds_area" value="{{$fmdsSchedule->area->area}}">
                      </div>
                      <div class="form-group">
                        <label for="fmds_date">Date</label>
                        <input type="text" name="fmds_date" class="form-control" id="fmds_date" value="{{$fmdsSchedule->fmds_date}}">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      @if (auth()->user()->role == 'admin')
                      <button type="submit" class="btn btn-danger">Delete</button>
                      @endif
                    </div>
                  </div>
                </form>
                @endforeach
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="container">
      <div class="card">
        <div class="card-header text-center"><b>Man Power</b></div>
        <div class="card-body">
          <!-- Filter Form -->
          <form action="{{ route('manpower.show') }}" method="GET" class="mb-4" id="filter-form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date">Start Date</label>
                  <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $startDate ?? '' }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $endDate ?? '' }}">
                </div>
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </div>
          </form>

          <!-- Manpower Data Table -->
          <div id="manpower-table">
            @if(isset($startDate) && isset($endDate))
              @if(!$manpowers->isEmpty())
                @foreach($manpowers as $manPower)
                  <div class="card mb-3">
                    <div class="card-body">
                      <h5>{{ $manPower->date }}</h5>
                      <h5>Area: {{ $manPower->area ? $manPower->area->area : 'No Area' }}</h5>
                      <h5>Leader: {{ $manPower->user ? $manPower->user->name : 'No Leader' }}</h5>
                      <table class="table">
                        <thead>
                          <tr>
                            <th width="150px">Vale</th>
                            <th width="100px">Total</th>
                            <th width="400px">Name</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Total Hadir</td>
                            <td>{{ $manPower->crew_total }}</td>
                            <td>{{ $manPower->crew_total_man }}</td>
                          </tr>
                          <tr>
                            <td>Leave</td>
                            <td>{{ $manPower->crew_leave }}</td>
                            <td>{{ $manPower->crew_leave_man }}</td>
                          </tr>
                          <tr>
                            <td>Sick Leave</td>
                            <td>{{ $manPower->crew_sick_leave }}</td>
                            <td>{{ $manPower->crew_sick_leave_man }}</td>
                          </tr>
                          <tr>
                            <td>Medical Check Up</td>
                            <td>{{ $manPower->crew_mcu }}</td>
                            <td>{{ $manPower->crew_mcu_man }}</td>
                          </tr>
                          <tr>
                            <td>Total Man Power</td>
                            <td>{{ $manPower->crew_total_power }}</td>
                            <td>{{ $manPower->crew_total_power_man }}</td>
                          </tr>
                        </tbody>
                      </table>

                      <table class="table">
                        <thead>
                          <tr>
                            <th width="150px">Contractor</th>
                            <th width="100px">Total</th>
                            <th width="400px">Name</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Total Hadir</td>
                            <td>{{ $manPower->contractor_total }}</td>
                            <td>{{ $manPower->contractor_total_man }}</td>
                          </tr>
                          <tr>
                            <td>Leave</td>
                            <td>{{ $manPower->contractor_leave }}</td>
                            <td>{{ $manPower->contractor_leave_man }}</td>
                          </tr>
                          <tr>
                            <td>Sick Leave</td>
                            <td>{{ $manPower->contractor_sick_leave }}</td>
                            <td>{{ $manPower->contractor_sick_leave_man }}</td>
                          </tr>
                          <tr>
                            <td>Medical Check Up</td>
                            <td>{{ $manPower->contractor_mcu }}</td>
                            <td>{{ $manPower->contractor_mcu_man }}</td>
                          </tr>
                          <tr>
                            <td>Total Man Power</td>
                            <td>{{ $manPower->contractor_total_power }}</td>
                            <td>{{ $manPower->contractor_total_power_man }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                @endforeach
              @else
                <p>No data available for the selected date range.</p>
              @endif
            @else
              <p>Please set the date filter to see the data.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="container">
      <div class="card text-center">
        <div class="card-header"><b>Safety Report</b></div>
        <div class="card-body">
          <br>
          <h4 class="card-text">PTVI CRM (LIF & CCV)</h4>
          <br>
          <a href="#" class="btn btn-primary">Go to POWERBI</a>
          <br><br><br>
        </div>
      </div>
    </div>
  </div>

</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: '{{ route("safety-share.source") }}',
        themeSystem: 'bootstrap',
        initialView: 'dayGridMonth',
        eventClick: function(info) {
            console.log("Event clicked:", info.event);  
            $('#deleteScheduleModal').modal();  
            $.ajax({
                url: `/safety-share/${info.event.id}`,
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("AJAX response:", response); 
                    $('#employee_name').val(response.name);
                    $('#safety_date').val(response.date);
                    $('#deleteScheduleForm').attr('action', `/safety-share/${response.id}`);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    });
    calendar.render();

    var calendarEl2 = document.getElementById('calendar2');
    var calendar2 = new FullCalendar.Calendar(calendarEl2, {
        events: '{{ route("fmds.source") }}',
        themeSystem: 'bootstrap',
        initialView: 'dayGridMonth',
        eventClick: function(info) {
          console.log("Event clicked:", info.event);  
            $('#deleteFmdsModal').modal();
            $.ajax({
                url: `fmds/${info.event.id}`,
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#fmds_area').val(response.area);
                    $('#fmds_date').val(response.date);
                    $('#deleteFmdsForm').attr('action', `/fmds/${response.id}`);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    });
    calendar2.render();
  });
</script>
@endsection

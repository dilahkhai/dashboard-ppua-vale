@extends('master')

@section('css')
<style>
  /* Your existing CSS */
</style>
@endsection

@section('content')
<div class="content-wrapper position-relative">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">FMDS</h1>
        </div>
      </div>

      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif

      @if(session()->has('fail'))
      <div class="alert alert-danger" role="alert">
        Failed!
      </div>
      @endif
    </div>
  </div>

  <div class="container">
    <div class="card">
    <div class="card-header text-center"><b>Safety Report Schedule</b></div>
    <div class="card-body">
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
                        <option value="Infastructure">Infrastructure</option>
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

        @if (auth()->user()->role == 'admin')
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            @foreach($safetyShares as $safetyShare)
              <form action="{{ route('safety-share.destroy', $safetyShare->id) }}" method="post" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Safety Share Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="employee_name">Employee</label>
                    <input type="text" class="form-control" name="employee_name" id="employee_name" readonly>
                  </div>
                  <div class="form-group">
                    <label for="safety_date">Date</label>
                    <input type="text" name="safety_date" class="form-control" id="safety_date" readonly>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Delete</button></div>
            </form>
            @endforeach
        </div>
    </div>
</div>
@endif

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
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">
                </div>
              </div>
              <div class="col-md-6">
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
                            <th>Crew</th>
                            <th>Total</th>
                            <th>Name</th>
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
                            <th>Contractor</th>
                            <th>Total</th>
                            <th>Name</th>
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

<!-- Load Calendar Script -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
      var calendar = new FullCalendar.Calendar(calendarEl, {
        events: '{{ route("safety-share.source") }}',
        themeSystem: 'bootstrap',
        initialView: 'dayGridMonth',
        eventClick: function(info) {
          $('#exampleModal').modal()
          $.ajax({
            url: `/sharing-schedule-source-detail?sharing_date=${new Date(info.event.start).toLocaleDateString()}`,
            method: 'get',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
              $('#employee_name').val(response.name);
              $('#safety_date').val(response.date);
            },
            error: function(error) {
              console.error(error);
            }
          });
        }
      });
      calendar.render();
    } else {
      console.error('Calendar element not found.');
    }
  });
</script>
@endsection

@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
      Data Saved successfully!
    </div>
  @endif

  <!-- Main content -->
  <section class="content">
      <div class="row">
        <div class="container">
        <div class="card">
          <div class="card-header">Output Man Power</div>
          <div class="card-body">
            <!-- Filter Form -->
            <form action="{{ route('manpower.show') }}" method="GET" class="mb-4">
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

            @if(isset($manpowers))
              <!-- Manpower Data Table -->
              @if($manpowers->isEmpty())
                <p>No data available for the selected date range.</p>
              @else
                @foreach($manpowers as $manPower)
                  <div class="card mb-3">
                    <div class="card-header">
                      {{ $manPower->user ? $manPower->user->name : 'No User' }} - {{ $manPower->date }}
                    </div>
                    <div class="card-body">
                      <h5>Area: {{ $manPower->area ? $manPower->area->name : 'No Area' }}</h5>
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
                {{ $manpowers->links() }}
              @endif
            @endif
          </div>
        </div>
        </div>
      </div>
  </section>
</div>
@endsection

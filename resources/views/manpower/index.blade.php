@extends('master')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Man Power</h1>
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
    <div class="container-fluid">
      <a href="{{ route('man-power.history') }}" class="btn btn-primary mb-3">View History</a>
      <div class="row">
        @foreach ($areas as $area)
        @if(auth()->user()->is_admin || auth()->user()->area_id == $area->id)
        <div class="col-md-6">
          <form action="{{ route('man-power.store') }}" method="post">
            <input type="hidden" name="area_id" value="{{ $area->id }}">

            @csrf
            <div class="card">
              <div class="card-header">Input Man Power</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="employee">Leader</label>
                      <select class="form-control" name="employee" id="employee">
                        <option value="">-- Select Employee --</option>
                        @if(isset($users[$area->id]))
                          @foreach ($users[$area->id] as $user)
                            <option value="{{ $user->id }}" {{ old('employee') == $user->id ? 'selected' : '' }}>
                              {{ $user->name }}
                            </option>
                          @endforeach
                        @else
                          <option value="">No users available</option>
                        @endif
                      </select>
                      @error('employee')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="date">Date</label>
                    <p>{{ today()->format('d F Y') }}</p>
                  </div>
                  <div class="col-md-6">
                    <label for="area">Area</label>
                    <p>{{ $area->area ?? 'No area information' }}</p>
                  </div>
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Vale</th>
                      <th>Total</th>
                      <th>Man</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Total Hadir</td>
                      <td>
                        <input type="text" class="form-control" name="crew_total">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_total_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Leave</td>
                      <td>
                        <input type="text" class="form-control" name="crew_leave">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_leave_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Sick Leave</td>
                      <td>
                        <input type="text" class="form-control" name="crew_sick_leave">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_sick_leave_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Medical Check Up</td>
                      <td>
                        <input type="text" class="form-control" name="crew_mcu">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_mcu_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Total Man Power</td>
                      <td>
                        <input type="text" class="form-control" name="crew_total_power">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_total_power_man">
                      </td>
                    </tr>
                  </tbody>
                </table>

                <table class="table">
                  <thead>
                    <tr>
                      <th>Contractor</th>
                      <th>Total</th>
                      <th>Man</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Total Hadir</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_total">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_total_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Leave</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_leave">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_leave_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Sick Leave</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_sick_leave">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_sick_leave_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Medical Check Up</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_mcu">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_mcu_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Total Man Power</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_total_power">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_total_power_man">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
              @if(auth()->user()->isAdmin || auth()->user()->isLeader)
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
              @endif
              </div>
            </div>
          </form>
        </div>
        @endif
        @endforeach
      </div>
    </div>
  </section>
</div>

@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('input[name="date"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
        format: 'YYYY-MM-DD'
      }
    });
  });
</script>
@endpush

@endsection

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
    Data Saved succesfully!
  </div>
  @endif

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <a href="{{ route('man-power.history') }}" class="btn btn-primary mb-3">View History</a>
      <div class="row">
        @foreach ($areas as $area)
        <div class="col-md-6">
          <form action="{{ route('man-power.store') }}" method="post">
            <input type="hidden" name="area" value="{{ $area->id }}">

            @csrf
            <div class="card">
              <div class="card-header">Input Man Power</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Leader</label>
                      <select class="form-control" name="employee" id="employee">
                        <option value="">-- Select Employee --</option>
                        @foreach ($users[$area->id] as $user)
                        <option value="{{ $user->id }}" {{ $user->id == (array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->user?->id : '') ? 'selected' : ''}}>{{ $user->name }}</option>
                        @endforeach
                      </select>
                      @error('employee')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="exampleInputPassword1">Date</label>
                    <p>{{ today()->format('d F Y') }}</p>
                  </div>
                  <div class="col-md-6">
                    <label for="exampleInputPassword1">Area</label>
                    <p>{{ $area->area }}</p>
                  </div>
                </div>
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
                      <td>
                        <input type="text" class="form-control" name="crew_total" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->total : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_total_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->total_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>UTW - Medical Recomm</td>
                      <td>
                        <input type="text" class="form-control" name="crew_utw" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->utw : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_utw_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->utw_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Quarantine</td>
                      <td>
                        <input type="text" class="form-control" name="crew_quarantine" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->quarantine : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_quarantine_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->quarantine_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Leave</td>
                      <td colspan="2">
                        <a href="{{ route('employee-leave.index', [$manpowers[$area->id]->id]) }}" class="btn btn-primary">Input Leave</a>
                      </td>
                    </tr>
                    <tr>
                      <td>Sick Leave</td>
                      <td>
                        <input type="text" class="form-control" name="crew_sick_leave" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->sick_leave : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_sick_leave_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->sick_leave_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Control MCU</td>
                      <td>
                        <input type="text" class="form-control" name="crew_mcu" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->mcu : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_mcu_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->mcu_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>OT Hours</td>
                      <td>
                        <input type="text" class="form-control" name="crew_ot_hours" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->ot_hours : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_ot_hours_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->ot_hours_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>OT</td>
                      <td>
                        <input type="text" class="form-control" name="crew_ot" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->ot : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_ot_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->ot_man : '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td>Total Man Power</td>
                      <td>
                        <input type="text" class="form-control" name="crew_total_power" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->total_power : '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="crew_total_power_man" value="{{ array_key_exists($area->id, $manpowers->toArray()) ? $manpowers[$area->id]->crew?->power_man : '' }}">
                      </td>
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
                      <td>
                        <input type="text" class="form-control" name="contractor_total">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_total_man">
                      </td>
                    </tr>
                    <tr>
                      <td>UTW - Medical Recomm</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_utw">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_utw_man">
                      </td>
                    </tr>
                    <tr>
                      <td>Quarantine</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_quarantine">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_quarantine_man">
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
                      <td>Control MCU</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_mcu">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_mcu_man">
                      </td>
                    </tr>
                    <tr>
                      <td>OT Hours</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_ot_hours">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_ot_hours_man">
                      </td>
                    </tr>
                    <tr>
                      <td>OT</td>
                      <td>
                        <input type="text" class="form-control" name="contractor_ot">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="contractor_ot_man">
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
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
        @endforeach
      </div>
    </div>
  </section>
</div>
@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="application/javascript">
  $('input[name="crew_date_leave"]').daterangepicker();
  $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
  });

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
        // Get the second select element
        const select2 = document.getElementById('employee');

        // Clear existing options
        select2.innerHTML = '';

        const selectOption = document.createElement('option');
        selectOption.value = ''
        selectOption.text = 'Select Leader'
        select2.appendChild(selectOption)

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

@extends('master')
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
      <div class="row">
        <div class="card">
          <div class="card-header">Input Man Power</div>
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputPassword1">Date</label>
              <input disabled required type="date" class="form-control" value="{{ $manPower->date }}" placeholder="">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Area</label>
                  <input disabled type="text" class="form-control" value="{{ $manPower->user->area->area }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Leader</label>
                  <input disabled type="text" class="form-control" value="{{ $manPower->user->name }}">
                </div>
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
                    <input disabled required type="text" class="form-control" name="crew_total" disabled value="{{ $manPower->crew->total }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_total_man" disabled value="{{ $manPower->crew->total_man }}">
                  </td>
                </tr>
                <tr>
                  <td>UTW - Medical Recomm</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_utw" value="{{ $manPower->crew->utw }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_utw_man" value="{{ $manPower->crew->utw_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Quarantine</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_quarantine" value="{{ $manPower->crew->quarantine }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_quarantine_man" value="{{ $manPower->crew->quarantine_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Leave</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_leave" value="{{ $manPower->crew->leave }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_leave_man" value="{{ $manPower->crew->leave_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Sick Leave</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_sick_leave" value="{{ $manPower->crew->sick_leave }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_sick_leave_man" value="{{ $manPower->crew->sick_leave_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Control MCU</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_mcu" value="{{ $manPower->crew->mcu }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_mcu_man" value="{{ $manPower->crew->mcu_man }}">
                  </td>
                </tr>
                <tr>
                  <td>OT Hours</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_ot_hours" value="{{ $manPower->crew->ot_hours }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_ot_hours_man" value="{{ $manPower->crew->ot_hours_man }}">
                  </td>
                </tr>
                <tr>
                  <td>OT</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_ot" value="{{ $manPower->crew->ot }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_ot_man" value="{{ $manPower->crew->ot_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Total Man Power</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_total_power" value="{{ $manPower->crew->total_power }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="crew_total_power_man" value="{{ $manPower->crew->total_power_man }}">
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
                    <input disabled required type="text" class="form-control" name="contractor_total" value="{{ $manPower->contractor->total }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_total_man" value="{{ $manPower->contractor->total_man }}">
                  </td>
                </tr>
                <tr>
                  <td>UTW - Medical Recomm</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_utw" value="{{ $manPower->contractor->utw }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_utw_man" value="{{ $manPower->contractor->utw_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Quarantine</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_quarantine" value="{{ $manPower->contractor->quarantine }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_quarantine_man" value="{{ $manPower->contractor->quarantine_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Leave</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_leave" value="{{ $manPower->contractor->leave }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_leave_man" value="{{ $manPower->contractor->leave_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Sick Leave</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_sick_leave" value="{{ $manPower->contractor->sick_leave }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_sick_leave_man" value="{{ $manPower->contractor->sick_leave_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Control MCU</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_mcu" value="{{ $manPower->contractor->mcu }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_mcu_man" value="{{ $manPower->contractor->mcu_man }}">
                  </td>
                </tr>
                <tr>
                  <td>OT Hours</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_ot_hours" value="{{ $manPower->contractor->ot_hours }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_ot_hours_man" value="{{ $manPower->contractor->ot_hours_man }}">
                  </td>
                </tr>
                <tr>
                  <td>OT</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_ot" value="{{ $manPower->contractor->ot }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_ot_man" value="{{ $manPower->contractor->ot_man }}">
                  </td>
                </tr>
                <tr>
                  <td>Total Man Power</td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_total_power" value="{{ $manPower->contractor->total_power }}">
                  </td>
                  <td>
                    <input disabled required type="text" class="form-control" name="contractor_total_power_man" value="{{ $manPower->contractor->total_power_man }}">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@push('scripts')
<script type="application/javascript">
  $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
  });
</script>

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

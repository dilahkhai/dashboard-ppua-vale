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
        <form action="{{ route('man-power.store') }}" method="post">
          @csrf
          <div class="card">
            <div class="card-header">Input Man Power</div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputPassword1">Date</label>
                <input required type="date" class="form-control" name="date" id="exampleInputPassword1" placeholder="">
                @error('date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Area</label>
                    <select class="form-control" name="area_id" onchange="fetchDataAndPopulate(this.value)">
                      <option>Select Area</option>
                      @foreach ($areas as $id => $data)
                      <option value="{{$data->id}}">{{$data->area}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Leader</label>
                    <select class="form-control" name="employee" id="employee">
                    </select>
                    @error('employee')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
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
                      <input type="text" class="form-control" name="crew_total">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="crew_total_man">
                    </td>
                  </tr>
                  <tr>
                    <td>UTW - Medical Recomm</td>
                    <td>
                      <input type="text" class="form-control" name="crew_utw">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="crew_utw_man">
                    </td>
                  </tr>
                  <tr>
                    <td>Quarantine</td>
                    <td>
                      <input type="text" class="form-control" name="crew_quarantine">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="crew_quarantine_man">
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
                    <td>Control MCU</td>
                    <td>
                      <input type="text" class="form-control" name="crew_mcu">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="crew_mcu_man">
                    </td>
                  </tr>
                  <tr>
                    <td>OT Hours</td>
                    <td>
                      <input type="text" class="form-control" name="crew_ot_hours">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="crew_ot_hours_man">
                    </td>
                  </tr>
                  <tr>
                    <td>OT</td>
                    <td>
                      <input type="text" class="form-control" name="crew_ot">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="crew_ot_man">
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

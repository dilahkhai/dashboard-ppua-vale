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
    <div class="card">
      <div class="card-header">Man Power</div>
      <div class="card-body">
        <form action="">
          <div class="row">
            <div class="col-md-2">
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
            <div class="col-md-2">
              <div class="form-group">
                <label for="exampleInputPassword1">Leader</label>
                <select class="form-control" name="employee" id="employee">
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="from">From</label>
                <input type="date" class="form-control" name="from" id="from" value="{{ request('from') }}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="to">To</label>
                <div class="row">
                  <div class="col">
                    <input type="date" class="form-control" name="to" id="to" value="{{ request('to') }}">
                  </div>
                  <div class="col d-flex">
                    <button type="submit" class="btn btn-primary mr-3">Filter</button>
                    @if (auth()->user()->role == 'admin')
                    <a href="{{ route('man-power.index') }}" class="btn btn-primary">Input Data</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Area</th>
              <th>Leader</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($manpowers as $row)
            <tr>
              <td>{{ $row->user->area->area }}</td>
              <td>{{ $row->user->name }}</td>
              <td>{{ $row->date }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4">No Data.</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-2">
          {{ $manpowers->links() }}
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

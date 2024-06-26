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
      <div class="card-header">Input Leave</div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            @if (auth()->user()->role == 'admin')
            <button type="button" data-toggle="modal" data-target="#TaskModal" class="btn btn-primary">Input Data</button>
            @endif
          </div>
        </div>
        <table class="table table-bordered mt-4">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Leave Type</th>
              <th>Date Start</th>
              <th>Date End</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($leaves as $row)
            <tr>
              <td>{{ $row->employee->name }}</td>
              <td>{{ $row->type }}</td>
              <td>{{ $row->date_start }}</td>
              <td>{{ $row->date_end }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4">No Data.</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-2">
          {{ $leaves->links() }}
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="TaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('employee-leave.store', $manPower->id) }}" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="TaskModalLabel">Add Leave</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @csrf
            @if (auth()->user()->role == 'admin')
            <div class="form-group">
              <label for="name">Employee</label>
              <select name="user_id" class="form-control" data-name="employee">
                <option value="" selected>-- Pilih --</option>
                @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
              </select>
            </div>
            @endif
            <div class="form-group">
              <label for="type">Type</label>
              <select name="type" class="form-control">
                <option value="" selected>-- Pilih --</option>
                <option value="Sick">Sick</option>
                <option value="Annual">Annual</option>
                <option value="Leave">Leave</option>
              </select>
            </div>
            <div class="form-group">
              <label for="date_start">Date Start</label>
              <input type="date" required name="date_start" class="form-control">
            </div>
            <div class="form-group">
              <label for="date_end">Date End</label>
              <input type="date" required name="date_end" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
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

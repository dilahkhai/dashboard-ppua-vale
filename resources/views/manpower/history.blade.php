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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Man Power</h3>
        </div>
        <div class="card-body">
          <form action="" method="get">
            <div class="row">
              <!-- Area Select -->
              <div class="col-md-2">
                <div class="form-group">
                  <label for="area_id">Area</label>
                  <select class="form-control" name="area_id" id="area_id" onchange="fetchDataAndPopulate(this.value)">
                    <option value="">Select Area</option>
                    @foreach ($areas as $data)
                    <option value="{{ $data->id }}">{{ $data->area }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!-- Leader Select -->
              <div class="col-md-2">
                <div class="form-group">
                  <label for="employee">Leader</label>
                  <select class="form-control" name="employee" id="employee">
                    <option value="">Select Leader</option>
                  </select>
                </div>
              </div>
              <!-- From Date -->
              <div class="col-md-2">
                <div class="form-group">
                  <label for="from">From</label>
                  <input type="date" class="form-control" name="from" id="from" value="{{ request('from') }}">
                </div>
              </div>
              <!-- To Date -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="to">To</label>
                  <div class="row">
                    <div class="col">
                      <input type="date" class="form-control" name="to" id="to" value="{{ request('to') }}">
                    </div>
                    <div class="col d-flex align-items-end">
                      <button type="submit" class="btn btn-primary mr-2">Filter</button>
                      @if (auth()->user()->role == 'admin')
                      <a href="{{ route('man-power.index') }}" class="btn btn-secondary">Input Data</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Area</th>
                  <th>Leader</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($manpowers as $row)
                <tr>
                  <td>{{ $row->user && $row->user->area ? $row->user->area->area : 'N/A' }}</td>
                  <td>{{ $row->user ? $row->user->name : 'N/A' }}</td>
                  <td>{{ $row->date }}</td>
                  <td>
                    <form action="{{ route('man-power.destroy', $row->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4">No Data.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="mt-2 d-flex justify-content-between">
            <div>
              {{ $manpowers->links() }}
            </div>
            <div>
              @if($manpowers->currentPage() > 1)
              <a href="{{ $manpowers->previousPageUrl() }}" class="btn btn-secondary">Previous</a>
              @endif
              @if($manpowers->hasMorePages())
              <a href="{{ $manpowers->nextPageUrl() }}" class="btn btn-secondary">Next</a>
              @endif
            </div>
          </div>
        </div>
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
    const apiUrl = `/tambahmcu?id=${selectedId}`;

    fetch(apiUrl, {
        headers: {
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        const select2 = document.getElementById('employee');
        select2.innerHTML = '';

        const selectOption = document.createElement('option');
        selectOption.value = '';
        selectOption.text = 'Select Leader';
        select2.appendChild(selectOption);

        data.forEach(item => {
          const option = document.createElement('option');
          option.value = item.id;
          option.text = item.name;
          select2.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching data:', error));
  }
</script>
@endpush

@endsection

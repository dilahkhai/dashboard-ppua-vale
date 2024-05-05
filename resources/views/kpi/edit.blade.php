@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Input Key Performance Index</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit KPI</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('key-performance-index.update', $keyPerformanceIndex->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('patch')

              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Area</label>
                  <select class="form-control" name="area_id">
                    <option value="">Select Area</option>
                    @foreach ($areas as $id => $data)
                    <option value="{{$data->id}}" {{ $keyPerformanceIndex->area->id == $data->id ? 'selected' : '' }}>{{$data->area}}</option>
                    @endforeach
                  </select>
                  @error('area_id')
                    <span class="text-sm text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <textarea type="date" class="form-control" name="title" placeholder="Title">{{ $keyPerformanceIndex->title }}</textarea>
                  @error('title')
                    <span class="text-sm text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <div class="d-flex">
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="checkbox" value="Junior Engineer" id="junior_engineer" name="allowed[]" {{ in_array("Junior Engineer", $keyPerformanceIndex->allowed) ? 'checked' : '' }}>
                      <label class="form-check-label" for="junior_engineer">
                        Junior Engineer
                      </label>
                    </div>
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="checkbox" value="Senior Engineer" id="senior_engineer" name="allowed[]" {{ in_array("Senior Engineer", $keyPerformanceIndex->allowed) ? 'checked' : '' }}>
                      <label class="form-check-label" for="senior_engineer">
                        Senior Engineer
                      </label>
                    </div>
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="checkbox" value="Engineer" id="engineer" name="allowed[]" {{ in_array("Engineer", $keyPerformanceIndex->allowed) ? 'checked' : '' }}>
                      <label class="form-check-label" for="engineer">
                        Engineer
                      </label>
                    </div>
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="checkbox" value="Designer" id="designer" name="allowed[]" {{ in_array("Designer", $keyPerformanceIndex->allowed) ? 'checked' : '' }}>
                      <label class="form-check-label" for="designer">
                        Designer
                      </label>
                    </div>
                    <div class="form-check mr-3">
                      <input class="form-check-input" type="checkbox" value="Analyst" id="analyst" name="allowed[]" {{ in_array("Analyst", $keyPerformanceIndex->allowed) ? 'checked' : '' }}>
                      <label class="form-check-label" for="analyst">
                        Analyst
                      </label>
                    </div>
                  </div>
                  @error('area_id')
                    <span class="text-sm text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Submit </button>
                </div>
              </div>
              <!-- /.card -->
            </form>
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

@push('scripts')
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

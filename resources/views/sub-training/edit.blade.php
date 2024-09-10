@extends('master')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Training Status</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Training Status</h3>
            </div>

            <form role="form" action="{{ route('sub-training.update', $subTraining->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('put')

              <div class="card-body">
                <div class="form-group">
                  <label for="training">Training Name</label>
                  <input type="text" name="training" id="training" class="form-control" value="{{ $subTraining->training }}">
                </div>
                <div class="form-group">
                  <label for="area">Area</label>
                  <select class="form-control" name="area_id" onchange="fetchDataAndPopulate(this.value)">
                    <option>Select Area</option>
                    @foreach ($areas as $data)
                    <option value="{{$data->id}}" @selected($subTraining->employee->area->id == $data->id)>{{$data->area}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="employee">Employee</label>
                  <select class="form-control" name="user_id" id="employee">
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->id }}" @selected($subTraining->employee->id == $employee->id)>{{ $employee->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="certif_date">Certif Date</label>
                  <input type="date" class="form-control" name="certif_date" id="certif_date" value="{{ $subTraining->certif_date->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                  <label for="training_schedule">Training Schedule</label>
                  <input type="date" class="form-control" name="training_schedule" id="training_schedule" value="{{ $subTraining->training_schedule->format('Y-m-d') }}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@push('scripts')
<script>
  function fetchDataAndPopulate(selectedId) {
    const apiUrl = `/tambahmcu?id=${selectedId}`;

    fetch(apiUrl, {
        headers: {
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);

        const select2 = document.getElementById('employee');
        select2.innerHTML = '';

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

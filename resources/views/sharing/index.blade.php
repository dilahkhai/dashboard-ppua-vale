@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Sharing Schedule</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->

      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif

      @if(session()->has('fail'))
      <div class="alert alert-danger" role="alert">
        {{ session('fail') }}
      </div>
      @endif
    </div><!-- /.container-fluid -->
  </div>

  <div class="container">
    <div class="card">
      <div class="card-body">
        <div id="calendar"></div>
        <div class="row mt-3">
          <div class="col-md-3">
            @if (auth()->user()->role == 'admin')
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSchedule">
              Add Schedule
            </button>
            @endif
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addSchedule" tabindex="-1" aria-labelledby="addScheduleLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form action="{{ route('sharing-schedule.store') }}" method="post">
              @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addScheduleLabel">Add Schedule</h5>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Area</label>
                    <select class="form-control" name="area_id" onchange="fetchDataAndPopulate(this.value)">
                      <option>Select Area</option>
                      @foreach ($areas as $id => $data)
                      <option value="{{$data->id}}">{{$data->area}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Employee</label>
                    <select class="form-control" name="user_id" id="employee">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="sharing_date" id="date">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (auth()->user()->role == 'admin')
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('sharing-schedule.store-file') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Set Sharing File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="file">Date</label>
              <input type="text" name="sharing_date" class="form-control" id="sharing_date" readonly>
            </div>

            <div class="form-group">
              <label for="file">Employee</label>
              <input type="text" class="form-control" id="employee_detail" readonly>
            </div>

            <div class="form-group">
              <label for="file">File</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="file">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a href="" target="_blank" id="downloadFile" type="button" class="btn btn-success">Download</a>
            <button type="button" class="btn btn-danger" id="deleteSchedule">Delete</button>
            <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
          </div>
        </form>

        <form action="" method="post" id="deleteForm">
          @csrf
          @method('delete')
        </form>
      </div>
    </div>
  </div>
  @endif

  @if (auth()->user()->role == 'user')
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="modalContent">

      </div>
    </div>
  </div>
  @endif
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      events: '{{ route("sharing-schedule.source") }}',
      themeSystem: 'bootstrap',
      initialView: 'dayGridMonth',
      eventClick: function(info) {
        $('#exampleModal').modal()

        $.ajax({
          'url': `/sharing-schedule-source-detail?sharing_date=${new Date(info.event.start).toLocaleDateString()}`,
          'method': 'get',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          'success': function(response) {
            if (response?.isOwner) {
              $('#modalContent').empty()

              $('#modalContent').append(`<form action="{{ route('sharing-schedule.store-file') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Set Sharing File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="sharing_date" id="sharing_date">

                    <div class="form-group">
                      <label for="file">File</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="file">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="" target="_blank" id="ownerDownloadFile" type="button" class="btn btn-success">Download</a>
                    <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
                  </div>
                </form>
                `)

              if (response?.sharing?.file) {
                $(document).find('#ownerDownloadFile').attr('href', response?.sharing?.file).removeAttr('disabled').removeClass('btn-secondary').addClass('btn-success');
              } else {
                $(document).find('#ownerDownloadFile').removeAttr('href').removeClass('btn-success').addClass('btn-secondary');
              }
            } else {
              $('#modalContent').empty()

              $('#modalContent').append(`
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Download Sharing File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ${response?.sharing?.file ? `<a href="${response?.sharing?.file}" class="btn btn-primary" target="_blank">Dowload File</a>` : `<a href="#" class="btn btn-primary" target="_blank">No File</a>`}
                  </div>
                `)
            }

            $('#sharing_date').val(new Date(info.event.start).toLocaleDateString())
            $('#employee_detail').val(response?.sharing?.employee?.name)
            $('#deleteForm').attr('action', `/destroy-sharing-schedule/${response?.sharing?.id}`)
            if (response?.sharing?.file) {
              $('#downloadFile').attr('href', response?.sharing?.file).removeAttr('disabled').removeClass('btn-secondary').addClass('btn-success');
            } else {
              $('#downloadFile').removeAttr('href').removeClass('btn-success').addClass('btn-secondary');
            }

            $(document).on('click', '#deleteSchedule', function(e) {
              if (confirm('Do you want to delete this schedule?')) {
                $('#deleteForm').submit()
              }
            })
          },
          error: function(error) {
            console.error(error);
          }
        })
      },
      height: 'auto',
      firstDay: 5
    });
    calendar.render();

    $(document).on('change', 'input[type="file"]', function(e) {
      var fileName = e.target.files[0].name;
      $('.custom-file-label').html(fileName);
    });
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

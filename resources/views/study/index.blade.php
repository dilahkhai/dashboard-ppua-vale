@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Study Schedule</h1>
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
            <form action="{{ route('study-schedule.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addScheduleLabel">Add Schedule</h5>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="name">Subject</label>
                    <input type="text" class="form-control" name="name" id="name">
                  </div>
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="study_date" id="date">
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
      <div class="modal-content" id="modalContent">

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
      events: '{{ route("study-schedule.source") }}',
      themeSystem: 'bootstrap',
      initialView: 'dayGridMonth',
      eventClick: function(info) {
        $('#exampleModal').modal()

        $.ajax({
          'url': `/study-schedule-source-detail?study_date=${new Date(info.event.start).toLocaleDateString()}`,
          'method': 'get',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          'success': function(response) {
            if (response?.isOwner) {
              $('#modalContent').empty()
              $('#modalContent').append(`<form action="{{ route('study-schedule.update') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Set Study File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="study_date" id="study_date">

                    <div class="form-group">
                      <label for="study_date">Date</label>
                      <input type="date" name="study_date" class="form-control" id="study_date" value="${response?.study?.study_date}">
                    </div>

                    <div class="form-group">
                      <label for="name">Subject</label>
                      <input type="text" name="name" class="form-control" id="name" value="${response?.study?.name}">
                    </div>

                    <div class="form-group">
                      <label for="file">File</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="file">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                      </div>
                      <a href="${response?.study?.file}" target="_blank">${response?.study?.file || 'Please upload file!'}</a>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
                  </div>
                </form>
                `)
            } else {
              $('#modalContent').empty()
              $('#modalContent').append(`
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Study</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-2">
                        <p>Study Date</p>
                      </div>
                      <div class="col">
                        <p target="_blank">${response?.study?.date || 'dd/mm/yyyy'}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <p>Subject</p>
                      </div>
                      <div class="col">
                        <p target="_blank">${response?.study?.name || 'Subject'}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <p>file</p>
                      </div>
                      <div class="col">
                        <a href="${response?.study?.file}" class="btn btn-primary btn-sm" target="_blank">${response?.study?.file ? 'Download File' : "File hasn't uploaded yet!"}</a>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                `)
            }

            $('#study_date').val(new Date(info.event.start).toLocaleDateString())
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
@endpush

@endsection

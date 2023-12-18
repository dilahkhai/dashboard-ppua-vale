@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">WFH Rooster</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <div class="card">
    <div class="card-body">
      <div id="calendar"></div>
      <div class="row mt-3">
        <div class="col-md-3">
          @if (auth()->user()->role == 'admin')
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editInisial">
            Initial Detail
          </button>
          @endif
        </div>

        <div class="col">
          <div class="row">
            @foreach ($initialDetail as $initial)
            <div class="col-2">
              <div class="d-flex">
                <div>{{ $initial->initial }}</div>
                <div class="mx-1">=</div>
                <div>{{ $initial->detail }}</div>
                <form action="/wfh-initial-detail/{{ $initial->id }}" method="post">
                  @csrf
                  @method('delete')
                  <button type="submit" class="close" onclick="return confirm('Are you sure want to delete this data?')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </form>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="editInisial" tabindex="-1" aria-labelledby="editInisialLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="/wfh-initial-detail" method="post">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editInisialLabel">Add Initial Detail</h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="initial">Initial</label>
                  <input type="text" class="form-control" name="initial" id="initial-add">
                </div>
                <div class="form-group">
                  <label for="detail">Full Name</label>
                  <input type="text" class="form-control" name="detail" id="detail">
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

  @if (auth()->user()->role == 'admin')
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Set WFH Rooster</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="date_attended" id="date_attended">

          <div class="form-group">
            <label for="initial">Initial Name</label>
            <input type="text" class="form-control" id="initial">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
        </div>
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
      initialView: 'multiMonthYear',
      eventClick: function(info) {
        $('#exampleModal').modal('toggle');
        document.getElementById('date_attended').value = info.event.start.toISOString().split('T')[0]
        document.getElementById('initial').value = info.event.title
      },
      eventSources: {
        'url': '/wfhrooster-source'
      },
      height: 'auto'
    });
    calendar.render();

    document.getElementById('saveChanges').onclick = function() {
      $.ajax({
        'url': '/wfhrooster',
        'method': 'post',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'data': {
          initial: document.getElementById('initial').value,
          attended: document.getElementById('date_attended').value
        },
        'success': function(response) {
          $('#exampleModal').modal('hide')
          calendar.refetchEvents()
        },
        error: function(error) {
          console.error(error);
        }
      })
    }
  });
</script>
@endpush

@endsection

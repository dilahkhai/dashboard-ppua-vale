@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">OnCall Schedule</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="calendar"></div>

        <h5 class="mt-3">Initial Detail</h5>
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Employee</th>
                  <th scope="col">Initial</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($usersWithInitial as $user)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->initial }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
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
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Set On Call Automation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="date_attended" id="date_attended">

          <div class="form-group">
            <label for="user_id">Employee</label>
            <select class="form-control" id="user_id" name="user_id">
              <option value="">-- Select User --</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control" id="title" name="title" />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>

          <div class="form-group">
            <label for="file">File</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="file" name="file">
              <label class="custom-file-label" for="file">Choose file</label>
            </div>
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
      themeSystem: 'bootstrap',
      initialView: 'multiMonthYear',
      eventClick: function(info) {

      },
      height: 'auto',
      firstDay: 5
    });
    calendar.render();

    $(document).on('click', '#saveChanges', function() {
      let formData = new FormData()

      formData.append('user_id', document.getElementById('user_id').value)
      formData.append('attended', document.getElementById('date_attended').value)
      formData.append('title', document.getElementById('title').value)
      formData.append('description', document.getElementById('description').value)
      formData.append('file', document.getElementById('file').files[0])

      $.ajax({
        'url': '/oncall',
        'method': 'post',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        'success': function(response) {
          $('#exampleModal').modal('hide')
          calendar.render()

          $('.added-left').remove()
          $('.added-right').remove()

          $.ajax({
            'url': '/oncall-source',
            'method': 'get',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'success': function(response) {
              $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell"></th>');
              $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell"></th>');

              var week = 1;
              response.forEach((item, index) => {
                let td = $(`.fc-daygrid-day[data-date='${item.start}']`)

                if (td.length > 0) {
                  var newTd = document.createElement('td')
                  var button = document.createElement('button')

                  var weekTd = document.createElement('td')

                  button.classList = 'btn btn-primary btn-sm w-100 h-100';
                  button.innerText = item.title
                  button.onclick = function() {
                    $('#exampleModal').modal('toggle');
                    document.getElementById('date_attended').value = item.start
                    document.getElementById('user_id').value = item.title
                  }

                  newTd.append(button)
                  weekTd.append(`W${week++}`)

                  td[0].parentNode.append(weekTd);
                  td[0].parentNode.append(newTd);
                }
              })
            },
            error: function(error) {
              console.error(error);
            }
          })
        },
        error: function(error) {
          console.error(error);
        }
      })
    })

    $('.fc-prev-button').click(function() {
      var year = calendar.getDate().getYear()
      $.ajax({
        'url': '/oncall-source?year=' + year,
        'method': 'get',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success': function(response) {
          $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell added-right"></th>');
          $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell added-left"></th>');

          var week = 1;

          response.forEach((item, index) => {
            let td = $(`.fc-daygrid-day[data-date='${item.start}']`)

            if (td.length > 0) {
              var newTd = document.createElement('td')
              var button = document.createElement('button')

              var weekTd = document.createElement('td')

              newTd.classList = 'added-left'
              weekTd.classList = 'added-right'

              button.classList = 'btn btn-primary btn-sm w-100 h-100';
              button.innerText = item.title
              button.onclick = function() {
                $('#exampleModal').modal('toggle');
                document.getElementById('date_attended').value = item.start
                document.getElementById('user_id').value = item.title
              }

              newTd.append(button)
              weekTd.append(`W${week++}`)

              td[0].parentNode.append(weekTd);
              td[0].parentNode.append(newTd);
            }
          })
        },
        error: function(error) {
          console.error(error);
        }
      })
    })

    $('.fc-next-button').click(function() {
      var year = calendar.getDate().getYear()
      $.ajax({
        'url': '/oncall-source?year=' + year,
        'method': 'get',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success': function(response) {
          $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell added-right"></th>');
          $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell added-left"></th>');
          var week = 1;

          response.forEach((item, index) => {
            let td = $(`.fc-daygrid-day[data-date='${item.start}']`)

            if (td.length > 0) {
              var newTd = document.createElement('td')
              var button = document.createElement('button')

              var weekTd = document.createElement('td')

              newTd.classList = 'added-left'
              weekTd.classList = 'added-right'

              button.classList = 'btn btn-primary btn-sm w-100 h-100';
              button.innerText = item.title
              button.onclick = function() {
                $('#exampleModal').modal('toggle');
                document.getElementById('date_attended').value = item.start
                document.getElementById('user_id').value = item.title
              }

              newTd.append(button)
              weekTd.append(`W${week++}`)

              td[0].parentNode.append(weekTd);
              td[0].parentNode.append(newTd);
            }
          })
        },
        error: function(error) {
          console.error(error);
        }
      })
    })

    $.ajax({
      'url': '/oncall-source',
      'method': 'get',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      'success': function(response) {
        $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell added-left"></th>');
        $('.fc-col-header-cell.fc-day-sun').parent().append('<th role="columnheader" class="fc-col-header-cell added-right"></th>');
        var week = 1;
        response.forEach((item, index) => {
          let td = $(`.fc-daygrid-day[data-date='${item.start}']`)

          if (td.length > 0) {
            var newTd = document.createElement('td')
            var button = document.createElement('button')

            var weekTd = document.createElement('td')

            newTd.classList = 'added-left'
            weekTd.classList = 'added-right'

            button.classList = 'btn btn-primary btn-sm w-100 h-100';
            button.innerText = item.title
            button.onclick = function() {
              if (item.title != '-') {
                window.location = '/oncall-detail?date=' + item.start
              } else {
                $('#exampleModal').modal('toggle');
                document.getElementById('date_attended').value = item.start
                document.getElementById('user_id').value = item.title
              }
            }

            newTd.append(button)
            weekTd.append(`W${week++}`)

            td[0].parentNode.append(weekTd);
            td[0].parentNode.append(newTd);
          }
        })

        $('.fc-multimonth-daygrid-table').each(function(i, el) {
          let tr = el.getElementsByTagName('tr');
          for (let i = 0; i < tr.length; i++) {
            if (tr[i].getElementsByTagName('td').length === 7) {
              var newTd = document.createElement('td')
              var newTd2 = document.createElement('td')
              newTd.classList = 'fc-day fc-day-fri fc-day-disabled fc-daygrid-day'
              newTd2.classList = 'fc-day fc-day-fri fc-day-disabled fc-daygrid-day'
              tr[i].append(newTd)
              tr[i].append(newTd2)
            }
          }
        });
      },
      error: function(error) {
        console.error(error);
      }
    })

    $(document).on('change', 'input[type="file"]', function(e) {
      var fileName = e.target.files[0].name;
      $('.custom-file-label').html(fileName);
    });
  });
</script>
@endpush

@endsection

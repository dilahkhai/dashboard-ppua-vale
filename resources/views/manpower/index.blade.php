@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Export Excel File</h1>
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
    <div class="row">
      @foreach ($areas as $area)
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">{{ $area->area }}</div>
          <div class="card-body">
            <div class="form-group">
              <label for="">Leader</label>
              <input type="text" class="form-control">
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
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>UTW - Medical Recomm</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>Quarantine</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>Leave</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>Sick Leave</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>Control MCU</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>OT Hours</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>OT</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>Total Man Power</td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                  <td>
                    <input type="text" class="form-control">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endforeach
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
@endpush


@endsection

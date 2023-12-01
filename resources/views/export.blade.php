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
    <div class="card">
      <div class="card-header">Export Data</div>
      <div class="card-body">
        @if(Auth::user()->role=='admin')
        <form role="form" action="/export-excel" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-3">
              <label for="dateInput">From</label>
            </div>
            <div class="col-md-3">
              <label for="dateInput">To</label>
            </div>
            <div class="col-md-3">
              <label for="dateInput">Area</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <input type="date" name="from" class="form-control" id="dateInput">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <input type="date" name="to" class="form-control" id="dateInput">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <select class="form-control" name="area_id">
                  @foreach ($areas as $data)
                  <option value="{{$data->id}}">{{$data->area}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-3">
              <button type="submit" class="btn btn-primary">Submit </button>
            </div>
          </div>
        </form>
        @endif
      </div>
    </div>
    <!-- right col -->
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

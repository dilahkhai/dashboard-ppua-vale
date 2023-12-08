@extends('master')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Image Landing Page</h1>
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <section class="content">
    <div class="card">
      <div class="card-header">Furnance Converter</div>
      <!-- Calendar -->
      <div class="card-body">
        <img class="mb-3 w-50" style="aspect-ratio: 2 / 1;" src="{{$furconv?->file}}" width="100%" alt="not found!">
        @if(Auth::user()->role=='admin')
        <form role="form" action="{{url('image-landing')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="furconv">
          <div class="row">
            <div class="col-lg-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fileupload" required id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div class="invalid-feedback">Example invalid custom file feedback</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit </button>
          </div>
        </form>
        @endif
      </div>
    </div>
    <div class="card">
      <div class="card-header">Dryer Klin</div>
      <!-- Calendar -->
      <div class="card-body">
        <img class="mb-3 w-50" style="aspect-ratio: 2 / 1;" src="{{$dryer?->file}}" width="100%" alt="not found!">
        @if(Auth::user()->role=='admin')
        <form role="form" action="{{url('image-landing')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="dryer">
          <div class="row">
            <div class="col-lg-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fileupload" required id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div class="invalid-feedback">Example invalid custom file feedback</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit </button>
          </div>
        </form>
        @endif
      </div>
    </div>
    <div class="card">
      <div class="card-header">Infrastructure</div>
      <!-- Calendar -->
      <div class="card-body">
        <img class="mb-3 w-50" style="aspect-ratio: 2 / 1;" src="{{$infra?->file}}" width="100%" alt="not found!">
        @if(Auth::user()->role=='admin')
        <form role="form" action="{{url('image-landing')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="infra">
          <div class="row">
            <div class="col-lg-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fileupload" required id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div class="invalid-feedback">Example invalid custom file feedback</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit </button>
          </div>
        </form>
        @endif
      </div>
    </div>
    <div class="card">
      <div class="card-header">Utilities</div>
      <!-- Calendar -->
      <div class="card-body">
        <img class="mb-3 w-50" style="aspect-ratio: 2 / 1;" src="{{$util?->file}}" width="100%" alt="not found!">
        @if(Auth::user()->role=='admin')
        <form role="form" action="{{url('image-landing')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="util">
          <div class="row">
            <div class="col-lg-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fileupload" required id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div class="invalid-feedback">Example invalid custom file feedback</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit </button>
          </div>
        </form>
        @endif
      </div>
    </div>
  </section>
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

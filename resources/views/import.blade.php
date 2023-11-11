@extends('master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Import Excel File</h1>
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
            <div class="card-body">
              @if(Auth::user()->role=='admin')
                <form role="form" action="{{url('importData')}}"  method="POST" enctype="multipart/form-data"  >
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="validatedCustomFile" required>
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit </button>
                  </form>
                @endif
            </div>
            <!-- /.card -->

          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    @push('scripts')
        <script type="application/javascript">
            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            });
        </script>
    @endpush


@endsection

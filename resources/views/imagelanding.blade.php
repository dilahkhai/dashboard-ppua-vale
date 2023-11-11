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
      <div class="container-fluid">
            <!-- Calendar -->
            <div class="card-body">
              @if(Auth::user()->role=='admin')
                <form role="form" action="{{url('image-landing')}}"  method="POST" enctype="multipart/form-data"  >
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="fileupload" required id="validatedCustomFile" required>
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit </button>
                  </form>
                @endif
            </div>
            <br>

            <div class="container-fluid">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                           @isset($image)
                              <img src="{{$image->file}}" width="100%" alt="not found!">
                            @endisset
                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
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

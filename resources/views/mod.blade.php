@extends('master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">MOD</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
            <!-- Calendar -->
            <div class="card bg-gradient-success">
                <div class="card-header border-0">

                  <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                  </h3>

                  <!-- tools card -->
                  <div class="card-tools">
                    <!-- button with a dropdown -->
                     {{-- <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                        <i class="fas fa-bars"></i>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a href="#" class="dropdown-item">Add new event</a>
                        <a href="#" class="dropdown-item">Clear events</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">View calendar</a>

                      </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button> --}}
                  </div>
                  <!-- /. tools -->
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div>
                <!-- /.card-body -->
              </div>
            <div class="card-body">
              @if(Auth::user()->role=='admin')
                <form role="form" action="{{url('mod')}}"  method="POST" enctype="multipart/form-data"  >
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
                           @isset($mod)
                              <img src="{{$mod->file}}" width="100%" alt="not found!">
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
